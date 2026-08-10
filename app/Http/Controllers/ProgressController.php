<?php

namespace App\Http\Controllers;

use App\Models\DailyProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $entries = $user->dailyProgress()->orderByDesc('log_date')->take(30)->get();

        $chartData = $entries->sortBy('log_date')->values()->map(function ($e) {
            return [
                'date' => $e->log_date->format('M j'),
                'weight' => $e->weight_kg,
                'steps' => $e->steps,
            ];
        });

        return view('progress.index', compact('entries', 'chartData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_date' => ['required', 'date'],
            'weight_kg' => ['nullable', 'numeric', 'min:20', 'max:400'],
            'steps' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'sleep_minutes' => ['nullable', 'integer', 'min:0', 'max:1440'],
            'mood' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $validated['user_id'] = Auth::id();

        DailyProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'log_date' => $validated['log_date']],
            $validated
        );

        return back()->with('status', 'Daily progress saved.');
    }
}
