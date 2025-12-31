<?php

namespace App\Usecase;

use App\Constants\AIConst;
use Illuminate\Support\Facades\Http;

class ToolsAiUsecase
{
    public function getApikeys(string $model): string
    {
        return config("services.api_keys.{$model}");
    }

    public function makeRequest(string $url, array $payload, bool $isOpenAi = false): array
    {
        $client = Http::withOptions(AIConst::getTimeoutSettings())
            ->withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => $isOpenAi ? "Bearer {$this->getApikeys('openai')}" : null,
            ]);

        $response = $client->post($url, $payload);

        $response->throw();

        return $response->json();
    }
}
