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
                        'description' => 'Topic or description for the infographic',
                        'minLength' => 3,
                        'maxLength' => 500,
                    ],
                    'reference_id' => [
                        'type' => 'string',
                        'description' => 'Unique reference ID for the image file',
                    ],
                ],
                'required' => ['description', 'reference_id'],
            ],
        ];
    }

    public function execute(array $arguments, AgentContext $context, AgentMemory $memory): string
    {
        $startTime = microtime(true);

        try {
            $description = trim($arguments['description'] ?? '');
            $referenceId = trim($arguments['reference_id'] ?? '');

            // Validasi input
            if ($description === '') {
                return $this->jsonResponse(
                    Response::buildError(400, 'Description cannot be empty')
                );
            }

            if ($referenceId === '') {
                return $this->jsonResponse(
                    Response::buildError(400, 'Reference ID cannot be empty')
                );
            }

            $result = app(ImageGenerationUsecase::class)
                ->generateInfographic($description, $referenceId);

            if (empty($result) || empty($result['success'])) {
                return $this->jsonResponse(
                    $result ?: Response::buildErrorService('Failed to generate infographic')
                );
            }

            $executionTime = round((microtime(true) - $startTime) * 1000, 2);

            return $this->jsonResponse(
                Response::buildSuccess(
                    data: [
                        'image_path' => "generated-images/{$referenceId}.png",
                        'reference_id' => $referenceId,
                        'description' => $description,
                        'url' => $result['data']['url'] ?? null,
                        'generated_at' => now()->toISOString(),
                        'execution_time_ms' => $executionTime,
                        'tool_name' => 'infographics_generation',
                    ],
                    message: 'Infographic generated successfully'
                )
            );
        } catch (Exception $e) {
            Log::error('InfographicsGeneration failed', [
                'reference_id' => $arguments['reference_id'] ?? 'unknown',
                'description' => $arguments['description'] ?? '',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->jsonResponse(
                Response::buildErrorService(
                    'An error occurred while generating infographic: ' . $e->getMessage()
                )
            );
        }
    }

    private function jsonResponse(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
