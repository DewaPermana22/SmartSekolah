<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AIToolsController extends Controller
{
    public function materiAjar(Request $request): View
    {
        return view('_teacher.ai_tools.materi');
    }

    public function illustrasi(Request $request): View
    {
        return view('_teacher.ai_tools.illustrasi');
    }
}