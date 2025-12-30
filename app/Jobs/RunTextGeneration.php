<?php

namespace App\Jobs;

use App\Agents\TextGenerationAgent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class RunTextGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $message,
        public string $referenceId,
        public string $topic,
        public string $level
    ) {}

    public function handle(): void
    {
        try {
            $agent = new TextGenerationAgent();
            $result = $agent->run($this->message);

            $generatedText = $this->extractContent($result);

            Storage::disk('local')->put(
                "generated-texts/{$this->referenceId}.txt",
                $generatedText
            );
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Extract clean content from nested JSON response
     */
    private function extractContent(string $response): string
    {
        try {
            // Decode first level
            $decoded = json_decode($response, true);

            // Extract from generate_educational_text_response
            if (isset($decoded['generate_educational_text_response']['content'])) {
                $content = $decoded['generate_educational_text_response']['content'];

                // Decode nested JSON string
                $nestedDecoded = json_decode($content, true);

                // Extract actual content from data
                if (isset($nestedDecoded['data']['content'])) {
                    return $nestedDecoded['data']['content'];
                }
            }

            return $response;
        } catch (\Exception $e) {
            return $response;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Storage::disk('local')->put(
            "failed-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'topic' => $this->topic,
                'level' => $this->level,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );
    }
}
