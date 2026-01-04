<?php

namespace App\Http\Controllers;

use App\Constants\ResponseConst;
use App\Usecase\ImageModelUsecase;
use Illuminate\Http\Request;

class ImageModelController extends Controller
{
    public function __construct(
        protected ImageModelUsecase $usecase
    ) {}

    public function add()
    {
        return response()->noContent();
    }

    public function doCreate(Request $request)
    {
        $process = $this->usecase->create($request);

        if ($process['success']) {
            return redirect()
                ->route('image-model.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function edit(int $id)
    {
        return response()->noContent();
    }

    public function doUpdate(Request $request, int $id)
    {
        $process = $this->usecase->update($request, $id);

        if ($process['success']) {
            return redirect()
                ->route('image-model.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id)
    {
        $process = $this->usecase->delete($id);

        if ($process['success']) {
            return redirect()
                ->route('image-model.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}
