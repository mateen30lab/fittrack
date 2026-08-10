@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Welcome back, ' . explode(' ', $user->name)[0])
@section('page-sub', now()->format('l, F j'))

@section('content')

<div class="grid grid-4 mb-16">
    <div class="card stat-card" style="animation-delay:.02s">
        <div class="card-title">
            This Week
            <div class="icon-badge pulse">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5 3 10l4 4 3.5-3.5m3 3 3.5-3.5 4 4-3.5 3.5m-8.5-8.5 8.5 8.5"/></svg>
            </div>
        </div>
        <div class="stat-value accent-pulse">{{ $weeklyWorkoutCount }}<span class="unit">workouts</span></div>
        <div class="text-sm text-dim mt-8">{{ $weeklyMinutes }} minutes total</div>
    </div>

    <div class="card stat-card" style="animation-delay:.08s">
        <div class="card-title">
            Calories Burned
            <div class="icon-badge signal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2s5 5.5 5 10a5 5 0 0 1-10 0c0-1.2.5-2.2 1-3 .3 1 1 1.5 1.5 1.2-.3-2 .5-4 2.5-5.5C11.6 6 12 4 12 2Z"/></svg>
            </div>
        </div>
        <div class="stat-value accent-signal">{{ number_format($weeklyCalories) }}<span class="unit">kcal</span></div>
        <div class="text-sm text-dim mt-8">this week</div>
    </div>

    <div class="card stat-card" style="animation-delay:.14s">
        <div class="card-title">
            Hydration Today
            <div class="icon-badge hydro">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5s7 7.6 7 12.5a7 7 0 1 1-14 0c0-4.9 7-12.5 7-12.5Z"/></svg>
            </div>
        </div>
        <div class="stat-value accent-hydro">{{ number_format($todayWater) }}<span class="unit">/ {{ $waterGoalMl }} ml</span></div>
        <div class="text-sm text-dim mt-8">{{ min(100, round($todayWater / $waterGoalMl * 100)) }}% of daily goal</div>
    </div>

    <div class="card stat-card" style="animation-delay:.2s">
        <div class="card-title">
            BMI
            <div class="icon-badge violet">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            </div>
        </div>
        @if($user->bmi)
            <div class="stat-value accent-violet">{{ $user->bmi }}<span class="unit">{{ $user->bmi_category }}</span></div>
            <div class="text-sm text-dim mt-8"><a href="{{ route('bmi.index') }}" style="color:var(--violet);">Recalculate →</a></div>
        @else
            <div class="stat-value text-dim" style="font-size:16px;">Not set</div>
            <div class="text-sm text-dim mt-8"><a href="{{ route('bmi.index') }}" style="color:var(--violet);">Calculate now →</a></div>
        @endif
    </div>
</div>

<div class="grid grid-3">
    <div class="card" style="animation-delay:.26s">
        <div class="card-title">Hydration Level</div>
        <div class="flex" style="flex-direction:column; align-items:center; padding: 8px 0;">
            <div class="water-glass">
                <div class="water-fill" data-percent="{{ min(100, round($todayWater / $waterGoalMl * 100)) }}"></div>
            </div>
            <div class="mt-16 text-sm text-dim">{{ number_format($todayWater) }} ml logged today</div>
            <a href="{{ route('water.index') }}" class="btn btn-hydro btn-sm mt-16">Log water</a>
        </div>
    </div>

    <div class="card" style="animation-delay:.32s">
        <div class="card-title">Active Goals</div>
        @forelse($activeGoals as $goal)
            <div style="margin-bottom:16px;">
                <div class="flex justify-between text-sm" style="margin-bottom:6px;">
                    <span style="font-weight:600;">{{ $goal->title }}</span>
                    <span class="text-dim">{{ $goal->current_value }} / {{ $goal->target_value }} {{ $goal->unit }}</span>
                </div>
                <div style="height:8px; background:var(--surface-3); border-radius:999px; overflow:hidden;">
                    <div class="goal-progress" data-percent="{{ $goal->progress_percent }}" style="width:{{ $goal->progress_percent }}%; height:100%; border-radius:999px;"></div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="padding:20px 0;">
                <div class="text-sm">No active goals yet.</div>
                <a href="{{ route('goals.index') }}" class="btn btn-ghost btn-sm mt-16">Set a goal</a>
            </div>
        @endforelse
        @if($activeGoals->isNotEmpty())
            <a href="{{ route('goals.index') }}" class="btn btn-ghost btn-sm w-full mt-8">View all goals</a>
        @endif
    </div>

    <div class="card" style="animation-delay:.38s">
        <div class="card-title">Recent Workouts</div>
        @forelse($recentWorkouts as $workout)
            <div class="list-row" style="padding-left:0; padding-right:0;">
                <div class="icon-badge {{ $workout->category === 'cardio' ? 'pulse' : ($workout->category === 'strength' ? 'violet' : ($workout->category === 'flexibility' ? 'hydro' : 'signal')) }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5 3 10l4 4 3.5-3.5m3 3 3.5-3.5 4 4-3.5 3.5m-8.5-8.5 8.5 8.5"/></svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:600; font-size:13.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $workout->title }}</div>
                    <div class="text-dim" style="font-size:12px;">{{ $workout->performed_on->format('M j') }} · {{ $workout->duration_minutes }} min</div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="padding:20px 0;">
                <div class="text-sm">No workouts logged yet.</div>
                <a href="{{ route('workouts.index') }}" class="btn btn-ghost btn-sm mt-16">Log a workout</a>
            </div>
        @endforelse
    </div>
</div>

<div class="card mt-24" style="animation-delay:.44s">
    <div class="card-title">7-Day Weight Trend</div>
    @if($progressSeries->count() > 0)
        <div class="bar-chart mt-16">
            @foreach($progressSeries as $entry)
                @php
                    $max = $progressSeries->max('weight_kg') ?: 1;
                    $pct = $entry->weight_kg ? round(($entry->weight_kg / $max) * 100) : 0;
                @endphp
                <div class="bar-col">
                    <div class="bar" data-percent="{{ $pct }}" style="height:{{ $pct }}%;"></div>
                    <div class="bar-label">{{ $entry->log_date->format('D') }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="text-sm">No progress logged this week yet.</div>
            <a href="{{ route('progress.index') }}" class="btn btn-ghost btn-sm mt-16">Log today's progress</a>
        </div>
    @endif
</div>

@endsection
