<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->goals()->latest()->get();
        return view('goals.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:weight,workouts,water,steps,custom'],
            'target_value' => ['required', 'numeric', 'min:0.01'],
            'current_value' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:20'],
            'target_date' => ['nullable', 'date'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_value'] = $validated['current_value'] ?? 0;

        Goal::create($validated);

        return back()->with('status', 'Goal created. Go get it!');
    }

    public function update(Request $request, Goal $goal)
    {
        abort_unless($goal->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'current_value' => ['required', 'numeric', 'min:0'],
        ]);

        $goal->current_value = $validated['current_value'];
        if ($goal->current_value >= $goal->target_value) {
            $goal->status = 'completed';
        }
        $goal->save();

        return back()->with('status', 'Goal updated.');
    }

    public function destroy(Goal $goal)
    {
        abort_unless($goal->user_id === Auth::id(), 403);
        $goal->delete();
        return back()->with('status', 'Goal removed.');
    }
}
