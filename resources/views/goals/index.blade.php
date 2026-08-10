@extends('layouts.app')

@section('title', 'Goals')
@section('page-title', 'Goals')
@section('page-sub', 'Set a target, log progress, watch the bar move')

@section('content')
<div class="grid grid-3" style="grid-template-columns: 380px 1fr;">

    <div class="card">
        <div class="card-title">New Goal</div>
        <form method="POST" action="{{ route('goals.store') }}">
            @csrf
            <div class="field">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required placeholder="Run a 10K">
            </div>
            <div class="field">
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option value="weight">Weight</option>
                    <option value="workouts">Workout count</option>
                    <option value="water">Water intake</option>
                    <option value="steps">Steps</option>
                    <option value="custom" selected>Custom</option>
                </select>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="target_value">Target</label>
                    <input type="number" step="0.01" id="target_value" name="target_value" required placeholder="10">
                </div>
                <div class="field">
                    <label for="unit">Unit</label>
                    <input type="text" id="unit" name="unit" placeholder="km, kg, sessions..." >
                </div>
            </div>
            <div class="field">
                <label for="target_date">Target date <span style="text-transform:none; font-weight:400;">(optional)</span></label>
                <input type="date" id="target_date" name="target_date">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Goal</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">Your Goals</div>
        @if($goals->count() > 0)
            @foreach($goals as $goal)
                <div class="list-row" style="flex-direction:column; align-items:stretch; gap:10px;">
                    <div class="flex justify-between items-center">
                        <div>
                            <div style="font-weight:600;">{{ $goal->title }}</div>
                            <div class="text-dim text-sm">{{ ucfirst($goal->type) }}{{ $goal->target_date ? ' · due '.$goal->target_date->format('M j, Y') : '' }}</div>
                        </div>
                        <span class="badge {{ $goal->status }}">{{ ucfirst($goal->status) }}</span>
                    </div>

                    <div style="height:8px; background:var(--surface-3); border-radius:999px; overflow:hidden;">
                        <div class="goal-progress" data-percent="{{ $goal->progress_percent }}" style="width:{{ $goal->progress_percent }}%; height:100%; border-radius:999px;"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-dim text-sm">{{ $goal->current_value }} / {{ $goal->target_value }} {{ $goal->unit }} ({{ $goal->progress_percent }}%)</span>
                        <div class="flex gap-8">
                            @if($goal->status === 'active')
                                <form method="POST" action="{{ route('goals.update', $goal) }}" class="flex gap-8">
                                    @csrf @method('PATCH')
                                    <input type="number" step="0.01" name="current_value" value="{{ $goal->current_value }}" style="width:90px; background:var(--surface-2); border:1px solid var(--border); color:var(--text); border-radius:8px; padding:6px 8px; font-size:13px;">
                                    <button type="submit" class="btn btn-ghost btn-sm">Update</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('goals.destroy', $goal) }}" onsubmit="return confirm('Delete this goal?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger-ghost btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg>
                <div>No goals yet — set your first target.</div>
            </div>
        @endif
    </div>
</div>
@endsection
