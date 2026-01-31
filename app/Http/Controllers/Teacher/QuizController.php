<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class QuizController extends Controller
{
    protected array $page = [
        'route' => 'quiz',
        'title' => 'Manajemen Kuis',
    ];

    protected string $baseRedirect;

    public function __construct()
    {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request): View
    {
        $collection = collect([
            (object) [
                'id' => 1,
                'name' => 'Kuis Matematika Bab 1',
                'topic' => 'Aljabar Dasar',
                'question_count' => 20,
                'participants_count' => 15,
                'grade' => 'SMP',
                'class' => '7',
                'created_at' => now()->subDays(5),
            ],
            (object) [
                'id' => 2,
                'name' => 'Kuis IPA - Sistem Pernapasan',
                'topic' => 'Biologi',
                'question_count' => 15,
                'participants_count' => 18,
                'grade' => 'SMP',
                'class' => '8',
                'created_at' => now()->subDays(3),
            ],
        ]);

        $perPage = 10;
        $page = $request->get('page', 1);

        $data = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('_teacher.quiz.index', [
            'page' => $this->page,
            'data' => $data,
            'keywords' => $request->get('keywords'),
        ]);
    }

    public function create(): View
    {
        return view('_teacher.quiz.add', [
            'page' => $this->page,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // TODO: Implement quiz creation logic

        return redirect()->route('teacher.quiz.index')
            ->with('success', 'Kuis berhasil dibuat');
    }

    public function detail(int $id): View|RedirectResponse
    {
        // TODO: Implement logic to fetch quiz detail
        $data = (object) [
            'id' => $id,
            'name' => 'Kuis Matematika Bab 1',
            'topic' => 'Aljabar Dasar',
            'description' => 'Kuis untuk menguji pemahaman aljabar dasar',
            'question_count' => 20,
            'duration' => 60,
            'grade' => 'SMP',
            'class' => '7',
            'created_at' => now()->subDays(5),
            'questions' => [],
        ];

        return view('_teacher.quiz.detail', [
            'page' => $this->page,
            'data' => $data,
        ]);
    }

    public function scores(int $id): View|RedirectResponse
    {
        $quiz = (object) [
            'id' => $id,
            'name' => 'Kuis Matematika Bab 1',
            'topic' => 'Aljabar Dasar',
        ];

        $collection = collect([
            (object) [
                'id' => 1,
                'student_name' => 'Ahmad Fauzi',
                'student_nisn' => '0012345678',
                'score' => 85,
                'correct_answers' => 17,
                'total_questions' => 20,
                'completed_at' => now()->subHours(2),
            ],
            (object) [
                'id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'student_nisn' => '0012345679',
                'score' => 90,
                'correct_answers' => 18,
                'total_questions' => 20,
                'completed_at' => now()->subHours(3),
            ],
        ]);

        $perPage = 10;
        $page = request()->get('page', 1);

        $scores = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('_teacher.quiz.scores', [
            'page' => $this->page,
            'quiz' => $quiz,
            'scores' => $scores,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        // TODO: Implement quiz deletion logic

        return redirect()->route('teacher.quiz.index')
            ->with('success', 'Kuis berhasil dihapus');
    }
}
