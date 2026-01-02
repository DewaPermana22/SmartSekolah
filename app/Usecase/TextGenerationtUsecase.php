<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\PromptConst;
use Illuminate\Support\Facades\Log;

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
    // public function generateTextOpenAi(string $topic, string $level): string
    // {
    //     $url = AIConst::getUrlTextGeneration(
    //         AIConst::OPENAI_TEXT_MODEL,
    //         ''
    //     );
    //     $prompt = PromptConst::generateTextPrompt($topic, $level);
    //     $data = $this->aiToolsUsecase->makeRequest($url, [
    //         "model" => AIConst::OPENAI_TEXT_MODEL,
    //         "input" => $prompt
    //     ], true, 'openai');

    //     return $data['output'][0]['content'][0]['text'] ?? '';
    // }

    //Deepsek Model Text Generation
    // public function generateTextDeepseek(string $topic, string $level): string
    // {
    //     try {
    //         $url = AIConst::getUrlTextGeneration(
    //             AIConst::DEEPSEEK_TEXT_MODEL,
    //             ''
    //         );
    //         $prompt = PromptConst::generateTextPrompt($topic, $level);

    //         $payload = [
    //             "model" => AIConst::DEEPSEEK_TEXT_MODEL,
    //             "messages" => [
    //                 [
    //                     "role" => "user",
    //                     "content" => $prompt
    //                 ]
    //             ],
    //             "temperature" => 0.7,
    //             "max_tokens" => 2000,
    //         ];

    //         // Log the request for debugging
    //         Log::info('DeepSeek API Request', [
    //             'url' => $url,
    //             'payload' => $payload,
    //             'topic' => $topic,
    //             'level' => $level
    //         ]);

    //         $data = $this->aiToolsUsecase->makeRequest($url, $payload, true, 'deepseek');

    //         // Log the full response for debugging
    //         Log::info('DeepSeek API Response', [
    //             'data' => $data,
    //             'response_keys' => array_keys($data ?? [])
    //         ]);

    //         // Check if response has error
    //         if (isset($data['error'])) {
    //             Log::error('DeepSeek API Error', [
    //                 'error' => $data['error'],
    //                 'code' => $data['error']['code'] ?? 'unknown',
    //                 'message' => $data['error']['message'] ?? 'unknown'
    //             ]);
    //             throw new \RuntimeException('DeepSeek API Error: ' . ($data['error']['message'] ?? 'Unknown error'));
    //         }

    //         // Validate response structure
    //         if (!isset($data['choices']) || !is_array($data['choices']) || empty($data['choices'])) {
    //             Log::error('DeepSeek Invalid Response Structure - Missing choices', [
    //                 'data' => $data,
    //                 'prompt' => $prompt
    //             ]);
    //             throw new \RuntimeException('Invalid response structure from DeepSeek API: Missing choices array');
    //         }

    //         if (!isset($data['choices'][0]['message']['content'])) {
    //             Log::error('DeepSeek Invalid Response Structure - Missing content', [
    //                 'data' => $data,
    //                 'first_choice' => $data['choices'][0] ?? null
    //             ]);
    //             throw new \RuntimeException('Invalid response structure from DeepSeek API: Missing message content');
    //         }

    //         $content = $data['choices'][0]['message']['content'];

    //         if (empty($content)) {
    //             Log::warning('DeepSeek Empty Content', [
    //                 'full_response' => $data,
    //                 'prompt' => $prompt,
    //                 'finish_reason' => $data['choices'][0]['finish_reason'] ?? 'unknown'
    //             ]);
    //             throw new \RuntimeException('DeepSeek API returned empty content');
    //         }

    //         return $content;
    //     } catch (\Exception $e) {
    //         Log::error('DeepSeek Generation Failed', [
    //             'error' => $e->getMessage(),
    //             'topic' => $topic,
    //             'level' => $level,
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         // Re-throw to let caller handle it
    //         throw $e;
    //     }
    // }
}
