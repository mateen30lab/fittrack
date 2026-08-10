<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'height_cm' => ['nullable', 'numeric', 'min:50', 'max:260'],
            'weight_kg' => ['nullable', 'numeric', 'min:20', 'max:400'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'age' => $validated['age'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'height_cm' => $validated['height_cm'] ?? null,
            'weight_kg' => $validated['weight_kg'] ?? null,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Welcome to FitTrack, ' . $user->name . '!');
    }
}
