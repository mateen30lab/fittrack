<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'gender' => ['nullable', 'in:male,female,other'],
            'height_cm' => ['nullable', 'numeric', 'min:50', 'max:260'],
            'weight_kg' => ['nullable', 'numeric', 'min:20', 'max:400'],
            'activity_level' => ['nullable', 'in:sedentary,light,moderate,active,very_active'],
        ]);

        $user->update($validated);

        return back()->with('status', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Password changed.');
    }
}
