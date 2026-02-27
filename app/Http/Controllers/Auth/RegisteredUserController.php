<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grade;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $grades = Grade::all();
        return view('auth.register', compact('grades'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:teacher,student'],
            'email' => ['nullable', 'required_if:role,teacher', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'student_id' => ['nullable', 'required_if:role,student', 'string', 'max:255', 'unique:' . User::class],
            'grade_id' => ['nullable', 'required_if:role,student', 'exists:grades,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'grade_id' => $request->grade_id,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'teacher') {
            return redirect()->route('dashboard'); // Assuming teacher dashboard is same or has different view
        }

        return redirect()->route('dashboard');
    }
}
