<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Usecase\Teacher\LearningModulesUsecase;
use Illuminate\Http\Request;

class LearningModulesController extends Controller
{
    protected array $page = [
        'route' => 'learning-modules',
        'title' => 'Learning Modules'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected LearningModulesUsecase $usecase,
    ) {
        $this->baseRedirect = 'student/' . $this->page['route'];
    }

    public function index(Request $request)
    {
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
            'subject_id' => $request->get('subject_id'),
            'classroom' => $request->get('classroom'),
        ]);
    }


}
