<?php

namespace App\Tools;

use App\Http\Presenter\Response;
use App\Usecase\TextGenerationtUsecase;
use Vizra\VizraADK\Contracts\ToolInterface;
use Vizra\VizraADK\Memory\AgentMemory;
use Vizra\VizraADK\System\AgentContext;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAiTextGeneration implements ToolInterface
{
    public function definition(): array
    {
        return [
            'name' => 'open_ai_text_generation',
            'description' => 'Generate educational text content using OpenAI. Use this tool for structured learning materials.',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'topic' => [
                        'type' => 'string',
                        'description' => 'The educational topic to explain (e.g., "Photosynthesis", "Pythagorean Theorem")',
                        'minLength' => 3,
                        'maxLength' => 500,
                    ],
                    'level' => [
                        'type' => 'string',
                        'description' => 'Target education level for the content',
                    ],
                ],
                'required' => ['topic', 'level'],
            ],
        ];
    }

    public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    {
        throw new Exception('Not implemented');
    }
    
    // public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    // {
    //     try {
    //         $topic = trim($arguments['topic'] ?? '');
    //         $level = strtoupper(trim($arguments['level'] ?? ''));

    //         if (empty($topic)) {
    //             return $this->jsonResponse(Response::buildError(400, 'Topic cannot be empty'));
    //         }

    //         if (empty($level)) {
    //             return $this->jsonResponse(Response::buildError(400, 'Level cannot be empty'));
    //         }

    //         $startTime = microtime(true);
    //         $text = app(TextGenerationtUsecase::class)->generateTextOpenAi($topic, $level);
    //         $executionTime = round((microtime(true) - $startTime) * 1000, 2);

    //         if (empty($text)) {
    //             return $this->jsonResponse(
    //                 Response::buildErrorService('Failed to generate content. Empty response from AI.')
    //             );
    //         }

    //         $result = Response::buildSuccess(
    //             data: [
    //                 'topic' => $topic,
    //                 'level' => $level,
    //                 'content' => $text,
    //                 'word_count' => str_word_count($text),
    //                 'generated_at' => now()->toISOString(),
    //                 'execution_time_ms' => $executionTime,
    //                 'tool_name' => 'open_ai_text_generation'
    //             ],
    //             message: 'Educational content generated successfully'
    //         );

    //         return $this->jsonResponse($result);

    //     } catch (Exception $e) {
    //         return $this->jsonResponse(
    //             Response::buildErrorService(
    //                 'An error occurred while generating content: ' . $e->getMessage()
    //             )
    //         );

    //     } finally {
    //         Log::debug('OpenAiTools executed completed', [
    //             'peak_memory' => memory_get_peak_usage() / 1024 / 1024 . ' MB',
    //             'total_time' => round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms'
    //         ]);
    //     }
    // }

    private function jsonResponse(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
