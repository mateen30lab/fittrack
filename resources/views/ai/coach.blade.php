@extends('layouts.app')

@section('title', 'AI Fitness Coach')
@section('page-title', 'AI Fitness Coach')
@section('page-sub', 'Powered by Gemini AI')

@section('content')

<link rel="stylesheet" href="{{ asset('css/ai.css') }}">

<div class="ai-wrapper">

    <div class="ai-header">

        <div class="ai-avatar">
            🤖
        </div>

        <div>
            <h2>FitTrack AI Coach</h2>
            <span class="online-dot"></span>
            <small>Online • Ready to help</small>
        </div>

    </div>

    <div class="suggestions">

        <button class="suggestion">
            💪 Create today's workout
        </button>

        <button class="suggestion">
            🍽 Meal recommendation
        </button>

        <button class="suggestion">
            💧 Hydration advice
        </button>

        <button class="suggestion">
            🏃 Improve stamina
        </button>

    </div>

    <div class="chat-box" id="chatBox">

        <div class="message ai">

            <div class="bubble">

                👋 Hello {{ auth()->user()->name }}

                <br><br>

                I'm your AI Fitness Coach.

                Ask me anything about:

                <ul>

                    <li>Workout Plans</li>

                    <li>Nutrition</li>

                    <li>Weight Loss</li>

                    <li>Muscle Building</li>

                    <li>Recovery</li>

                </ul>

            </div>

        </div>

    </div>

    <div id="typing" class="typing">

        <span></span>

        <span></span>

        <span></span>

    </div>

    <form id="chatForm">

        @csrf

        <div class="chat-input">

            <input
                type="text"
                id="prompt"
                placeholder="Ask your AI coach anything..."
                autocomplete="off"
            >

            <button>

                ➜

            </button>

        </div>

    </form>

</div>

<script src="{{ asset('js/ai.js') }}"></script>

@endsection