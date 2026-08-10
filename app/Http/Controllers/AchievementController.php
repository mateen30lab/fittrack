<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $badges = [];

        if ($user->workouts()->count() >= 1) {
            $badges[] = [
                'icon' => '🥇',
                'title' => 'First Workout',
                'description' => 'Completed your first workout.'
            ];
        }

        if ($user->workouts()->count() >= 50) {
            $badges[] = [
                'icon' => '💪',
                'title' => 'Gym Beast',
                'description' => 'Completed 50 workouts.'
            ];
        }

        if ($user->waterIntakes()->count() >= 30) {
            $badges[] = [
                'icon' => '💧',
                'title' => 'Hydration Hero',
                'description' => 'Logged water 30 times.'
            ];
        }

        if ($user->hasPremium()) {
            $badges[] = [
                'icon' => '👑',
                'title' => 'Premium Member',
                'description' => 'Unlocked Premium.'
            ];
        }

        return view('achievements.index', compact('badges'));
    }
}
