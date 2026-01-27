<?php

namespace App\Http\Controllers\superAdmin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\superAdmin\DashboardUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    protected array $page = [
        'route' => 'dashboard',
        'title' => 'Dashboard',
    ];

    public function __construct(
        protected DashboardUsecase $usecase
    ) {}

    public function index(): View
    {
        $data = $this->usecase->getDashboardStats();
        $stats = $data['data'] ?? [];

        $stats = array_merge([
            'total_schools'  => 0,
            'total_students' => 0,
            'total_teachers' => 0,
        ], $stats);


        return view('_super_admin.dashboard', [
            'stats' => $stats,
            'page' => $this->page,
        ]);
    }
}
