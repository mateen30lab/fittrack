<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BmiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('bmi.index', compact('user'));
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'height_cm' => ['required', 'numeric', 'min:50', 'max:260'],
            'weight_kg' => ['required', 'numeric', 'min:20', 'max:400'],
            'save' => ['nullable', 'boolean'],
        ]);

        $heightM = $validated['height_cm'] / 100;
        $bmi = round($validated['weight_kg'] / ($heightM ** 2), 1);

        $category = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 25 => 'Normal',
            $bmi < 30 => 'Overweight',
            default => 'Obese',
        };

        if ($request->boolean('save')) {
            $user = Auth::user();
            $user->height_cm = $validated['height_cm'];
            $user->weight_kg = $validated['weight_kg'];
            $user->save();
        }

        return back()->with([
            'bmi_result' => $bmi,
            'bmi_category' => $category,
            'bmi_height' => $validated['height_cm'],
            'bmi_weight' => $validated['weight_kg'],
        ]);
    }
}
