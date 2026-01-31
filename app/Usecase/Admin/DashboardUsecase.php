<?php

namespace App\Usecase\Admin;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use App\Usecase\Usecase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardUsecase extends Usecase
{
    public function __construct() {}

    public function getDashboardStats(): array
    {
        try {
            $schoolId = Auth::user()->school_id;

            if (! $schoolId) {
                throw new Exception('School ID not found for the authenticated user');
            }

            $totalTeachers = DB::table(DatabaseConst::TEACHER)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            $totalStudents = DB::table(DatabaseConst::STUDENT)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            $totalClassrooms = DB::table(DatabaseConst::CLASSROOM)
                ->where('school_id', $schoolId)
                ->whereNull('deleted_at')
                ->count();

            // Count learning modules where the teacher belongs to this school
            $totalLearningModules = DB::table(DatabaseConst::LEARNING_MODULE)
                ->join(DatabaseConst::TEACHER, DatabaseConst::LEARNING_MODULE.'.teacher_id', '=', DatabaseConst::TEACHER.'.id')
                ->where(DatabaseConst::TEACHER.'.school_id', $schoolId)
                ->whereNull(DatabaseConst::LEARNING_MODULE.'.deleted_at')
                ->whereNull(DatabaseConst::TEACHER.'.deleted_at')
                ->count();

            $chartData = $this->getMonthlyRegistrationStats($schoolId);

            return Response::buildSuccess(
                [
                    'total_teachers' => $totalTeachers,
                    'total_students' => $totalStudents,
                    'total_classrooms' => $totalClassrooms,
                    'total_learning_modules' => $totalLearningModules,
                    'chart_data' => $chartData,
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

    public function getMonthlyRegistrationStats(int $schoolId): array
    {
        try {
            $currentYear = Carbon::now()->year;

            // Create categories for all 12 months
            $categories = [];
            for ($month = 1; $month <= 12; $month++) {
                $date = Carbon::create($currentYear, $month, 1);
                $categories[] = $date->format('M Y');
            }

            // Initialize data arrays with zeros
            $teacherData = array_fill(0, 12, 0);
            $studentData = array_fill(0, 12, 0);

            // Calculate cumulative totals for each month
            for ($month = 1; $month <= 12; $month++) {
                $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth();

                // Count teachers registered up to end of this month
                $teacherCount = DB::table(DatabaseConst::TEACHER)
                    ->join(DatabaseConst::USER, DatabaseConst::TEACHER.'.user_id', '=', DatabaseConst::USER.'.id')
                    ->where(DatabaseConst::TEACHER.'.school_id', $schoolId)
                    ->where(DatabaseConst::USER.'.created_at', '<=', $endOfMonth)
                    ->whereNull(DatabaseConst::USER.'.deleted_at')
                    ->whereNull(DatabaseConst::TEACHER.'.deleted_at')
                    ->count();

                // Count students registered up to end of this month
                $studentCount = DB::table(DatabaseConst::STUDENT)
                    ->join(DatabaseConst::USER, DatabaseConst::STUDENT.'.user_id', '=', DatabaseConst::USER.'.id')
                    ->where(DatabaseConst::STUDENT.'.school_id', $schoolId)
                    ->where(DatabaseConst::USER.'.created_at', '<=', $endOfMonth)
                    ->whereNull(DatabaseConst::USER.'.deleted_at')
                    ->whereNull(DatabaseConst::STUDENT.'.deleted_at')
                    ->count();

                $teacherData[$month - 1] = $teacherCount;
                $studentData[$month - 1] = $studentCount;
            }

            // Format for ApexCharts
            $series = [
                [
                    'name' => 'Guru',
                    'data' => array_values($teacherData),
                ],
                [
                    'name' => 'Siswa',
                    'data' => array_values($studentData),
                ],
            ];

            return [
                'categories' => $categories,
                'series' => $series,
            ];
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: [
                    'method' => __METHOD__,
                ]
            );

            return [
                'categories' => [],
                'series' => [],
            ];
        }
    }
}