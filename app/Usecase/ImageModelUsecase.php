<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageModelUsecase
{
    public function getAll(): array
    {
        try {
            $data = DB::table(DatabaseConst::IMAGE_MODEL)
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return Response::buildSuccess(
                ['list' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getById(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::IMAGE_MODEL)
                ->whereNull('deleted_at')
                ->where('id', $id)
                ->first();

            if (!$data) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Image model not found.');
            }

            return Response::buildSuccess(
                ['item' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name'  => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validator->validate();

        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $file = $data->file('image');
            $fileName = uniqid('img_') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/image-models', $fileName);

            DB::table(DatabaseConst::IMAGE_MODEL)->insert([
                'name' => $data->name,
                'image_path_preview' => Storage::url($path),
                'created_by' => Auth::user()?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validator->validate();

        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $imageModel = DB::table(DatabaseConst::IMAGE_MODEL)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$imageModel) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Image model not found.');
            }

            $payload = [
                'name' => $data->name,
                'updated_by' => Auth::user()?->id,
                'updated_at' => now(),
            ];

            if ($data->hasFile('image')) {
                if ($imageModel->image_path_preview) {
                    $oldPath = str_replace('/storage/', 'public/', $imageModel->image_path_preview);
                    Storage::delete($oldPath);
                }

                $file = $data->file('image');
                $fileName = uniqid('img_') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/image-models', $fileName);
                $payload['image_path_preview'] = Storage::url($path);
            }

            DB::table(DatabaseConst::IMAGE_MODEL)
                ->where('id', $id)
                ->update($payload);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        if (!Gate::allows('admin-only')) {
            return Response::buildError(ResponseConst::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        DB::beginTransaction();
        try {
            $imageModel = DB::table(DatabaseConst::IMAGE_MODEL)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$imageModel) {
                return Response::buildError(ResponseConst::HTTP_NOT_FOUND, 'Image model not found.');
            }

            if ($imageModel->image_path_preview) {
                $path = str_replace('/storage/', 'public/', $imageModel->image_path_preview);
                Storage::delete($path);
            }

            DB::table(DatabaseConst::IMAGE_MODEL)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                    'updated_by' => Auth::user()?->id,
                    'updated_at' => now(),
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}
