<?php

namespace App\Http\Controllers;

use App\Constants\DatabaseConst;
use App\Usecase\UserUsecase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(
        private UserUsecase $userUsecase
    ) {}

    public function login()
    {
        return view('_admin.auth.login');
    }
    public function register()
    {
        return view('_admin.auth.register');
    }

    public function doRegister(Request $request)
    {
        $result = $this->userUsecase->register($request);

        if (! $result['success']) {
            return back()
                ->withErrors(['register_error' => $result['message']])
                ->withInput();
        }

        Auth::loginUsingId($result['data']['user_id']);

        return redirect()
            ->route('school.register')
            ->with('success', 'Akun berhasil dibuat! Silakan daftarkan sekolah Anda.');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'login_error' => 'Email atau Password tidak sesuai, periksa kembali',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
