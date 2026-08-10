@extends('layouts.app')

@section('title', 'BMI Calculator')
@section('page-title', 'BMI Calculator')
@section('page-sub', 'Body Mass Index = weight (kg) ÷ height (m)²')

@section('content')
<div class="grid grid-2">
    <div class="card">
        <div class="card-title">Calculate</div>
        <form method="POST" action="{{ route('bmi.calculate') }}">
            @csrf
            <div class="field">
                <label for="bmi_height_input">Height (cm)</label>
                <input type="number" step="0.1" id="bmi_height_input" name="height_cm" value="{{ old('height_cm', session('bmi_height', $user->height_cm)) }}" required min="50" max="260">
            </div>
            <div class="field">
                <label for="bmi_weight_input">Weight (kg)</label>
                <input type="number" step="0.1" id="bmi_weight_input" name="weight_kg" value="{{ old('weight_kg', session('bmi_weight', $user->weight_kg)) }}" required min="20" max="400">
            </div>

            <div class="field-hint mt-8" style="margin-bottom:16px;">
                Live preview: <strong id="bmi_live_preview" style="color:var(--violet);">—</strong>
            </div>

            <label class="flex items-center gap-8 text-sm text-dim mt-8" style="font-weight:500; margin-bottom:16px;">
                <input type="checkbox" name="save" value="1" style="width:auto;" checked>
                Save these numbers to my profile
            </label>

            <button type="submit" class="btn btn-primary btn-block">Calculate BMI</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">Result</div>
        @if(session('bmi_result'))
            @php
                $bmi = session('bmi_result');
                $category = session('bmi_category');
                $ringPercent = min(100, round(($bmi / 40) * 100));
                $color = match(true) {
                    $bmi < 18.5 => 'var(--hydro)',
                    $bmi < 25 => 'var(--success)',
                    $bmi < 30 => 'var(--signal)',
                    default => 'var(--pulse)',
                };
            @endphp
            <div class="flex" style="flex-direction:column; align-items:center; padding: 12px 0;">
                <div class="ring-wrap">
                    <svg width="160" height="160" viewBox="0 0 160 160">
                        <circle class="ring-track" cx="80" cy="80" r="68" stroke-width="12"/>
                        <circle class="ring-value" cx="80" cy="80" r="68" stroke-width="12" data-percent="{{ $ringPercent }}" style="stroke: {{ $color }};"/>
                    </svg>
                    <div class="ring-center">
                        <div class="num">{{ $bmi }}</div>
                        <div class="lbl">{{ $category }}</div>
                    </div>
                </div>

                <div class="mt-24" style="width:100%;">
                    <div class="flex justify-between text-sm text-dim" style="margin-bottom:6px;">
                        <span>Underweight</span><span>Normal</span><span>Overweight</span><span>Obese</span>
                    </div>
                    <div style="height:8px; border-radius:999px; background: linear-gradient(90deg, var(--hydro), var(--success), var(--signal), var(--pulse));"></div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                <div>Enter your height and weight to see your result.</div>
            </div>
        @endif
    </div>
</div>
@endsection
