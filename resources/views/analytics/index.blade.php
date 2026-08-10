@extends('layouts.app')

@section('title','Premium Analytics')
@section('page-title','📊 Premium Analytics')
@section('page-sub','Advanced Fitness Intelligence')

@section('content')

<link rel="stylesheet" href="{{ asset('css/analytics.css') }}">

<div class="analytics-page">

    <!-- HERO -->

    <div class="analytics-header">

        <div>

            <h2>Weekly Performance</h2>

            <p>Your fitness progress powered by AI</p>

        </div>

        <div class="premium-pill">

            👑 Premium

        </div>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <small>Calories Burned</small>

            <h2>{{ $calories }}</h2>

            <span>🔥 This Week</span>

        </div>

        <div class="stat-card">

            <small>Water Intake</small>

            <h2>{{ $water }} L</h2>

            <span>💧 Hydration</span>

        </div>

        <div class="stat-card">

            <small>Workouts</small>

            <h2>{{ $workouts }}</h2>

            <span>🏋 Sessions</span>

        </div>

        <div class="stat-card">

            <small>Fitness Score</small>

            <h2>{{ $fitnessScore }}</h2>

            <span>⭐ Excellent</span>

        </div>

    </div>

    <!-- CHARTS -->

    <div class="charts-grid">

        <div class="chart-card">

            <h3>🔥 Calories</h3>

            <canvas id="calorieChart"></canvas>

        </div>

        <div class="chart-card">

            <h3>💧 Hydration</h3>

            <canvas id="waterChart"></canvas>

        </div>

        <div class="chart-card">

            <h3>⚖ Weight Trend</h3>

            <canvas id="weightChart"></canvas>

        </div>

        <div class="chart-card">

            <h3>🎯 Goal Completion</h3>

            <canvas id="goalChart"></canvas>

        </div>

    </div>

    <!-- BOTTOM -->

 <div class="bottom-grid">

    <div class="insight-card">

        <h2>🤖 AI Fitness Coach</h2>

        <p>

            You completed

            <strong>{{ $workouts }}</strong>

            workouts this week.

        </p>

        <p>

            Hydration is

            <strong>{{ $water }}L</strong>

            which is improving steadily.

        </p>

        <p>

            Keep your streak alive tomorrow to reach

            Elite Athlete status.

        </p>

        <button class="ai-btn">

            Generate Full AI Report

        </button>

    </div>

    <div class="fitness-ring-card">

        <h3>Fitness Score</h3>

        <div class="fitness-circle">

            <svg>

                <circle class="bg" cx="90" cy="90" r="70"></circle>

                <circle

                    class="progress"

                    cx="90"

                    cy="90"

                    r="70"

                    data-score="{{ $fitnessScore }}">

                </circle>

            </svg>

            <div class="score-text">

                {{ $fitnessScore }}

            </div>

        </div>

    </div>

</div>
</div>
<!-- AI REPORT MODAL -->

<div id="aiModal" class="ai-modal">

    <div class="ai-modal-content">

        <div class="ai-top">

            <h2>🤖 AI Fitness Report</h2>

            <button id="closeAI">✕</button>

        </div>

        <div id="aiReport">

            <div class="typing-loader">

                <span></span>
                <span></span>
                <span></span>

            </div>

        </div>

    </div>

</div>
<div class="achievement-section">

    <h2>🏆 Achievements</h2>

    <div class="achievement-grid">

        <div class="achievement-card unlocked">
            <div class="icon">🔥</div>
            <h4>7 Day Streak</h4>
            <p>Workout for 7 consecutive days.</p>
        </div>

        <div class="achievement-card unlocked">
            <div class="icon">💧</div>
            <h4>Hydration Master</h4>
            <p>Drink enough water for 7 days.</p>
        </div>

        <div class="achievement-card">
            <div class="icon">💪</div>
            <h4>Iron Lifter</h4>
            <p>Complete 100 workouts.</p>
        </div>

        <div class="achievement-card">
            <div class="icon">⚡</div>
            <h4>Elite Athlete</h4>
            <p>Fitness Score above 95.</p>
        </div>

        <div class="achievement-card">
            <div class="icon">🏃</div>
            <h4>Cardio King</h4>
            <p>Burn 10,000 calories.</p>
        </div>

        <div class="achievement-card">
            <div class="icon">👑</div>
            <h4>Premium Legend</h4>
            <p>Maintain Premium for 12 months.</p>
        </div>

    </div>

</div>
<div class="risk-section">

    <div class="risk-card">

        <div class="risk-header">

            <h2>🧠 AI Health Risk Predictor</h2>

            <span class="live-badge">LIVE ANALYSIS</span>

        </div>

        <div class="risk-meter">

            <div class="risk-fill" id="riskFill"></div>

        </div>

        <div class="risk-percent" id="riskPercent">
            0%
        </div>

        <div class="risk-report">

            <h3>AI Prediction</h3>

            <ul>

                <li>💧 Hydration is below your weekly target.</li>

                <li>🔥 Workout consistency is improving.</li>

                <li>⚖ Weight trend is stable.</li>

                <li>❤️ Overall health risk is LOW.</li>

            </ul>

        </div>

    </div>

</div>
<div class="leaderboard-section">

    <h2>🏆 Weekly Leaderboard</h2>

    <div class="leaderboard-card">

    @foreach($leaderboard as $index=>$player)

<div class="leader-row">

    <div class="leader-left">

        <span class="badge">

            @if($index==0)

                🥇

            @elseif($index==1)

                🥈

            @elseif($index==2)

                🥉

            @else

                ⭐

            @endif

        </span>

        <span>

            {{ $player['name'] }}

        </span>

        @if($player['premium'])

            <span class="premium-mini">

                👑

            </span>

        @endif

    </div>

    <strong>

        {{ $player['score'] }} pts

    </strong>

</div>

@endforeach
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/analytics.js') }}"></script>

<script>

window.analytics = {

calories: @json($calorieData),

water: @json($waterData),

weight: @json($weightData),

goal: @json($goalData)

};

</script>

@endsection