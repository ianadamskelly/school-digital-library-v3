<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function storeStudent(Request $request)
    {
        if (auth()->user()->role !== 'teacher') {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id'],
            'grade_id' => ['required', 'exists:grades,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'grade_id' => $request->grade_id,
            'role' => 'student',
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'student-registered');
    }
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

        $allStudents = User::where('role', 'student')->with('grade')->get();
        $studentsWithRecommendations = User::where('role', 'student')
            ->with(['grade', 'readingProgress.book'])
            ->whereHas('recommendations', function ($query) {
            $query->where('teacher_id', auth()->id());
        })
            ->get();

        $categories = Category::all();
        $grades = Grade::all();

        return view('teacher.dashboard', compact('books', 'allStudents', 'studentsWithRecommendations', 'categories', 'grades'));
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
