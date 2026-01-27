<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('_home.landing');
    }
    
    public function kumpulan_materi()
    {
        return view('_home.kumpulan_materi');
    }

    public function detail_materi()
    {
        return view('_home.detail_materi');
    }
}
