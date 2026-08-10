@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-sub', 'Your details power the BMI and calorie estimates')

@section('content')
<div class="grid grid-2">
    <div class="card">
        <div class="card-title">Personal Details</div>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="field">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="{{ old('age', $user->age) }}" min="10" max="100">
                </div>
                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Prefer not to say</option>
                        <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="height_cm">Height (cm)</label>
                    <input type="number" step="0.1" id="height_cm" name="height_cm" value="{{ old('height_cm', $user->height_cm) }}">
                </div>
                <div class="field">
                    <label for="weight_kg">Weight (kg)</label>
                    <input type="number" step="0.1" id="weight_kg" name="weight_kg" value="{{ old('weight_kg', $user->weight_kg) }}">
                </div>
            </div>
            <div class="field">
                <label for="activity_level">Activity level</label>
                <select id="activity_level" name="activity_level">
                    <option value="">—</option>
                    <option value="sedentary" {{ $user->activity_level === 'sedentary' ? 'selected' : '' }}>Sedentary</option>
                    <option value="light" {{ $user->activity_level === 'light' ? 'selected' : '' }}>Lightly active</option>
                    <option value="moderate" {{ $user->activity_level === 'moderate' ? 'selected' : '' }}>Moderately active</option>
                    <option value="active" {{ $user->activity_level === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="very_active" {{ $user->activity_level === 'very_active' ? 'selected' : '' }}>Very active</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">Account Summary</div>
        <div class="flex items-center gap-16" style="padding-bottom:20px; border-bottom:1px solid var(--border-soft); margin-bottom:20px;">
            <div class="avatar" style="width:52px; height:52px; font-size:20px;">{{ strtoupper(substr($user->name,0,1)) }}</div>
            <div>
                <div style="font-weight:700; font-size:16px;">{{ $user->name }}</div>
                <div class="text-dim text-sm">{{ $user->email }}</div>
                <span class="badge {{ $user->isAdmin() ? 'admin' : 'other' }} mt-8" style="margin-top:6px;">{{ $user->isAdmin() ? 'Administrator' : 'Member since '.$user->created_at->format('M Y') }}</span>
            </div>
        </div>

        @if($user->bmi)
            <div class="stat" style="margin-bottom:20px;">
                <div class="card-title">Current BMI</div>
                <div class="stat-value accent-violet">{{ $user->bmi }}<span class="unit">{{ $user->bmi_category }}</span></div>
            </div>
        @endif

        <div class="card-title">Change Password</div>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')
            <div class="field">
                <label for="current_password">Current password</label>
                <input type="password" id="current_password" name="current_password" required>
                @error('current_password')<div class="field-error">{{ $message }}</div>@enderror
            </div>
            <div class="field-row">
                <div class="field">
                    <label for="new_password">New password</label>
                    <input type="password" id="new_password" name="password" required>
                </div>
                <div class="field">
                    <label for="new_password_confirmation">Confirm</label>
                    <input type="password" id="new_password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <button type="submit" class="btn btn-ghost btn-block">Update Password</button>
        </form>
    </div>
</div>
@endsection
