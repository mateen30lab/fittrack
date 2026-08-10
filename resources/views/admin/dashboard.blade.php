@extends('layouts.app')

@section('page-title', 'Admin Dashboard')
@section('page-sub', 'Manage FitTrack users, activity and premium access')

@section('content')

<div class="admin-dashboard">

    {{-- =========================
         FLASH MESSAGE
    ========================== --}}
    @if(session('status'))
        <div class="flash">
            <svg width="18" height="18"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M20 6 9 17l-5-5"/>
            </svg>

            {{ session('status') }}
        </div>
    @endif


    {{-- =========================
         PAGE HEADER
    ========================== --}}
    <div class="admin-header">
        <div>
            <h2>Admin Overview</h2>

            <p class="text-dim">
                Monitor your FitTrack community and manage memberships.
            </p>
        </div>

        <div class="admin-badge">
            🛡️ Administrator
        </div>
    </div>


    {{-- =========================
         STAT CARDS
    ========================== --}}
    <div class="grid grid-4 mt-24">

        {{-- Total Users --}}
        <div class="card stat-card">

            <div class="card-title">
                <span>Total Users</span>

                <div class="icon-badge pulse">
                    <svg viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>

            <div class="stat-value">
                {{ $totalUsers }}
            </div>

            <div class="stat-delta up">
                +{{ $newUsersThisWeek }} this week
            </div>

        </div>


        {{-- Total Workouts --}}
        <div class="card stat-card">

            <div class="card-title">
                <span>Total Workouts</span>

                <div class="icon-badge pulse">
                    🔥
                </div>
            </div>

            <div class="stat-value">
                {{ $totalWorkouts }}
            </div>

            <div class="stat-delta">
                Workout records
            </div>

        </div>


        {{-- Water Logs --}}
        <div class="card stat-card">

            <div class="card-title">
                <span>Water Logs</span>

                <div class="icon-badge hydro">
                    💧
                </div>
            </div>

            <div class="stat-value">
                {{ $totalWaterLogs }}
            </div>

            <div class="stat-delta">
                Hydration records
            </div>

        </div>


        {{-- Goals --}}
        <div class="card stat-card">

            <div class="card-title">
                <span>Active Goals</span>

                <div class="icon-badge signal">
                    🎯
                </div>
            </div>

            <div class="stat-value">
                {{ $activeGoals }}
            </div>

            <div class="stat-delta up">
                {{ $completedGoals }} completed
            </div>

        </div>

    </div>


    {{-- =========================
         MAIN ADMIN GRID
    ========================== --}}
    <div class="grid grid-2 mt-24">

        {{-- =========================
             MOST ACTIVE USERS
        ========================== --}}
        <div class="card">

            <div class="card-title">
                <span>Most Active Members</span>
                <span class="text-dim">Top 5</span>
            </div>

            @forelse($mostActiveUsers as $user)

                <div class="list-row">

                    <div class="avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div style="flex:1; min-width:0;">

                        <strong>
                            {{ $user->name }}
                        </strong>

                        <div class="text-dim text-sm">
                            {{ $user->email }}
                        </div>

                    </div>

                    <div style="text-align:right;">

                        <strong class="accent-pulse">
                            {{ $user->workouts_count }}
                        </strong>

                        <div class="text-dim text-sm">
                            workouts
                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-state">
                    No workout activity yet.
                </div>

            @endforelse

        </div>


        {{-- =========================
             RECENT USERS
        ========================== --}}
        <div class="card">

            <div class="card-title">
                <span>Recent Members</span>
                <span class="text-dim">Latest 8</span>
            </div>

            @forelse($recentUsers as $user)

                <div class="list-row">

                    <div class="avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div style="flex:1; min-width:0;">

                        <strong>
                            {{ $user->name }}
                        </strong>

                        <div class="text-dim text-sm">
                            {{ $user->email }}
                        </div>

                    </div>

                    <div>

                        @if($user->hasPremium())

                            <span class="premium-badge">
                                👑 PREMIUM
                            </span>

                        @else

                            <span class="badge">
                                FREE
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div class="empty-state">
                    No members yet.
                </div>

            @endforelse

        </div>

    </div>


    {{-- =========================
         WORKOUT CATEGORY BREAKDOWN
    ========================== --}}
    <div class="card mt-24">

        <div class="card-title">
            <span>Workout Categories</span>
            <span class="text-dim">
                {{ $totalWorkouts }} total
            </span>
        </div>

        @if($categoryBreakdown->count())

            <div class="grid grid-4">

                @foreach($categoryBreakdown as $category => $total)

                    <div style="
                        background:var(--surface-2);
                        border:1px solid var(--border-soft);
                        border-radius:12px;
                        padding:16px;
                    ">

                        <div class="text-dim text-sm">
                            {{ ucfirst($category) }}
                        </div>

                        <div class="stat-value"
                             style="font-size:24px; margin-top:8px;">
                            {{ $total }}
                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                No workout categories recorded yet.
            </div>

        @endif

    </div>


    {{-- =================================================
         PREMIUM MEMBERSHIP MANAGEMENT
    ================================================== --}}
    <div class="card mt-24">

        <div class="card-title">

            <div>
                <span>Premium Membership Management</span>

                <div class="text-dim text-sm" style="margin-top:4px;">
                    Demo control — activate or deactivate Premium access.
                </div>
            </div>

            <div class="admin-badge">
                👑 PRO CONTROL
            </div>

        </div>


        {{-- USERS TABLE --}}

        @if($users->count())

            <div style="overflow-x:auto;">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>Member</th>

                            <th>Status</th>

                            <th>Workouts</th>

                            <th>Goals</th>

                            <th>Premium Expiry</th>

                            <th style="text-align:right;">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($users as $user)

                            <tr>

                                {{-- USER --}}
                                <td>

                                    <div style="
                                        display:flex;
                                        align-items:center;
                                        gap:10px;
                                    ">

                                        <div class="avatar">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                            <div class="text-dim text-sm">
                                                {{ $user->email }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- PREMIUM STATUS --}}
                                <td>

                                    @if($user->hasPremium())

                                        <span class="premium-badge">
                                            👑 PREMIUM
                                        </span>

                                    @else

                                        <span class="badge">
                                            FREE
                                        </span>

                                    @endif

                                </td>


                                {{-- WORKOUTS --}}
                                <td>

                                    <span class="accent-pulse">
                                        {{ $user->workouts_count }}
                                    </span>

                                </td>


                                {{-- GOALS --}}
                                <td>

                                    <span class="accent-signal">
                                        {{ $user->goals_count }}
                                    </span>

                                </td>


                                {{-- PREMIUM EXPIRY --}}
                                <td>

                                    @if($user->hasPremium() && $user->premium_expires_at)

                                        <span class="text-dim">

                                            {{ \Carbon\Carbon::parse($user->premium_expires_at)->format('M d, Y') }}

                                        </span>

                                    @else

                                        <span class="text-dim">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}
                                <td style="text-align:right;">

                                    <div style="
                                        display:flex;
                                        justify-content:flex-end;
                                        gap:8px;
                                    ">

                                        {{-- PREMIUM TOGGLE --}}
                                        <form method="POST"
                                              action="{{ route('admin.premium.toggle', $user) }}">

                                            @csrf

                                            @if($user->hasPremium())

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger-ghost btn-sm"
                                                    onclick="return confirm('Deactivate Premium for {{ $user->name }}?')">

                                                    Deactivate

                                                </button>

                                            @else

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-sm">

                                                    Activate Premium

                                                </button>

                                            @endif

                                        </form>


                                        {{-- DELETE USER --}}
                                        @if(!$user->isAdmin())

                                            <form method="POST"
                                                  action="{{ route('admin.users.destroy', $user) }}">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger-ghost btn-sm"
                                                    onclick="return confirm('Delete {{ $user->name }} permanently?')">

                                                    Delete

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =========================
                 PAGINATION
            ========================== --}}
            @if($users->hasPages())

                <div style="
                    margin-top:20px;
                    display:flex;
                    justify-content:center;
                ">

                    {{ $users->links() }}

                </div>

            @endif

        @else

            <div class="empty-state">

                <div style="font-size:36px;">
                    👥
                </div>

                <p>
                    No members found.
                </p>

            </div>

        @endif

    </div>


    {{-- =========================
         ADMIN QUICK INFO
    ========================== --}}
    <div class="grid grid-3 mt-24">

        <div class="card">

            <div class="card-title">
                Premium Demo
            </div>

            <h3 class="accent-signal">
                👑 Premium Control
            </h3>

            <p class="text-dim text-sm" style="margin-top:8px;">
                Activate Premium for any member for 30 days.
            </p>

        </div>


        <div class="card">

            <div class="card-title">
                Community
            </div>

            <h3 class="accent-hydro">
                {{ $totalUsers }} Members
            </h3>

            <p class="text-dim text-sm" style="margin-top:8px;">
                Registered FitTrack users.
            </p>

        </div>


        <div class="card">

            <div class="card-title">
                Goal Progress
            </div>

            <h3 class="accent-violet">
                {{ $completedGoals }} Completed
            </h3>

            <p class="text-dim text-sm" style="margin-top:8px;">
                Goals successfully completed.
            </p>

        </div>

    </div>

</div>

@endsection