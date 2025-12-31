<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\PromptConst;

class TextGenerationtUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    //Gemini Model Text Generation
    public function generateTextGemini(string $topic, string $level): string
    {
        $prompt = PromptConst::generateTextPrompt($topic, $level);

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

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    //Open Ai Model Text Generation
    public function generateTextOpenAi(string $topic, string $level): string
    {
        $url = AIConst::getUrlTextGeneration(
            AIConst::OPENAI_TEXT_MODEL,
            ''
        );
        $prompt = PromptConst::generateTextPrompt($topic, $level);
        $data = $this->aiToolsUsecase->makeRequest($url, [
            "model" => AIConst::OPENAI_TEXT_MODEL,
            "input" => $prompt
        ], true);

        return $data['output'][0]['content'][0]['text'] ?? '';
    }
}
