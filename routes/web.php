<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');

    // Dashboard Redirects
    Route::get('/student/dashboard', [\App\Http\Controllers\StudentController::class , 'dashboard'])->name('student.dashboard');
    Route::get('/teacher/dashboard', [\App\Http\Controllers\TeacherController::class , 'dashboard'])->name('teacher.dashboard');
    Route::post('/teacher/students', [\App\Http\Controllers\TeacherController::class , 'storeStudent'])->name('teacher.students.store');
    Route::get('/teacher/students/{student}/progress', [\App\Http\Controllers\TeacherController::class , 'showStudentProgress'])->name('teacher.students.progress');

    // Student Reader Routes
    Route::get('/books/{book}', [\App\Http\Controllers\StudentController::class , 'showReader'])->name('reader');
    Route::get('/books/{book}/stream', [\App\Http\Controllers\StudentController::class , 'streamBook'])->name('books.stream');
    Route::post('/books/{book}/progress', [\App\Http\Controllers\StudentController::class , 'updateProgress'])->name('progress.update');
    Route::post('/books', [\App\Http\Controllers\BookController::class , 'store'])->name('books.store');
    Route::delete('/books/{book}', [\App\Http\Controllers\BookController::class , 'destroy'])->name('books.destroy');

    // Recommendation Routes
    Route::post('/recommendations', [\App\Http\Controllers\RecommendationController::class , 'store'])->name('recommendations.store');
});

require __DIR__ . '/auth.php';
