<?php

namespace App\Http\Controllers;

use App\Http\Presenter\Response;
use App\Jobs\RunTextGeneration;
use App\Jobs\RunImageGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    public function generateText(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|max:100',
        ]);

        $referenceId = Str::uuid()->toString();

        $message = 'Buatkan materi "' . htmlspecialchars($request->topic, ENT_QUOTES)
            . '" untuk tingkat ' . htmlspecialchars($request->level, ENT_QUOTES);

        RunTextGeneration::dispatch(
            message: $message,
            topic: $request->topic,
            level: $request->level,
            referenceId: $referenceId
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url' => route('job_status_text', ['referenceId' => $referenceId]),
                ],
                message: 'Text generation job queued successfully'
            ),
            202
        );
    }

    public function generateInfographics(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $referenceId = Str::uuid()->toString();

        RunImageGeneration::dispatch(
            description: $request->description,
            referenceId: $referenceId,
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url' => route('job_status_image', ['referenceId' => $referenceId]),
                ],
                message: 'Image generation job queued successfully'
            ),
            202
        );
    }

    public function testingGeminiUsecase(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|max:100',
        ]);

        $text = app(\App\Usecase\TextGenerationtUsecase::class)
            ->generateTextGemini($request->topic, $request->level);

        return response()->json(
            Response::buildSuccess(
                data: [
                    'generated_text' => $text,
                ],
                message: 'Text generated successfully'
            )
        );
    }

    public function JobTextstatus(string $referenceId)
    {
        $filePath = "generated-texts/{$referenceId}.txt";

        if (Storage::disk('local')->exists($filePath)) {
            $content = Storage::disk('local')->get($filePath);

            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'completed',
                        'content' => $content,
                    ],
                    message: 'Text generation completed'
                )
            );
        }

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status' => 'processing',
                ],
                message: 'Text generation is still in progress'
            ),
            202
        );
    }

    public function JobImageStatus(string $referenceId)
    {
        $filePath = "generated-images/{$referenceId}.png";

        if (Storage::disk('public')->exists($filePath)) {
            return response()->json(
                Response::buildSuccess(
                    data: [
                        'reference_id' => $referenceId,
                        'status' => 'completed',
                        'image_url' => Storage::url($filePath),
                    ],
                    message: 'Image generation completed'
                )
            );
        }

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status' => 'processing',
                ],
                message: 'Image generation is still in progress'
            ),
            202
        );
    }
}
