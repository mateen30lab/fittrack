<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') · FitTrack</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="app-shell">

    <div class="sidebar-backdrop"></div>

    <aside class="sidebar">

        <div class="brand">
            <div class="brand-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0a0d12"
                     stroke-width="2.4" stroke-linecap="round">
                    <path d="M3 12h3l2-7 4 14 2-7h7"/>
                </svg>
            </div>

            <div class="brand-name">
                Fit<span>Track</span>
            </div>
        </div>

        <div class="nav-group-label">Overview</div>

        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="9" rx="1.5"/>
                <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                <rect x="14" y="12" width="7" height="9" rx="1.5"/>
                <rect x="3" y="16" width="7" height="5" rx="1.5"/>
            </svg>
            Dashboard
        </a>

        <div class="nav-group-label">Track</div>

        <a href="{{ route('workouts.index') }}"
           class="nav-link {{ request()->routeIs('workouts.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6.5 6.5 3 10l4 4 3.5-3.5m3 3 3.5-3.5 4 4-3.5 3.5m-8.5-8.5 8.5 8.5"/>
            </svg>
            Workouts
        </a>

        <a href="{{ route('water.index') }}"
           class="nav-link {{ request()->routeIs('water.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2.5s7 7.6 7 12.5a7 7 0 1 1-14 0c0-4.9 7-12.5 7-12.5Z"/>
            </svg>
            Water Intake
        </a>

        <a href="{{ route('bmi.index') }}"
           class="nav-link {{ request()->routeIs('bmi.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 3"/>
            </svg>
            BMI Calculator
        </a>

        <a href="{{ route('progress.index') }}"
           class="nav-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 17 9 11l4 4 8-8"/>
                <path d="M15 7h6v6"/>
            </svg>
            Daily Progress
        </a>

        <a href="{{ route('goals.index') }}"
           class="nav-link {{ request()->routeIs('goals.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <circle cx="12" cy="12" r="5"/>
                <circle cx="12" cy="12" r="1"/>
            </svg>
            Goals
        </a>

        <a href="{{ route('analytics') }}"
           class="nav-link {{ request()->routeIs('analytics') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19V10"/>
                <path d="M10 19V5"/>
                <path d="M16 19V13"/>
                <path d="M22 19V3"/>
            </svg>
            Analytics
        </a>

        <a href="{{ route('achievements.index') }}"
           class="nav-link {{ request()->routeIs('achievements.*') ? 'active' : '' }}">
            🏅 Achievements
        </a>
        <a href="{{ route('ai.coach') }}"
   class="nav-link {{ request()->routeIs('ai.coach') ? 'active' : '' }}">

    <svg viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">

        <path d="M12 3a7 7 0 0 0-7 7v4a7 7 0 0 0 7 7"/>
        <path d="M12 3a7 7 0 0 1 7 7v4a7 7 0 0 1-7 7"/>
        <path d="M8 12h8"/>
        <path d="M9 16h6"/>

    </svg>

    AI Coach

</a>

        <div class="nav-group-label">Account</div>

        <a href="{{ route('profile.edit') }}"
           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
            </svg>
            Profile
        </a>
        

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3 4 6v6c0 5 3.5 7.5 8 9 4.5-1.5 8-4 8-9V6l-8-3Z"/>
                    </svg>
                    Admin Panel
                </a>
            @endif
        @endauth

        <button id="theme-toggle" class="btn btn-ghost">
            🌙
        </button>

        @if(auth()->user()->hasPremium())

            <div class="premium-card-sidebar">

                <div class="premium-icon">
                    👑
                </div>

                <h3>FitTrack PRO</h3>

                <p>
                    Premium Membership Active
                </p>

                <ul>
                    <li>🤖 Unlimited AI Coach</li>
                    <li>📈 Advanced Analytics</li>
                    <li>💧 Smart Hydration</li>
                    <li>🔥 Calories Insights</li>
                </ul>

            </div>

        @else

            <div class="premium-card-sidebar">

                <div class="premium-icon">
                    ⭐
                </div>

                <h3>Upgrade to PRO</h3>

                <p>
                    Unlock all premium features.
                </p>

                <a href="{{ route('premium.index') }}"
                   class="premium-upgrade-btn">
                    Upgrade Now
                </a>

            </div>

            
        @endif

        <div class="sidebar-foot">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="nav-link"
                        style="width:100%; border:none; background:none; cursor:pointer; text-align:left;">

                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <path d="M16 17l5-5-5-5"/>
                        <path d="M21 12H9"/>

                    </svg>

                    Sign out

                </button>

            </form>

        </div>

    </aside>

    <div class="main">

        <div class="pulse-strip" aria-hidden="true">

            <svg viewBox="0 0 600 46" preserveAspectRatio="none">

                <path
                    class="trace"
                    d="M0,23 L60,23 L75,23 L85,4 L95,42 L105,23 L120,23 L180,23 L195,23 L205,10 L215,36 L225,23 L240,23 L300,23 L315,23 L325,4 L335,42 L345,23 L360,23 L420,23 L435,23 L445,10 L455,36 L465,23 L480,23 L540,23 L555,23 L565,4 L575,42 L585,23 L600,23"
                />

            </svg>

        </div>

        <div class="topbar">

            <div class="flex items-center gap-16">

                <button
                    class="menu-btn"
                    data-sidebar-open
                    aria-label="Open menu">

                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round">

                        <path d="M3 6h18M3 12h18M3 18h18"/>

                    </svg>

                </button>

                <div>

                    <h1>
                        @yield('page-title', 'Dashboard')
                    </h1>

                    @hasSection('page-sub')
                        <div class="topbar-sub">
                            @yield('page-sub')
                        </div>
                    @endif

                </div>

            </div>

            @auth

                <div class="user-chip">

                    <div class="avatar">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>

                    <div>

                        <div style="display:flex;align-items:center;gap:8px;">

                            <span style="font-weight:700;">
                                {{ auth()->user()->name }}
                            </span>

                            @if(auth()->user()->hasPremium())

                                <span class="premium-badge">
                                    👑 PREMIUM
                                </span>

                            @else

                                <a href="{{ route('premium.index') }}"
                                   class="upgrade-btn">
                                    Upgrade
                                </a>

                            @endif

                        </div>

                        <small style="color:var(--text-dim);">
                            {{ auth()->user()->isAdmin() ? 'Administrator' : 'Member' }}
                        </small>

                    </div>

                </div>

            @endauth

        </div>

        <div class="content">

            @if(session('status'))

                <div class="flash">

                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.4"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M20 6 9 17l-5-5"/>

                    </svg>

                    {{ session('status') }}

                </div>

            @endif

            @yield('content')

        </div>

    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')

</body>
</html>