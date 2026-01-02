<?php

namespace App\Tools;

use App\Http\Presenter\Response;
use App\Usecase\TextGenerationtUsecase;
use Vizra\VizraADK\Contracts\ToolInterface;
use Vizra\VizraADK\Memory\AgentMemory;
use Vizra\VizraADK\System\AgentContext;
use Illuminate\Support\Facades\Log;
use Exception;

class DeepseekTextGeneration implements ToolInterface
{
    /**
     * Get the tool's definition for the LLM.
     */
    public function definition(): array
    {
        return [
            'name' => 'deepseek_text_generation',
            'description' => 'Generate educational text content using DeepSeek AI. Suitable for structured learning materials.',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'topic' => [
                        'type' => 'string',
                        'description' => 'The educational topic to explain',
                        'minLength' => 3,
                        'maxLength' => 500,
                    ],
                    'level' => [
                        'type' => 'string',
                        'description' => 'Target education level (e.g., SD, SMP, SMA)',
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
    
    /**
     * Execute the tool's logic.
     */
    // public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    // {
    //     try {
    //         $topic = trim($arguments['topic'] ?? '');
    //         $level = strtoupper(trim($arguments['level'] ?? ''));

    //         // Validation
    //         if ($topic === '') {
    //             return $this->jsonResponse(
    //                 Response::buildError(400, 'Topic cannot be empty')
    //             );
    //         }

    //         if ($level === '') {
    //             return $this->jsonResponse(
    //                 Response::buildError(400, 'Level cannot be empty')
    //             );
    //         }

    //         $startTime = microtime(true);

    //         // Call DeepSeek usecase
    //         $text = app(TextGenerationtUsecase::class)
    //             ->generateTextDeepseek($topic, $level);

    //         $executionTime = round((microtime(true) - $startTime) * 1000, 2);

    //         if (empty($text)) {
    //             return $this->jsonResponse(
    //                 Response::buildErrorService(
    //                     'Failed to generate content. Empty response from DeepSeek AI.'
    //                 )
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
    //                 'tool_name' => 'deepseek_text_generation',
    //             ],
    //             message: 'Educational content generated successfully using DeepSeek'
    //         );

    //         return $this->jsonResponse($result);
    //     } catch (Exception $e) {
    //         return $this->jsonResponse(
    //             Response::buildErrorService(
    //                 'An error occurred while generating content: ' . $e->getMessage()
    //             )
    //         );
    //     } finally {
    //         Log::debug('DeepseekTextGeneration executed', [
    //             'peak_memory' => round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB',
    //             'total_time' => round((microtime(true) - LARAVEL_START) * 1000, 2) . ' ms',
    //         ]);
    //     }
    // }

    /**
     * Helper: Convert array to JSON string
     */
    private function jsonResponse(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
