<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\PromptConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageGenerationUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }

    /**
     * Generate image using AI and save with reference_id as filename
     *
     * @param string $prompt The prompt for image generation
     * @param string $referenceId Unique reference ID (akan jadi nama file)
     * @return array Response with image_path and status
     */
    private function generate(string $prompt, string $referenceId): array
    {
        try {
            $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
            $url = AIConst::getUrlImageGeneration(
                AIConst::IMAGE_MODEL,
                $apiKey
            );

            $payload = [
                "contents" => [[
                    "role" => "user",
                    "parts" => [["text" => $prompt]]
                ]],
                "generationConfig" => [
                    "responseModalities" => ["IMAGE"]
                ]
            ];

            $data = $this->aiToolsUsecase->makeRequest($url, $payload);
            $imageData = $this->aiToolsUsecase->extractImageFromResponse($data);

            // Validate image data
            if (!isset($imageData['data']) || empty($imageData['data'])) {
                throw new \RuntimeException('No image data received from API');
            }

            $path = "generated-images/{$referenceId}.png";

            // Decode and save image
            $decodedImage = base64_decode($imageData['data'], true);

            if ($decodedImage === false) {
                throw new \RuntimeException('Failed to decode base64 image data');
            }

            // Save to public storage
            $saved = Storage::disk('public')->put($path, $decodedImage);

            if (!$saved) {
                throw new \RuntimeException('Failed to save image to storage');
            }

            // Generate public URL
            $publicUrl = asset('storage/' . $path);

            Log::info('✅ Image generated and saved', [
                'reference_id' => $referenceId,
                'path' => $path,
                'size' => strlen($decodedImage),
                'url' => $publicUrl
            ]);

            return Response::buildSuccess([
                'image_path' => $path,
                'reference_id' => $referenceId,
                'url' => $publicUrl,
                'size_bytes' => strlen($decodedImage)
            ], 200, 'Image generated successfully');
            
        } catch (\Throwable $e) {
            Log::error('❌ Image generation failed', [
                'reference_id' => $referenceId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::buildErrorService(
                'Failed to generate image: ' . $e->getMessage()
            );
        }
    }

    /**
     * Generate generic image from description
     */
    public function generateImage(string $description, string $referenceId): array
    {
        $prompt = PromptConst::generateImagePrompt($description);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate educational infographic
     */
    public function generateInfographic(string $topic, string $referenceId): array
    {
        $prompt = PromptConst::generateInfographicPrompt($topic);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate promotional poster
     */
    public function generatePoster(string $topic, string $referenceId): array
    {
        $prompt = PromptConst::generatePosterPrompt($topic);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate basic vector image
     */
    public function generateBasicVector(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generateBasicVectorPrompt($subject);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate realistic photographic image
     */
    public function generateRealisticImage(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generateRealisticImagePrompt($subject);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate 3D rendered image
     */
    public function generate3DRenderedImage(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generate3DRenderedPrompt($subject);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate sketch/pencil drawing image
     */
    public function generateSketchPencilImage(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generateSketchPencilPrompt($subject);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate cartoon style image
     */
    public function generateCartoonStyleImage(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generateCartoonStylePrompt($subject);
        return $this->generate($prompt, $referenceId);
    }

    /**
     * Generate watercolor painting image
     */
    public function generateWatercolorImage(string $subject, string $referenceId): array
    {
        $prompt = PromptConst::generateWatercolorPrompt($subject);
        return $this->generate($prompt, $referenceId);
    }
}
