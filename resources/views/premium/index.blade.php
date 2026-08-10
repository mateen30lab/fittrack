@extends('layouts.app')

@section('page-title', 'FitTrack PRO')

@section('page-sub', 'Unlock the full FitTrack experience')

@section('content')

<style>
    .premium-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    .premium-hero {
        text-align: center;
        margin-bottom: 30px;
    }

    .premium-crown {
        width: 80px;
        height: 80px;
        margin: 0 auto 18px;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        background: linear-gradient(
            135deg,
            #ffc857,
            #ff9f43
        );
        box-shadow: 0 15px 35px rgba(255, 200, 87, .25);
    }

    .premium-hero h1 {
        font-size: 38px;
        margin: 0 0 10px;
    }

    .premium-hero p {
        color: var(--text-dim);
        font-size: 16px;
    }

    .premium-card {
        background: var(--surface);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 20px 50px rgba(0,0,0,.2);
    }

    .premium-status {
        text-align: center;
        padding: 35px 20px;
    }

    .active-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 999px;
        background: rgba(52,217,209,.12);
        color: #34d9d1;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .premium-price {
        text-align: center;
        margin: 20px 0 30px;
    }

    .premium-price .amount {
        font-size: 48px;
        font-weight: 800;
        color: #ffc857;
    }

    .premium-price .duration {
        color: var(--text-dim);
        margin-top: 5px;
    }

    .premium-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin: 30px 0;
    }

    .premium-feature {
        padding: 18px;
        border-radius: 14px;
        background: rgba(255,255,255,.035);
        border: 1px solid rgba(255,255,255,.06);
    }

    .premium-feature strong {
        display: block;
        margin-bottom: 5px;
    }

    .premium-feature span {
        color: var(--text-dim);
        font-size: 14px;
    }

    .premium-upgrade-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        background: linear-gradient(
            135deg,
            #ffc857,
            #ff9f43
        );
        color: #0a0d12;
        text-decoration: none;
        font-weight: 800;
        font-size: 16px;
        transition: .2s ease;
        box-sizing: border-box;
    }

    .premium-upgrade-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(255,200,87,.2);
    }

    .premium-note {
        text-align: center;
        color: var(--text-dim);
        font-size: 13px;
        margin-top: 15px;
    }

    .premium-expiry {
        color: var(--text-dim);
        margin-top: 10px;
    }

    .success-message {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px 18px;
        margin-bottom: 25px;
        border-radius: 12px;
        background: rgba(52,217,209,.1);
        border: 1px solid rgba(52,217,209,.25);
        color: #34d9d1;
    }

    @media (max-width: 650px) {
        .premium-card {
            padding: 25px 20px;
        }

        .premium-hero h1 {
            font-size: 30px;
        }

        .premium-features {
            grid-template-columns: 1fr;
        }

        .premium-price .amount {
            font-size: 40px;
        }
    }
</style>


<div class="premium-page">

    {{-- Payment / system message --}}
    @if(session('status'))
        <div class="success-message">
            <span>✓</span>
            <span>{{ session('status') }}</span>
        </div>
    @endif


    {{-- Header --}}
    <div class="premium-hero">

        <div class="premium-crown">
            👑
        </div>

        <h1>FitTrack PRO</h1>

        <p>
            Take your fitness journey to the next level.
        </p>

    </div>


    {{-- PREMIUM USER --}}
    @if($user->hasPremium())

        <div class="premium-card premium-status">

            <div class="active-badge">
                👑 PREMIUM ACTIVE
            </div>

            <h2>
                Welcome to FitTrack PRO
            </h2>

            <p>
                Your Premium membership is currently active.
            </p>

            @if($user->premium_expires_at)

                <p class="premium-expiry">
                    Membership expires on
                    <strong>
                        {{ $user->premium_expires_at->format('d M Y') }}
                    </strong>
                </p>

            @endif


            <div class="premium-features">

                <div class="premium-feature">
                    <strong>🤖 AI Fitness Coach</strong>
                    <span>
                        Get personalized fitness guidance from your AI coach.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>📈 Advanced Analytics</strong>
                    <span>
                        Get deeper insights into your fitness progress.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>💧 Smart Hydration</strong>
                    <span>
                        Track and improve your daily hydration.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>🔥 Fitness Insights</strong>
                    <span>
                        Understand your workout and progress patterns.
                    </span>
                </div>

            </div>


            <a
                href="{{ route('ai.coach') }}"
                class="premium-upgrade-btn"
            >
                🤖 Open AI Coach
            </a>

        </div>


    {{-- FREE USER --}}
    @else

        <div class="premium-card">

            <div class="premium-price">

                <div class="amount">
                    ₦2,000
                </div>

                <div class="duration">
                    30 days of FitTrack PRO
                </div>

            </div>


            <div class="premium-features">

                <div class="premium-feature">
                    <strong>🤖 AI Fitness Coach</strong>
                    <span>
                        Personalized fitness advice and workout guidance.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>📈 Advanced Analytics</strong>
                    <span>
                        Unlock deeper progress and performance insights.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>💧 Smart Hydration</strong>
                    <span>
                        Get smarter hydration tracking and insights.
                    </span>
                </div>

                <div class="premium-feature">
                    <strong>🔥 Fitness Insights</strong>
                    <span>
                        Get advanced information about your fitness journey.
                    </span>
                </div>

            </div>


            {{-- PAYSTACK PAYMENT --}}
            <a
                href="{{ route('premium.pay') }}"
                class="premium-upgrade-btn"
            >
                💳 Pay ₦2,000 & Unlock Premium
            </a>

            <div class="premium-note">
                Secure payment powered by Paystack.
            </div>

        </div>

    @endif

</div>

@endsection