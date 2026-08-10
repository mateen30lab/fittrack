<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    public function index()
    {
        $workouts = Auth::user()->workouts()->latest('performed_on')->paginate(10);
        return view('workouts.index', compact('workouts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:cardio,strength,flexibility,sports,other'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'calories_burned' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'performed_on' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['calories_burned'] = $validated['calories_burned'] ?? 0;

        Workout::create($validated);

        return back()->with('status', 'Workout logged. Nice work!');
    }

    public function destroy(Workout $workout)
    {
        abort_unless($workout->user_id === Auth::id(), 403);
        $workout->delete();
        return back()->with('status', 'Workout removed.');
    }
}
