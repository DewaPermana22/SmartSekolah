<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Presenter\Response;
use App\Jobs\RunTextGeneration;
use App\Jobs\RunImageGeneration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ToolsController extends Controller
{
    public function doCreateMateri(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'categories' => 'required|string|exists:prompt_text_generation,categories',
        ]);

        $referenceId = Str::uuid()->toString();

        RunTextGeneration::dispatch(
            referenceId: $referenceId,
            description: $request->description,
            categories: $request->categories
        );

        return response()->json(
            Response::buildSuccess(
                data: [
                    'reference_id' => $referenceId,
                    'status_url'   => route('job_status_text', ['referenceId' => $referenceId]),
                ],
                message: 'Text generation job queued successfully'
            ),
            202
        );
    }


    public function doCreate(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'image_style_id' => 'nullable|integer|exists:prompt_image_generation,id',
        ]);

        $referenceId = Str::uuid()->toString();

        RunImageGeneration::dispatch(
            description: $request->description,
            referenceId: $referenceId,
            imageStyleId: $request->image_style_id,
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
