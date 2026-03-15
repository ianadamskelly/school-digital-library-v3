<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Smalot\PdfParser\Parser;

class BookController extends Controller
{
    public function create(): View
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        return view('teacher.books.create', [
            'categories' => Category::query()->orderBy('name')->get(),
            'grades' => Grade::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id',
            'grades' => 'required|array',
            'grades.*' => 'exists:grades,id',
            'pdf_file' => 'required|mimes:pdf|max:10000',
            'cover_image' => 'nullable|image|max:2000',
        ]);

        $parser = new Parser;
        $pdf = $parser->parseFile($request->file('pdf_file')->path());
        $totalPages = count($pdf->getPages());

        $pdfPath = $request->file('pdf_file')->store('books/pdfs', 'public');
        $coverImagePath = $request->file('cover_image')?->store('books/covers', 'public');

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category_id,
            'google_drive_id' => $pdfPath,
            'total_pages' => $totalPages,
            'cover_image' => $coverImagePath,
        ]);

        $book->grades()->sync($request->grades);

        return redirect()
            ->route('teacher.dashboard')
            ->with('success', 'Book uploaded successfully!');
    }

    public function destroy(Book $book)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        if ($book->google_drive_id) {
            Storage::disk('public')->delete($book->google_drive_id);
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return back()->with('success', 'Book and associated file deleted successfully!');
    }
}
