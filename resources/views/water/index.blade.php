@extends('layouts.app')

@section('title', 'Water Intake')
@section('page-title', 'Water Intake')
@section('page-sub', 'Goal: ' . number_format($goalMl) . ' ml per day')

@section('content')
<div class="grid grid-3">
    <div class="card">
        <div class="card-title">Today</div>
        <div class="flex" style="flex-direction:column; align-items:center;">
            <div class="water-glass">
                <div class="water-fill" data-percent="{{ min(100, round($todayTotal / $goalMl * 100)) }}"></div>
            </div>
            <div class="stat-value accent-hydro mt-16">{{ number_format($todayTotal) }}<span class="unit">/ {{ number_format($goalMl) }} ml</span></div>
        </div>

        <form method="POST" action="{{ route('water.store') }}" class="mt-24">
            @csrf
            <div class="flex gap-8" style="flex-wrap:wrap;">
                <button type="submit" name="amount_ml" value="250" class="btn btn-hydro btn-sm">+250ml</button>
                <button type="submit" name="amount_ml" value="500" class="btn btn-hydro btn-sm">+500ml</button>
                <button type="submit" name="amount_ml" value="750" class="btn btn-hydro btn-sm">+750ml</button>
            </div>
        </form>

        <form method="POST" action="{{ route('water.store') }}" class="mt-16">
            @csrf
            <div class="field" style="margin-bottom:10px;">
                <label for="amount_ml">Custom amount (ml)</label>
                <input type="number" id="amount_ml" name="amount_ml" min="50" max="2000" placeholder="e.g. 330" required>
            </div>
            <button type="submit" class="btn btn-ghost btn-block">Log Custom Amount</button>
        </form>
    </div>

    <div class="card" style="grid-column: span 2;">
        <div class="card-title">Last 7 Days</div>
        <div class="bar-chart mt-16">
            @php $days = collect(range(6,0))->map(fn($d) => now()->subDays($d)); @endphp
            @foreach($days as $day)
                @php
                    $key = $day->format('Y-m-d');
                    $amount = $weekly[$key] ?? 0;
                    $pct = min(100, round($amount / $goalMl * 100));
                @endphp
                <div class="bar-col">
                    <div class="bar" data-percent="{{ $pct }}" style="height:{{ $pct }}%; background: linear-gradient(180deg, var(--hydro), rgba(52,217,209,.3));"></div>
                    <div class="bar-label">{{ $day->format('D') }}</div>
                </div>
            @endforeach
        </div>

        <div class="card-title mt-24">Today's Log</div>
        @if($todayLogs->count() > 0)
            @foreach($todayLogs as $log)
                <div class="list-row" style="padding-left:0; padding-right:0;">
                    <div class="icon-badge hydro">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5s7 7.6 7 12.5a7 7 0 1 1-14 0c0-4.9 7-12.5 7-12.5Z"/></svg>
                    </div>
                    <div style="flex:1;">
                        <div style="font-weight:600; font-size:13.5px;">{{ $log->amount_ml }} ml</div>
                        <div class="text-dim" style="font-size:12px;">{{ \Carbon\Carbon::parse($log->logged_at)->format('g:i A') }}</div>
                    </div>
                    <form method="POST" action="{{ route('water.destroy', $log) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger-ghost btn-sm">Remove</button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="empty-state" style="padding:20px 0;">No entries yet today.</div>
        @endif
    </div>
</div>
@endsection
