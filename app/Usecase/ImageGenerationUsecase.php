<?php

namespace App\Usecase;

use App\Constants\AIConst;
use App\Constants\PromptConst;
use App\Http\Presenter\Response;
use Illuminate\Support\Facades\Log;

class ImageGenerationUsecase
{
    private ToolsAiUsecase $aiToolsUsecase;

    public function __construct(ToolsAiUsecase $aiToolsUsecase)
    {
        $this->aiToolsUsecase = $aiToolsUsecase;
    }



    private function generate(string $prompt): array
    {
        try {
            $apiKey = $this->aiToolsUsecase->getApikeys('gemini');
            $url = AIConst::getUrlImageGeneration(
                AIConst::IMAGE_MODEL,
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
                    "responseModalities" => ["IMAGE"] // Perbaiki typo: responseModality -> responseModalities (plural + array)
                ]
            ];

            Log::info('Image Generation Request', [
                'url' => $url,
                'prompt' => substr($prompt, 0, 100) // Log sebagian prompt saja
            ]);

            $data = $this->aiToolsUsecase->makeRequest($url, $payload);

            Log::info('Image Generation Response', [
                'response_keys' => array_keys($data ?? []),
                'has_candidates' => isset($data['candidates'])
            ]);

            // Extract image menggunakan method yang sama seperti GeminiServices
            $imageData = $this->aiToolsUsecase->extractImageFromResponse($data);

            // Return dengan format Response yang konsisten
            return Response::buildSuccess([
                'image_base64' => $imageData['data'],
                'mime_type' => $imageData['mimeType']
            ], 200, 'Image generated successfully');
        } catch (\Exception $e) {
            Log::error('Image Generation Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::buildErrorService('Failed to generate image: ' . $e->getMessage());
        }
    }

    public function generateImage(string $description): array
    {
        $prompt = PromptConst::generateImagePrompt($description);
        return $this->generate($prompt);
    }

    public function generateInfographic(string $topic): array
    {
        $prompt = PromptConst::generateInfographicPrompt($topic);
        return $this->generate($prompt);
    }

    public function generatePoster(string $topic): array
    {
        $prompt = PromptConst::generatePosterPrompt($topic);
        return $this->generate($prompt);
    }

    public function generateBasicVector(string $subject): array
    {
        $prompt = PromptConst::generateBasicVectorPrompt($subject);
        return $this->generate($prompt);
    }

    public function generateRealisticImage(string $subject): array
    {
        $prompt = PromptConst::generateRealisticImagePrompt($subject);
        return $this->generate($prompt);
    }

    public function generate3DRenderedImage(string $subject): array
    {
        $prompt = PromptConst::generate3DRenderedPrompt($subject);
        return $this->generate($prompt);
    }

    public function generateSketchPencilImage(string $subject): array
    {
        $prompt = PromptConst::generateSketchPencilPrompt($subject);
        return $this->generate($prompt);
    }

    public function generateCartoonStyleImage(string $subject): array
    {
        $prompt = PromptConst::generateCartoonStylePrompt($subject);
        return $this->generate($prompt);
    }

    public function generateWatercolorImage(string $subject): array
    {
        $prompt = PromptConst::generateWatercolorPrompt($subject);
        return $this->generate($prompt);
    }
}
