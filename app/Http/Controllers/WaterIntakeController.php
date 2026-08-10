<?php

namespace App\Http\Controllers;

use App\Models\WaterIntake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class WaterIntakeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        $todayLogs = $user->waterIntakes()->whereDate('logged_on', $today)->orderByDesc('logged_at')->get();
        $todayTotal = $todayLogs->sum('amount_ml');
        $goalMl = 2500;

        $weekly = $user->waterIntakes()
            ->whereBetween('logged_on', [$today->copy()->subDays(6), $today])
            ->get()
            ->groupBy(fn ($row) => $row->logged_on->format('Y-m-d'))
            ->map(fn ($rows) => $rows->sum('amount_ml'));

        return view('water.index', compact('todayLogs', 'todayTotal', 'goalMl', 'weekly'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount_ml' => ['required', 'integer', 'min:50', 'max:2000'],
        ]);

        WaterIntake::create([
            'user_id' => Auth::id(),
            'amount_ml' => $validated['amount_ml'],
            'logged_on' => Carbon::today(),
            'logged_at' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('status', 'Hydration logged.');
    }

    public function destroy(WaterIntake $waterIntake)
    {
        abort_unless($waterIntake->user_id === Auth::id(), 403);
        $waterIntake->delete();
        return back()->with('status', 'Entry removed.');
    }
}
