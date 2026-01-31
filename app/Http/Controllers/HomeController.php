<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCase\QuizUsecase;
use Illuminate\Http\JsonResponse;
use App\Usecase\LandingPageUsecase;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private $useCase;
    private $quizUsecase;
    public function __construct(LandingPageUsecase $landingPageUsecase, QuizUsecase $quizUsecase) {
        $this->useCase = $landingPageUsecase;
        $this->quizUsecase = $quizUsecase;
    }

    public function index()
    {
        $mapel = $this->useCase->getAllSubject();
        return view('_home.landing', [
            'mapel' => $mapel['data']['list']
        ]);
    }

    public function quizsoal() {
        $soal = $this->quizUsecase->getQuizForSoalByQuizId(9);
        $quiz = $soal['data']['quiz'];

        $time = $quiz->quiz_time;
        [$jam, $menit, $detik] = array_map('intval', explode(':', $time));

        $totalDetik = ($jam * 3600) + ($menit * 60) + $detik;
        
        return view('_home.quiz.soal', [
            'quiz' => $quiz,
            'time' => $totalDetik,
            'soal' => $soal['data']['questions']
        ]);
    }

    public function hasilquiz(Request $request) {
        $time = $request->time;
        $quizId  = $request->quiz_id;
        $results = json_decode($request->results, true); // 🔥 penting

        if (!is_array($results)) {
            return redirect()->back()->with('error', 'Data jawaban tidak valid');
        }

        $time = (int) $request->time;

        $hasilTime = null;
        if ($time < 60) {
            $hasilTime = $time . ' detik';
        } else {
            $menit = floor($time / 60);
            $detik = $time % 60;

            $hasilTime = $detik > 0
                ? $menit . ' menit ' . $detik . ' detik'
                : $menit . ' menit';
        }

        $data = $this->quizUsecase->checkQuizResult($quizId, $results);
        $quiz = $this->quizUsecase->getQuizByQuizId($quizId);

        return view('_home.quiz.hasil', [
            'data' => $data,
            'quiz' => $quiz['data'],
            'time' => $hasilTime
        ]);
    }

    public function get_materi(int $jenjang, int $kelas, string $mapel): JsonResponse
    {
        try {
            $subjectId = $mapel === 'semua' ? null : (int) $mapel;

            $materi = $this->useCase->getLearningModulFilter(
                $jenjang,
                $kelas,
                $subjectId
            );

            return response()->json([
                'status' => true,
                'data'   => $materi['data']['list'],
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function materi_download(string $id)
    {
        try {
            $result = $this->useCase->getLearningModulById($id);
            $modul  = $result['data']['detail'] ?? null;

            // ❌ Data tidak ditemukan
            if (! $modul) {
                return redirect()->back()->with('error', 'Materi tidak ditemukan');
            }

            $path = $modul->file_path; // learning_modules/1.pdf

            // ❌ File tidak ada
            if (! Storage::disk('public')->exists($path)) {
                return redirect()->back()->with('error', 'File materi tidak tersedia');
            }

            // ✅ Download file
            return Storage::disk('public')->download($path);

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

}
