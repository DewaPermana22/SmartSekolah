<?php

namespace App\Http\Controllers;

use App\Http\Presenter\Response;
use App\Jobs\RunTextGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    public function generate(Request $request)
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
                    'status_url' => route('generate_text_status', ['referenceId' => $referenceId]),
                ],
                message: 'Text generation job queued successfully'
            ),
            202
        );
    }

    public function testingGptUsecase(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|max:100',
        ]);

        $text = app(\App\Usecase\TextGenerationtUsecase::class)
            ->generateTextOpenAi($request->topic, $request->level);

        return response()->json(
            Response::buildSuccess(
                data: [
                    'generated_text' => $text,
                ],
                message: 'Text generated successfully'
            )
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

    public function testingDeepsekUsecase(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'level' => 'required|string|max:100',
        ]);

        $text = app(\App\Usecase\TextGenerationtUsecase::class)
            ->generateTextDeepseek($request->topic, $request->level);

        return response()->json(
            Response::buildSuccess(
                data: [
                    'generated_text' => $text,
                ],
                message: 'Text generated successfully'
            )
        );
    }

    public function status(string $referenceId)
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

}
