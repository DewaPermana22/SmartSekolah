<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use App\Http\Presenter\Response as PresenterResponse;
use App\Jobs\RunImageGeneration;
use App\Usecase\ImageGenerationUsecase;
use App\Usecase\PromptImageUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class IlustrasiController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/ilustrasi',
        'title' => 'AI Tools - Ilustrasi'
    ];

    protected string $baseRedirect;
    protected PromptImageUsecase $usecase;
    protected ImageGenerationUsecase $ilustrationUsecase;

    public function __construct(PromptImageUsecase $usecase, ImageGenerationUsecase $ilustrationUsecase)
    {
        $this->usecase = $usecase;
        $this->ilustrationUsecase = $ilustrationUsecase;
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(): View
    {
        return view('_teacher.ai_tools.ilustrasi.index', [
            'page' => $this->page,
        ]);
    }

    public function create(): View
    {
        $data = $this->usecase->getAll();

        return view('_teacher.ai_tools.ilustrasi.add', [
            'data' => $data['data']['list'] ?? [],
            'page' => $this->page,
        ]);
    }
}
