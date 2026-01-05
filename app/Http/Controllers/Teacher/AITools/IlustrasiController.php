<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Usecase\PromptImageUsecase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class IlustrasiController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/ilustrasi',
        'title' => 'AI Tools - Ilustrasi'
    ];

    protected string $baseRedirect;
    protected PromptImageUsecase $usecase;

    public function __construct(PromptImageUsecase $usecase)
    {
        $this->usecase = $usecase;
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request): View
    {
        return view('_teacher.ai_tools.ilustrasi.index', [
            'page' => $this->page,
        ]);
    }

    public function create(Request $request): View | Response
    {
        $data = $this->usecase->getAll();

        return view('_teacher.ai_tools.ilustrasi.add', [
            'data' => $data['data']['list'] ?? [],
            'page' => $this->page,
        ]);
    }
}
