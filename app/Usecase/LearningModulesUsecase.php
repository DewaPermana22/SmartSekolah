<?php

namespace App\Usecase;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LearningModulesUsecase extends Usecase
{

    public function getAll(array $filterData = []): array
    {
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $query = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SUBJECT . ' as s', 'lm.subject_id', '=', 's.id')
                ->where('lm.created_by', $userId)
                ->whereNull('lm.deleted_at')
                ->select(
                    'lm.id',
                    'lm.title',
                    'lm.classroom',
                    'lm.file_path',
                    'lm.created_at',
                )
                ->orderBy('lm.created_at', 'desc');

            if (!empty($filterData['keywords'])) {
                $query->where('lm.title', 'like', '%' . $filterData['keywords'] . '%')->orWhere('s.name', 'like', '%' . $filterData['keywords'] . '%');
            }

            $data = $query->paginate(20);

            return Response::buildSuccess(
                ['list' => $data],
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
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,webp|max:10240',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $userId = Auth::user()?->id;
            if (!$userId) {
                throw new Exception('User not authenticated');
            }

            $file = $data->file('file');

            $originalName = $file->getClientOriginalName();

            $filePath = Storage::disk('public')->putFileAs(
                'learning_modules',
                $file,
                $originalName
            );

            DB::table(DatabaseConst::LEARNING_MODULE)->insert([
                'title' => $data->title,
                'subject_id' => $data->subject_id,
                'classroom' => $data->classroom,
                'file_path' => $filePath,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }


    public function getById(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::LEARNING_MODULE . ' as lm')
                ->join(DatabaseConst::SUBJECT . ' as s', 'lm.subject_id', '=', 's.id')
                ->join(DatabaseConst::USER . ' as u', 'lm.created_by', '=', 'u.id')
                ->where('lm.id', $id)
                ->whereNull('lm.deleted_at')
                ->select(
                    'lm.id',
                    'lm.title',
                    'lm.classroom',
                    'lm.file_path',
                    's.name as subject_name',
                    'u.name as created_by_name',
                    'lm.created_at',
                    'lm.updated_at',
                )
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound('Data modul pembelajaran tidak ditemukan');
            }

            return Response::buildSuccess(
                ['data' => $data],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }


    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'title' => 'required|string|max:255',
            'subject_id' => 'required|integer|exists:subjects,id',
            'classroom' => 'required|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
                    'title' => $data->title,
                    'subject_id' => $data->subject_id,
                    'classroom' => $data->classroom,
                    'file_path' => $data->file ? $data->file->store('learning_modules') : DB::raw('file_path'),
                    'updated_at' => now(),
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            DB::table(DatabaseConst::LEARNING_MODULE)
                ->where('id', $id)
                ->update([
                    'deleted_at' => now(),
                ]);

            DB::commit();
            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['method' => __METHOD__]);
            return Response::buildErrorService($e->getMessage());
        }
    }
}
