<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Grade;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard(Request $request)
    {
        if (auth()->user()->role !== 'teacher') {
            return redirect()->route('student.dashboard');
        }

        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $gradeId = $request->input('grade_id');

        $books = Book::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%");
            });
        })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($gradeId, function ($query, $gradeId) {
                return $query->whereHas('grades', function ($q) use ($gradeId) {
                    $q->where('grades.id', $gradeId);
                });
            })
            ->get();

        $students = User::where('role', 'student')->get();
        $categories = Category::all();
        $grades = Grade::all();

        return view('teacher.dashboard', compact('books', 'students', 'categories', 'grades'));
    }

    public function showStudentProgress(User $student)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $progress = $student->readingProgress()
            ->with('book')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('teacher.student-progress', compact('student', 'progress'));
    }
}
