<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in · FitTrack</title>
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
            <div class="big-stat">02:14<span>:37</span></div>
            <p>Every workout, glass of water, and pound logged becomes a read-out. FitTrack turns daily effort into a signal you can actually see move.</p>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="auth-card">
            <h1>Welcome back</h1>
            <div class="sub">Sign in to pick up where you left off.</div>

            @if ($errors->any())
                <div class="flash" style="background:rgba(255,93,93,.1); border-color:rgba(255,93,93,.3); color:var(--pulse);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between mt-8" style="margin-bottom: 18px;">
                    <label class="flex items-center gap-8 text-sm text-dim" style="font-weight:500;">
                        <input type="checkbox" name="remember" style="width:auto;">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>

            <div class="auth-switch">
                New to FitTrack? <a href="{{ route('register') }}">Create an account</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
