<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\DatabaseConst;
use App\Constants\PromptConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TextGenerationtUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    //Gemini Model Text Generation
    public function generateTextGemini(string $description, string $categories): array
    {
        $templatePrompt = DB::table(DatabaseConst::PROMPT_TEXT_GENERATION)
            ->where('categories', $categories)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->first();

        if (!$templatePrompt) {
            return Response::buildErrorNotFound(
                'Invalid text generation categories provided.'
            );
        }

        $prompt = $this->aiToolsUsecase->resolver(
            $templatePrompt->text_prompt,
            [
                'description' => $description,
                'categories'  => $categories
            ]
        );

        $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
        $url = AIConst::getUrlTextGeneration(
            AIConst::GEMINI_TEXT_MODEL,
            $apiKey
        );

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

        $data = $this->aiToolsUsecase->makeRequest($url, $payload);

        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return Response::buildErrorService(
                'Failed to generate text from AI.'
            );
        }

        $usage = $data['usageMetadata'] ?? [];

        return Response::buildSuccess([
            'categories' => $categories,
            'content'    => $text,
            'usage'      => [
                'prompt_tokens'     => $usage['promptTokenCount'] ?? 0,
                'completion_tokens' => $usage['candidatesTokenCount'] ?? 0,
                'total_tokens'      => $usage['totalTokenCount'] ?? 0,
            ]
        ], 200, 'Text generated successfully');
    }
}
