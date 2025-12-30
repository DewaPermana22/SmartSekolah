<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\PromptConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GeminiUsecase
{

    private function getApikeys(): string
    {
        return config('services.api_keys.gemini');
    }

    public function makeRequest(string $url, array $payload): array
    {
        $client = Http::withOptions(AIConst::getTimeoutSettings())
            ->withHeaders([
                'Content-Type'  => 'application/json',
            ]);

        $response = $client->post($url, $payload);

        $response->throw();

        return $response->json();
    }

    public function generateText(string $topic, string $level): string
    {
        $prompt = PromptConst::generateTextPrompt($topic, $level);
        $apikey = $this->getApikeys();
        $url = AIConst::getUrlTextGeneration(AIConst::GEMINI_TEXT_MODEL, $apikey);
        $payload = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 1.2,
                "maxOutputTokens" => 2048
            ]
        ];

        $data = $this->makeRequest($url, $payload);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }
}
