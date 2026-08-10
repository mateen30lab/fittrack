<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiService
{
    protected string $apiKey;

    protected string $model = 'gemini-3.6-flash';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');

        if (empty($this->apiKey)) {
            throw new RuntimeException('Gemini API key is not configured.');
        }
    }

    public function generate(string $prompt): string
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";

        $response = Http::timeout(60)
            ->withHeaders([
                'x-goog-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

        if (!$response->successful()) {
            throw new RuntimeException(
                'Gemini API error (' .
                $response->status() .
                '): ' .
                $response->body()
            );
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (!$text) {
            throw new RuntimeException(
                'Gemini returned an empty response: ' . $response->body()
            );
        }

        return $text;
    }
}