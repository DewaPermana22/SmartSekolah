<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\UseCase\Teacher\TeacherQuizUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizGeneratorController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/quiz-generator',
        'title' => 'Alat AI - Pembuat Kuis'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected TeacherQuizUsecase $usecase
    ) {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request)
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'type' => $request->get('type'),
        ]);

        $data = $data['data']['list'] ?? [];
        return view('_teacher.ai_tools.quiz.index', [
            'page' => $this->page,
            'data' => $data,
            'keywords' => $request->get('keywords'),
            'type' => $request->get('type'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('_teacher.ai_tools.quiz.add', [
            'page' => $this->page,
        ]);
    }

    public function detail(int $id)
{
    $result = $this->usecase->getById($id);

    if (!$result['success']) {
        return redirect($this->baseRedirect)
            ->with('error', $result['message'] ?? 'Data tidak ditemukan');
    }

    // Ambil data utama dari response usecase
    $rawDetail = $result['data']['data'] ?? [];

    return view('_teacher.ai_tools.quiz.detail', [
        'page'      => $this->page,
        'quiz'      => $rawDetail['quiz'] ?? null,      // Objek Kuis
        'questions' => $rawDetail['questions'] ?? [],  // Koleksi Pertanyaan
    ]);
}

    public function delete(int $id)
    {
        $result = $this->usecase->delete($id);

        if ($result['success']) {
            return redirect($this->baseRedirect)
                ->with('success', 'Data berhasil dihapus');
        }

        return redirect($this->baseRedirect)
            ->with('error', $result['message'] ?? 'Gagal menghapus data');
    }
}
