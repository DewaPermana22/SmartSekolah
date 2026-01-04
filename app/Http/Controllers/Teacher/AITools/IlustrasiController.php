<?php

namespace App\Http\Controllers\Teacher\AITools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IlustrasiController extends Controller
{
    protected array $page = [
        'route' => 'ai-tools/ilustrasi',
        'title' => 'AI Tools - Ilustrasi'
    ];

    protected string $baseRedirect;

    public function __construct()
    {
        $this->baseRedirect = 'teacher/' . $this->page['route'];
    }

    public function index(Request $request): View
    {
        return view('_teacher.ai_tools.ilustrasi.index', [
            'page' => $this->page,
        ]);
    }

    public function create(Request $request): View
    {
        return view('_teacher.ai_tools.ilustrasi.add', [
            'page' => $this->page,
        ]);
    }
}
