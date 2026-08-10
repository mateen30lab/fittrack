<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

class AIController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function coach()
    {
        $user = auth()->user();

        return view('ai.coach', compact('user'));
    }

    public function chat(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:5000',
        ]);

        $user = auth()->user();

        // Give Gemini some useful fitness context
        $context = "
You are FitTrack AI Coach.

User information:
Name: {$user->name}
Age: " . ($user->age ?? 'Not provided') . "
Gender: " . ($user->gender ?? 'Not provided') . "
Height: " . ($user->height_cm ?? 'Not provided') . " cm
Weight: " . ($user->weight_kg ?? 'Not provided') . " kg
Activity level: " . ($user->activity_level ?? 'Not provided') . "

Give practical, encouraging fitness and wellness advice.
Do not claim to be a doctor.
Keep responses clear and useful.

User's question:
{$request->prompt}
";

        $reply = $this->gemini->generate($context);

        return response()->json([
            'reply' => $reply,
        ]);
    }
}