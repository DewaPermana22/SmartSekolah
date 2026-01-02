<?php

namespace App\Jobs;

use App\Agents\ImageGenerationAgent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class RunImageGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $message,
        public string $referenceId,
        public string $description,
        public string $type,
    ) {}

    public function handle(): void
    {
        try {
            Log::info('Starting image generation', [
                'reference_id' => $this->referenceId,
                'type' => $this->type
            ]);

            $agent = new ImageGenerationAgent();
            $result = $agent->run($this->message);

            // LOG RAW RESPONSE
            Log::info('RAW Agent Response', [
                'reference_id' => $this->referenceId,
                'response_type' => gettype($result),
                'response_length' => strlen($result),
                'raw_response' => $result, // Full raw response
            ]);

            // Save raw response to file for inspection
            Storage::disk('local')->put(
                "debug-responses/{$this->referenceId}_raw.txt",
                $result
            );

            // Parse response dari agent
            $decoded = json_decode($result, true);

            // LOG JSON DECODE RESULT
            Log::info('Decoded Agent Response', [
                'reference_id' => $this->referenceId,
                'json_error' => json_last_error_msg(),
                'decoded_type' => gettype($decoded),
                'decoded_keys' => is_array($decoded) ? array_keys($decoded) : 'not_array',
                'decoded_structure' => $decoded, // Full decoded structure
            ]);

            // Save decoded structure to file
            Storage::disk('local')->put(
                "debug-responses/{$this->referenceId}_decoded.json",
                json_encode($decoded, JSON_PRETTY_PRINT)
            );

            // Validasi response
            if (!$decoded || !isset($decoded['success'])) {
                throw new \RuntimeException('Invalid JSON response from agent');
            }

            Log::info('Agent response parsed', [
                'reference_id' => $this->referenceId,
                'success' => $decoded['success'] ?? false,
                'has_data' => isset($decoded['data']),
                'data_keys' => isset($decoded['data']) ? array_keys($decoded['data']) : []
            ]);

            if (!$decoded['success']) {
                throw new \RuntimeException($decoded['message'] ?? 'Image generation failed');
            }

            if (!isset($decoded['data']['image_base64'])) {
                Log::error('Missing image_base64', [
                    'reference_id' => $this->referenceId,
                    'available_data_keys' => isset($decoded['data']) ? array_keys($decoded['data']) : 'no_data',
                    'full_data' => $decoded['data'] ?? null
                ]);
                throw new \RuntimeException('Missing image_base64 in response data');
            }

            // Langsung decode dan save (sudah di-extract di Usecase)
            $imageData = base64_decode($decoded['data']['image_base64']);

            if ($imageData === false) {
                throw new \RuntimeException('Failed to decode base64 image');
            }

            $saved = Storage::disk('local')->put(
                "generated-images/{$this->referenceId}.png",
                $imageData
            );

            if (!$saved) {
                throw new \RuntimeException('Failed to save image to storage');
            }

            Log::info('Image generated and saved successfully', [
                'reference_id' => $this->referenceId,
                'path' => "generated-images/{$this->referenceId}.png",
                'image_size' => strlen($imageData) . ' bytes'
            ]);
        } catch (Throwable $e) {
            Log::error('Image generation job failed', [
                'reference_id' => $this->referenceId,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Storage::disk('local')->put(
            "failed-image-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'type' => $this->type,
                'description' => $this->description,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );
    }
}
