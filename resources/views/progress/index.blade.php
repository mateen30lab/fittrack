@extends('layouts.app')

@section('title', 'Daily Progress')
@section('page-title', 'Daily Progress')
@section('page-sub', 'Weight, steps, sleep — the slow-moving signals')

@section('content')
<div class="grid grid-3" style="grid-template-columns: 380px 1fr;">

    <div class="card">
        <div class="card-title">Log Today</div>
        <form method="POST" action="{{ route('progress.store') }}">
            @csrf
            <div class="field">
                <label for="log_date">Date</label>
                <input type="date" id="log_date" name="log_date" value="{{ old('log_date', now()->format('Y-m-d')) }}" required>
            </div>
            <div class="field">
                <label for="weight_kg">Weight (kg)</label>
                <input type="number" step="0.1" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="72.4">
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="steps">Steps</label>
                    <input type="number" id="steps" name="steps" value="{{ old('steps') }}" placeholder="8500">
                </div>
                <div class="field">
                    <label for="sleep_minutes">Sleep (min)</label>
                    <input type="number" id="sleep_minutes" name="sleep_minutes" value="{{ old('sleep_minutes') }}" placeholder="450">
                </div>
            </div>
            <div class="field">
                <label for="mood">Mood (1–5)</label>
                <select id="mood" name="mood">
                    <option value="">—</option>
                    <option value="1">1 · Rough</option>
                    <option value="2">2 · Low</option>
                    <option value="3">3 · Okay</option>
                    <option value="4">4 · Good</option>
                    <option value="5">5 · Great</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Entry</button>
            <div class="field-hint mt-8">Logging the same date again updates that entry.</div>
        </form>
    </div>

    <div class="card">
        <div class="card-title">History</div>
        @if($entries->count() > 0)
            <table class="data-table">
                <thead>
                    <tr><th>Date</th><th>Weight</th><th>Steps</th><th>Sleep</th><th>Mood</th></tr>
                </thead>
                <tbody>
                @foreach($entries as $entry)
                    <tr>
                        <td style="font-weight:600;">{{ $entry->log_date->format('M j, Y') }}</td>
                        <td>{{ $entry->weight_kg ? $entry->weight_kg.' kg' : '—' }}</td>
                        <td>{{ $entry->steps ? number_format($entry->steps) : '—' }}</td>
                        <td>{{ $entry->sleep_minutes ? floor($entry->sleep_minutes/60).'h '.($entry->sleep_minutes%60).'m' : '—' }}</td>
                        <td>{{ $entry->mood ? str_repeat('●', $entry->mood) . str_repeat('○', 5-$entry->mood) : '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 17 9 11l4 4 8-8"/><path d="M15 7h6v6"/></svg>
                <div>No progress entries yet — log today's numbers.</div>
            </div>
        @endif
    </div>
</div>
@endsection
