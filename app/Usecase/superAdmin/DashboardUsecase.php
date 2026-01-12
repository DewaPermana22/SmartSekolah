<?php

namespace App\Usecase\superAdmin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DashboardUsecase extends Usecase
{
    public function __construct()
    {
    }

    public function getDashboardStats(): array
    {
        try {
            $totalSchools = DB::table(DatabaseConst::SCHOOL)
                ->whereNull('deleted_at')
                ->count();

            $totalTeachers = DB::table(DatabaseConst::TEACHER)
                ->whereNull('deleted_at')
                ->count();

            $totalStudents = DB::table(DatabaseConst::STUDENT)
                ->whereNull('deleted_at')
                ->count();

            return Response::buildSuccess(
                [
                    'total_schools' => $totalSchools,
                    'total_teachers' => $totalTeachers,
                    'total_students' => $totalStudents,
                ],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return Response::buildErrorService($e->getMessage());
        }
    }


}
