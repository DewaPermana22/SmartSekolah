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
use Illuminate\Support\Facades\Validator;

class SubjectUsecase extends Usecase
{
    public function getAll(array $filterData = []): array
    {
        try {
            $query = DB::table(DatabaseConst::SUBJECT)
                ->when($filterData['keywords'] ?? false, function ($query, $keywords) {
                    return $query->where('name', 'like', '%' . $keywords . '%');
                })
                ->orderBy('name', 'asc');

            if (!empty($filterData['no_pagination'])) {
                $data = $query->get();
            } else {
                $data = $query->paginate(20);

                if (!empty($filterData)) {
                    $data->appends($filterData);
                }
            }

            return Response::buildSuccess(
                [
                    'list' => $data,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function getByID(int $id): array
    {
        try {
            $data = DB::table(DatabaseConst::SUBJECT)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if (!$data) {
                return Response::buildErrorNotFound(ResponseConst::ERROR_MESSAGE_NOT_FOUND);
            }

            return Response::buildSuccess(
                data: collect($data)->toArray()
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function create(Request $data): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255|unique:subjects,name,NULL,id,deleted_at,NULL',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $payload = [
                'name' => $data->name,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table(DatabaseConst::SUBJECT)->insert($payload);

            DB::commit();

            return Response::buildSuccessCreated();
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function update(Request $data, int $id): array
    {
        $validator = Validator::make($data->all(), [
            'name' => 'required|string|max:255|unique:subjects,name,' . $id . ',id,deleted_at,NULL',
        ]);

        $validator->validate();

        DB::beginTransaction();
        try {
            $payload = [
                'name' => $data->name,
                'updated_at' => now(),
            ];

            $updated = DB::table(DatabaseConst::SUBJECT)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->update($payload);

            if (!$updated) {
                DB::rollback();
                return Response::buildErrorNotFound('Data mata pelajaran tidak ditemukan');
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_UPDATED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id): array
    {
        DB::beginTransaction();
        try {
            $deleted = DB::table(DatabaseConst::SUBJECT)
                ->where('id', $id)
                ->whereNull('deleted_at')
                ->update([
                    'deleted_at' => now(),
                ]);

            if (!$deleted) {
                DB::rollback();
                return Response::buildErrorNotFound('Data mata pelajaran tidak ditemukan');
            }

            DB::commit();

            return Response::buildSuccess(
                message: ResponseConst::SUCCESS_MESSAGE_DELETED
            );
        } catch (Exception $e) {
            DB::rollback();

            Log::error(
                message: $e->getMessage(),
                context: ['method' => __METHOD__]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }
}
