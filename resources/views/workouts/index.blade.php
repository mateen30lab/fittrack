@extends('layouts.app')

@section('title', 'Workouts')
@section('page-title', 'Workout Tracker')
@section('page-sub', 'Log a session and watch your weekly volume build')

@section('content')
<div class="grid grid-3" style="grid-template-columns: 380px 1fr;">

    <div class="card">
        <div class="card-title">Log a Workout</div>
        <form method="POST" action="{{ route('workouts.store') }}">
            @csrf
            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Morning run">
                @error('title')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="cardio">Cardio</option>
                    <option value="strength">Strength</option>
                    <option value="flexibility">Flexibility</option>
                    <option value="sports">Sports</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="duration_minutes">Duration (min)</label>
                    <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" required min="1" placeholder="45">
                </div>
                <div class="field">
                    <label for="calories_burned">Calories</label>
                    <input type="number" id="calories_burned" name="calories_burned" value="{{ old('calories_burned') }}" min="0" placeholder="320">
                </div>
            </div>

            <div class="field">
                <label for="performed_on">Date</label>
                <input type="date" id="performed_on" name="performed_on" value="{{ old('performed_on', now()->format('Y-m-d')) }}" required>
            </div>

            <div class="field">
                <label for="notes">Notes <span style="text-transform:none; font-weight:400;">(optional)</span></label>
                <textarea id="notes" name="notes" rows="2" placeholder="How did it feel?">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Add Workout</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">History</div>
        @if($workouts->count() > 0)
            <table class="data-table">
                <thead>
                    <tr><th>Title</th><th>Category</th><th>Duration</th><th>Calories</th><th>Date</th><th></th></tr>
                </thead>
                <tbody>
                @foreach($workouts as $workout)
                    <tr>
                        <td style="font-weight:600;">{{ $workout->title }}</td>
                        <td><span class="badge {{ $workout->category }}">{{ ucfirst($workout->category) }}</span></td>
                        <td>{{ $workout->duration_minutes }} min</td>
                        <td>{{ $workout->calories_burned }} kcal</td>
                        <td class="text-dim">{{ $workout->performed_on->format('M j, Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('workouts.destroy', $workout) }}" onsubmit="return confirm('Remove this workout?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger-ghost btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-16">{{ $workouts->links() }}</div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6.5 6.5 3 10l4 4 3.5-3.5m3 3 3.5-3.5 4 4-3.5 3.5m-8.5-8.5 8.5 8.5"/></svg>
                <div>No workouts logged yet — add your first one.</div>
            </div>
        @endif
    </div>
</div>
@endsection
