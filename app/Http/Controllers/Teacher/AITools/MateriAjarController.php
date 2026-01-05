<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Usecase\AiMateriAjarUsecase;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriAjarController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/materi-ajar',
        'title' => 'AI Tools - Materi Ajar'
    ];

    protected string $baseRedirect;

    public function __construct(
        protected AiMateriAjarUsecase $usecase
    )
    {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request)
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);
        $data = $data['data']['list'] ?? [];

        return view('_teacher.ai_tools.materi.index', [
            'page' => $this->page,
            'data' => $data,
        ]);
    }

    public function create(Request $request): View
    {
        return view('_teacher.ai_tools.materi.add', [
            'page' => $this->page,
        ]);
    }
}
