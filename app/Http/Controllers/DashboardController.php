<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $weekStart = $today->copy()->startOfWeek();

        $weeklyWorkouts = $user->workouts()
            ->whereBetween('performed_on', [$weekStart, $today])
            ->get();

        $todayWater = $user->waterIntakes()
            ->whereDate('logged_on', $today)
            ->sum('amount_ml');

        $waterGoalMl = 2500;

        $activeGoals = $user->goals()->where('status', 'active')->latest()->take(3)->get();

        $recentWorkouts = $user->workouts()->latest('performed_on')->take(5)->get();

        $last7DaysProgress = $user->dailyProgress()
            ->whereBetween('log_date', [$today->copy()->subDays(6), $today])
            ->orderBy('log_date')
            ->get();

        return view('dashboard', [
            'user' => $user,
            'weeklyWorkoutCount' => $weeklyWorkouts->count(),
            'weeklyCalories' => $weeklyWorkouts->sum('calories_burned'),
            'weeklyMinutes' => $weeklyWorkouts->sum('duration_minutes'),
            'todayWater' => $todayWater,
            'waterGoalMl' => $waterGoalMl,
            'activeGoals' => $activeGoals,
            'recentWorkouts' => $recentWorkouts,
            'progressSeries' => $last7DaysProgress,
        ]);
    }
}
