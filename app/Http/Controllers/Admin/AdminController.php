<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\User;
use App\Models\Workout;
use App\Models\WaterIntake;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * Admin dashboard
     */
   public function dashboard()
{
    $totalUsers = User::where('role', 'user')->count();

    $newUsersThisWeek = User::where('role', 'user')
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->count();

    $totalWorkouts = Workout::count();

    $totalWaterLogs = WaterIntake::count();

    $activeGoals = Goal::where('status', 'active')->count();

    $completedGoals = Goal::where('status', 'completed')->count();

    $mostActiveUsers = User::where('role', 'user')
        ->withCount('workouts')
        ->orderByDesc('workouts_count')
        ->take(5)
        ->get();

    $recentUsers = User::where('role', 'user')
        ->latest()
        ->take(8)
        ->get();

    $categoryBreakdown = Workout::selectRaw('category, COUNT(*) as total')
        ->groupBy('category')
        ->pluck('total', 'category');

    // Users for the Premium management section
    $users = User::where('role', 'user')
        ->withCount('workouts', 'goals')
        ->latest()
        ->paginate(15);

    return view('admin.dashboard', compact(
        'totalUsers',
        'newUsersThisWeek',
        'totalWorkouts',
        'totalWaterLogs',
        'activeGoals',
        'completedGoals',
        'mostActiveUsers',
        'recentUsers',
        'categoryBreakdown',
        'users'
    ));
}

    /**
     * Admin users list
     */
    public function users()
    {
        $users = User::where('role', 'user')
            ->withCount('workouts', 'goals')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('users'));
    }

    /**
     * Delete a user
     */
    public function destroyUser(User $user)
    {
        abort_if(
            $user->isAdmin(),
            403,
            'Cannot delete an admin.'
        );

        $user->delete();

        return back()->with(
            'status',
            'User removed.'
        );
    }

    /**
     * Toggle Premium Demo Mode
     */
    public function togglePremium(User $user)
    {
        // Only administrators can use this
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // Prevent changing another admin
        if ($user->isAdmin()) {
            abort(
                403,
                'Cannot change Premium status of an admin.'
            );
        }

        if ($user->is_premium) {

            // Disable Premium
            $user->is_premium = false;
            $user->premium_expires_at = null;

            $message = "{$user->name}'s Premium has been deactivated.";

        } else {

            // Activate Premium for 30 days
            $user->is_premium = true;
            $user->premium_expires_at = Carbon::now()->addDays(30);

            $message = "{$user->name} is now a Premium member for 30 days.";
        }

        $user->save();

        return back()->with('status', $message);
    }
}