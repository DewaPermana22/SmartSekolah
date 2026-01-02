<?php

namespace App\Tools\ImageGenerations;

use App\Http\Presenter\Response;
use App\Usecase\ImageGenerationUsecase;
use Vizra\VizraADK\Contracts\ToolInterface;
use Vizra\VizraADK\Memory\AgentMemory;
use Vizra\VizraADK\System\AgentContext;
use Illuminate\Support\Facades\Log;
use Exception;

class InfographicsGeneration implements ToolInterface
{
    /**
     * Get the tool's definition for the LLM.
     * This structure should be JSON schema compatible.
     */
    public function definition(): array
    {
        return [
            'name' => 'infographics_generation',
            'description' => 'Generate educational infographic images using AI.',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'description' => [
                        'type' => 'string',
                        'minLength' => 3,
                        'maxLength' => 500,
                    ],
                ],
                'required' => ['description'],
            ],
        ];
    }

    /**
     * Execute the tool's logic.
     *
     * @param array $arguments
     * @param AgentContext $context
     * @param AgentMemory $memory
     * @return string JSON string result
     */
    public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    {
        $startTime = microtime(true);

        try {
            $description = trim($arguments['description'] ?? '');

            if (empty($description)) {
                return $this->jsonResponse(
                    Response::buildError(400, 'Description cannot be empty')
                );
            }

            $resultImage = app(ImageGenerationUsecase::class)
                ->generateInfographic($description);

            if (empty($resultImage)) {
                return $this->jsonResponse(
                    Response::buildErrorService('Failed to generate infographic. Empty response from AI.')
                );
            }

            // Check if usecase already returned error
            if (isset($resultImage['success']) && !$resultImage['success']) {
                return $this->jsonResponse($resultImage);
            }

            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            // Extract image data from usecase result
            // Usecase returns: {success: true, data: {image_base64: "...", mime_type: "..."}}
            $imageData = $resultImage['data'] ?? [];

            // Build flat response structure
            $result = Response::buildSuccess(
                data: [
                    'image_base64' => $imageData['image_base64'] ?? null,
                    'mime_type' => $imageData['mime_type'] ?? 'image/png',
                    'description' => $description,
                    'generated_at' => now()->toISOString(),
                    'execution_time_ms' => $executionTime,
                    'tool_name' => 'infographics_generation'
                ],
                message: 'Infographic generated successfully'
            );

            Log::info('Infographic generated successfully', [
                'description' => $description,
                'has_image' => !empty($imageData['image_base64']),
                'execution_time_ms' => $executionTime
            ]);

            return $this->jsonResponse($result);
        } catch (Exception $e) {
            Log::error('InfographicsGeneration tool failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->jsonResponse(
                Response::buildErrorService(
                    'An error occurred while generating infographic: ' . $e->getMessage()
                )
            );
        } finally {
            Log::debug('InfographicsGeneration tool execution completed', [
                'peak_memory' => memory_get_peak_usage() / 1024 / 1024 . ' MB',
                'total_time' => round((microtime(true) - LARAVEL_START) * 1000, 2) . 'ms'
            ]);
        }
    }

    /**
     * Helper: Convert array to JSON string
     */
    private function jsonResponse(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
