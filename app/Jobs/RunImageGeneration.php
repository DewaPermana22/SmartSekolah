<?php

namespace App\Jobs;

use App\Agents\ImageGenerationAgent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class RunImageGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $referenceId,
        public string $description,
    ) {}

    public function handle(): void
    {
        try {
            $agent = new ImageGenerationAgent();

            $structuredMessage = "Buatkan infografis dengan deskripsi: '{$this->description}'. " .
                "Gunakan reference_id: '{$this->referenceId}'. " .
                "Eksekusi tool infographics_generation sekarang.";

            $agent->run($structuredMessage);

            $expectedPath = "generated-images/{$this->referenceId}.png";

            $maxTries = 10;
            $fileFound = false;

            for ($i = 0; $i < $maxTries; $i++) {
                if (Storage::disk('public')->exists($expectedPath)) {
                    $fileFound = true;
                    break;
                }
                sleep(1);
            }

            if (!$fileFound) {
                throw new RuntimeException("File gambar tidak ditemukan di storage: {$expectedPath}. Pastikan tool infographics_generation benar-benar menyimpan file.");
            }

            $fileSize = Storage::disk('public')->size($expectedPath);
            if ($fileSize < 1000) {
                throw new RuntimeException("File gambar corrupt atau terlalu kecil: {$fileSize} bytes");
            }

        } catch (Throwable $e) {
            Log::error('❌ RunImageGeneration FAILED', [
                'reference_id' => $this->referenceId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Storage::disk('public')->put(
            "failed-image-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'description' => $this->description,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );

        Log::error('❌ Job definitively FAILED after all retries', [
            'reference_id' => $this->referenceId,
            'tries' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }
}
