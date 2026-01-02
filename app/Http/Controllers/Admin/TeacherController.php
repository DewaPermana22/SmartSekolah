<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ResponseConst;
use App\Http\Controllers\Controller;
use App\Usecase\TeacherUsecase;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

class TeacherController extends Controller
{
    protected array $page = [
        'route' => 'teachers',
        'title' => 'Manajemen Guru',
    ];

    protected string $baseRedirect;

    public function __construct(
        protected TeacherUsecase $usecase,
    ) {
        $this->baseRedirect = 'admin/' . $this->page['route'];
    }

    public function index(Request $request): View|Response
    {
        $data = $this->usecase->getAll([
            'keywords' => $request->get('keywords'),
        ]);

        return view('_admin.teachers.index', [
            'data' => $data['data']['list'] ?? [],
            'page' => $this->page,
            'keywords' => $request->get('keywords'),
        ]);
    }

    public function add(): View|Response
    {
        return view('_admin.teachers.add', [
            'page' => $this->page,
        ]);
    }

    public function doCreate(Request $request): RedirectResponse
    {
        $process = $this->usecase->create(data: $request);

        if ($process['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_CREATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function update(int $id): View|RedirectResponse|Response
    {
        $student = $this->usecase->getById(id: $id);
        if (empty($student['data'])) {
            return redirect()->intended($this->baseRedirect)->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_admin.teachers.update', [
            'page' => $this->page,
            'data' => $student['data']['data'],
        ]);
    }

    public function doUpdate(int $id, Request $request): RedirectResponse
    {
        $process = $this->usecase->update(id: $id, data: $request);

        if ($process['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_UPDATED);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function delete(int $id): RedirectResponse
    {
        $process = $this->usecase->delete(id: $id);

        if ($process['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', ResponseConst::SUCCESS_MESSAGE_DELETED);
        }

        return redirect()
            ->route('admin.teachers.index')
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }

    public function resetPassword(int $id): View|RedirectResponse
    {
        $teacher = $this->usecase->getById(id: $id);
        if (empty($teacher['data'])) {
            return redirect()->intended($this->baseRedirect)->with('error', ResponseConst::DEFAULT_ERROR_MESSAGE);
        }

        return view('_admin.teachers.reset_password', [
            'page' => $this->page,
            'data' => $teacher['data']['data'],
            'id' => $id,
        ]);
    }

    public function doResetPassword(int $id, Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $process = $this->usecase->resetPassword(id: $id, password: $request->password);

        if ($process['success']) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', 'Password guru berhasil direset.');
        }

        return redirect()
            ->back()
            ->with('error', $process['message'] ?? ResponseConst::DEFAULT_ERROR_MESSAGE);
    }
}
