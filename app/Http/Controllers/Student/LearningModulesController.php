<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\SubjectUsecase;
use App\Usecase\Teacher\LearningModulesUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningModulesController extends Controller
{
    protected array $page = [
        'route' => 'learning-modules',
        'title' => 'Modul Belajar'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected LearningModulesUsecase $usecase,
        protected SubjectUsecase $subjectUsecase
    ) {
        $this->baseRedirect = 'student/' . $this->page['route'];
    }

    public function index(Request $request): View
    {
        $subjects = $this->subjectUsecase->getAll(["no_pagination" => true]);
        $subjectsData = $subjects['data']['list'] ?? [];

        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_student.learning_modules.index', [
            'data' => $data,
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
            'subjects' => $subjectsData,
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
    }


}
