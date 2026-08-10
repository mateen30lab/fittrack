<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PremiumController extends Controller
{
    private const PRICE = 2000;

    public function index()
    {
        return view('premium.index', [
            'user' => auth()->user(),
            'price' => self::PRICE,
            'priceUsd' => 1.46,
        ]);
    }

    public function initializePayment()
    {
        $user = auth()->user();

        $response = Http::withToken(
            config('services.paystack.secret_key')
        )->post(
            config('services.paystack.payment_url') .
            '/transaction/initialize',
            [
                'email' => $user->email,

                // ₦2,000 = 200,000 kobo
                'amount' => self::PRICE * 100,

                'currency' => 'NGN',

                'callback_url' => route('premium.callback'),

                'metadata' => [
                    'user_id' => $user->id,
                    'purpose' => 'FitTrack Premium',
                ],
            ]
        );

      if (!$response->successful()) {
    return back()->with(
        'status',
        'Paystack error: ' . $response->body()
    );
}

        $data = $response->json();

        if (
            !isset($data['status']) ||
            !$data['status'] ||
            !isset($data['data']['authorization_url'])
        ) {
            return back()->with(
                'status',
                'Payment initialization failed.'
            );
        }

        return redirect(
            $data['data']['authorization_url']
        );
    }

    public function callback()
    {
        $reference = request('reference');

        if (!$reference) {
            return redirect()
                ->route('premium.index')
                ->with(
                    'status',
                    'Payment reference missing.'
                );
        }

        $response = Http::withToken(
            config('services.paystack.secret_key')
        )->get(
            config('services.paystack.payment_url') .
            '/transaction/verify/' .
            urlencode($reference)
        );

        if (!$response->successful()) {
            return redirect()
                ->route('premium.index')
                ->with(
                    'status',
                    'Unable to verify payment.'
                );
        }

        $transaction = $response->json('data');

        if (!$transaction) {
            return redirect()
                ->route('premium.index')
                ->with(
                    'status',
                    'Invalid payment response.'
                );
        }

        $successful =
            ($transaction['status'] ?? null) === 'success';

        $correctAmount =
            ($transaction['amount'] ?? 0) === 200000;

        $correctCurrency =
            ($transaction['currency'] ?? null) === 'NGN';

        $correctEmail =
            ($transaction['customer']['email'] ?? null)
            === auth()->user()->email;

        if (
            !$successful ||
            !$correctAmount ||
            !$correctCurrency ||
            !$correctEmail
        ) {
            return redirect()
                ->route('premium.index')
                ->with(
                    'status',
                    'Payment verification failed.'
                );
        }

        $user = auth()->user();

        $user->is_premium = true;
        $user->premium_expires_at = now()->addDays(30);

        $user->save();

        return redirect()
            ->route('premium.index')
            ->with(
                'status',
                '🎉 Payment successful! FitTrack Premium is now active.'
            );
    }
}