<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account · FitTrack</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="auth-shell">
    <div class="auth-side">
        <div class="quote-block">
            <div class="brand" style="padding:0 0 28px;">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#0a0d12" stroke-width="2.4" stroke-linecap="round"><path d="M3 12h3l2-7 4 14 2-7h7"/></svg>
                </div>
                <div class="brand-name">Fit<span>Track</span></div>
            </div>
            <div class="big-stat">4<span> metrics</span></div>
            <p>Workouts, hydration, weight, and goals — one console. Set your baseline once and let the dashboard do the watching.</p>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-card">
            <h1>Create your account</h1>
            <div class="sub">Takes under a minute. You can edit any of this later.</div>

            @if ($errors->any())
                <div class="flash" style="background:rgba(255,93,93,.1); border-color:rgba(255,93,93,.3); color:var(--pulse);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Jordan Lee">
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
                </div>
                <div class="field-row">
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="At least 8 characters">
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat password">
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="age">Age <span style="text-transform:none; font-weight:400;">(optional)</span></label>
                        <input type="number" id="age" name="age" value="{{ old('age') }}" min="10" max="100" placeholder="28">
                    </div>
                    <div class="field">
                        <label for="gender">Gender <span style="text-transform:none; font-weight:400;">(optional)</span></label>
                        <select id="gender" name="gender">
                            <option value="">Prefer not to say</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="height_cm">Height (cm)</label>
                        <input type="number" step="0.1" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" placeholder="175">
                    </div>
                    <div class="field">
                        <label for="weight_kg">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" placeholder="72">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-8">Create account</button>
            </form>

            <div class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
