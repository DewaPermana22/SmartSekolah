<?php

namespace App\UseCase\Teacher;

use App\Constants\DatabaseConst;
use App\Constants\ResponseConst;
use App\Http\Presenter\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherQuizUsecase
{
    public function getAll(array $filterData = [])
    {
        try {
            $userId = Auth::id();

            $data = DB::table(DatabaseConst::QUIZZES . ' as q')
                ->select([
                    'q.id',
                    'q.quiz_name',
                    'q.description',
                    'q.quiz_code',
                    'q.quiz_time',
                    'q.created_at',
                    DB::raw('(SELECT COUNT(*) FROM ' . DatabaseConst::QUIZ_QUETIONS . ' WHERE quiz_id = q.id) as total_soal'),
                    DB::raw('(SELECT COUNT(DISTINCT student_id) FROM quiz_attempts 
                          WHERE quiz_id = q.id 
                          AND deleted_at IS NULL) as total_students_count')
                ])
                ->where('q.created_by', $userId)
                ->whereNull('q.deleted_at')
                ->orderBy('q.created_at', 'desc')
                ->paginate(20);

            return Response::buildSuccess(['list' => $data], ResponseConst::HTTP_SUCCESS);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return Response::buildErrorService($e->getMessage());
        }
    }


    public function getById(int $id)
    {
        try {
            $userId = Auth::id();

            $quiz = DB::table(DatabaseConst::QUIZZES)
                ->where('id', $id)
                ->where('created_by', $userId)
                ->whereNull('deleted_at')
                ->first();

            if (!$quiz) {
                return Response::buildErrorNotFound('Kuis tidak ditemukan atau Anda tidak memiliki akses.');
            }

            $questions = DB::table(DatabaseConst::QUIZ_QUETIONS)
                ->where('quiz_id', $quiz->id)
                ->get();

            foreach ($questions as $question) {
                $question->options = DB::table(DatabaseConst::QUIZ_OPTIONS)
                    ->where('question_id', $question->id)
                    ->get();
            }

            return Response::buildSuccess(
                ['data' => [
                    'quiz' => $quiz,
                    'questions' => $questions
                ]],
                ResponseConst::HTTP_SUCCESS
            );
        } catch (Exception $e) {
            $this->logError($e, __METHOD__);
            return Response::buildErrorService($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $userId = Auth::id();

            $deleted = DB::table(DatabaseConst::QUIZZES)
                ->where('id', $id)
                ->where('created_by', $userId) // Keamanan: Hanya pembuat yang bisa hapus
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => $userId,
                ]);

            if (!$deleted) {
                return Response::buildErrorNotFound('Gagal menghapus kuis. Data tidak ditemukan.');
            }

            return Response::buildSuccess([], ResponseConst::HTTP_SUCCESS);
        } catch (Exception $e) {
            $this->logError($e, __METHOD__);
            return Response::buildErrorService($e->getMessage());
        }
    }

    private function logError(Exception $e, string $method)
    {
        Log::error($e->getMessage(), [
            'method' => $method,
            'user_id' => Auth::id()
        ]);
    }
}
