<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ReadingProgress;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();

        // Ensure only students can access the student dashboard
        if ($user->role !== 'student') {
            return redirect()->route('teacher.dashboard');
        }

        $completedBooksCount = $user->booksCompletedThisYear();

        // Fetch recommendations for this student with teacher and book
        $recommendations = \App\Models\Recommendation::where('student_id', $user->id)
            ->with(['book', 'teacher'])
            ->latest()
            ->get();

        $inProgressBooks = $user->readingProgress()
            ->where('is_completed', false)
            ->with('book')
            ->get();

        // Fetch some recommended books with filtering
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $gradeId = $request->input('grade_id', $user->grade_id);

        $recommendedBooks = \App\Models\Book::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('author', 'LIKE', "%{$search}%");
                }
                );
            })
            ->when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
            ->when($gradeId, function ($query, $gradeId) {
            return $query->whereHas('grades', function ($q) use ($gradeId) {
                    $q->where('grades.id', $gradeId);
                }
                );
            })
            ->get();

        $categories = \App\Models\Category::all();
        $grades = \App\Models\Grade::all();

        return view('student.dashboard', compact('completedBooksCount', 'recommendations', 'inProgressBooks', 'recommendedBooks', 'categories', 'grades'));
    }

    public function showReader(Book $book)
    {
        // Find or create a progress record for this student/book
        $progress = ReadingProgress::firstOrCreate(
        ['user_id' => auth()->id(), 'book_id' => $book->id],
        ['current_page' => 1]
        );

        return view('student.reader', compact('book', 'progress'));
    }

    public function streamBook(Book $book)
    {
        $disk = Storage::disk('google');

        if (!$disk->exists($book->google_drive_id)) {
            return response()->json(['error' => 'The PDF file could not be found in Google Drive. Please re-upload the book.'], 404);
        }

        // Return a streamed response for better performance and security
        return response()->stream(function () use ($disk, $book) {
            $stream = $disk->readStream($book->google_drive_id);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . addslashes($book->title) . '.pdf"',
        ]);
    }

    public function updateProgress(Request $request, Book $book)
    {
        $progress = ReadingProgress::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        $currentPage = $request->page;
        $percentage = ($currentPage / $book->total_pages) * 100;

        $isCompleted = ($currentPage >= $book->total_pages);

        $progress->update([
            'current_page' => $currentPage,
            'percentage' => $percentage,
            'is_completed' => $isCompleted,
            'completed_at' => $isCompleted ? now() : $progress->completed_at
        ]);

        return response()->json(['success' => true]);
    }
}
