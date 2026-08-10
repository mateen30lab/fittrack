@extends('layouts.app')

@section('title', 'Achievements')
@section('page-title', 'Achievements')
@section('page-sub', 'Unlock badges as you reach your fitness goals')

@section('content')

<div class="card">

    <h2>🏅 Your Achievements</h2>

    <br>

    @if(count($badges))

        <div class="grid">

            @foreach($badges as $badge)

                <div class="stat-card">

                    <h1>{{ $badge['icon'] }}</h1>

                    <h3>{{ $badge['title'] }}</h3>

                    <p>{{ $badge['description'] }}</p>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <h2>😔 No badges yet</h2>

            <p>Complete workouts and goals to unlock achievements.</p>

        </div>

    @endif

</div>

@endsection