<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Dashboard statistics (replace with real queries later if needed)
        $calories = 2450;
        $water = 17;
        $workouts = 29;
        $fitnessScore = 87;
        $streak = 12;

        // Weekly chart data
        $calorieData = [320, 410, 530, 610, 720, 690, 820];
        $waterData = [1.5, 2.4, 2.3, 2.1, 3.2, 3.4, 3.0];
        $weightData = [82, 81.9, 81.8, 81.5, 81.3, 80.9, 80.7];

        $goalData = [
            'completed' => 87,
            'remaining' => 13,
        ];

        // LIVE LEADERBOARD
        $leaderboard = User::all()->map(function ($user) {

            $score = 0;

            // Workout points
            $score += $user->workouts()->count() * 50;

            // Water intake points
            $score += $user->waterIntakes()->count() * 10;

            // Goal points
            $completedGoals = $user->goals->filter(function ($goal) {
    return $goal->current_value >= $goal->target_value;
})->count();

$score += $completedGoals * 100;

            // Daily progress points
            $score += $user->dailyProgress()->count() * 30;

            // BMI bonus
            if ($user->bmi) {
                $score += 20;
            }

            return [
                'name' => $user->name,
                'score' => $score,
                'premium' => $user->hasPremium(),
            ];

        })
        ->sortByDesc('score')
        ->values();

        return view('analytics.index', compact(
            'calories',
            'water',
            'workouts',
            'fitnessScore',
            'streak',
            'calorieData',
            'waterData',
            'weightData',
            'goalData',
            'leaderboard'
        ));
    }
}