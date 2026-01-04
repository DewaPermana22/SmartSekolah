<?php

use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TaskCategoryController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher\AITools\IlustrasiController;
use App\Http\Controllers\Teacher\AITools\MateriAjarController;
use App\Http\Controllers\Teacher\LearningModulesController;
use App\Http\Controllers\ImageModelController;
use App\Http\Controllers\TextPromptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');

Route::middleware('auth')->group(function () {
    Route::get('/register-school', [SchoolController::class, 'add'])->name('school.register');
    Route::post('/register-school', [SchoolController::class, 'doCreate'])->name('school.register.post');
});


Route::middleware(['auth', 'check.school'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('_admin.dashboard');
    })->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/create', [UserController::class, 'doCreate'])->name('create');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
        Route::get('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/update/{id}', [UserController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::post('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::prefix('task-categories')->name('task_categories.')->group(function () {
        Route::get('/', [TaskCategoryController::class, 'index'])->name('index');
        Route::get('/add', [TaskCategoryController::class, 'add'])->name('add');
        Route::post('/create', [TaskCategoryController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TaskCategoryController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TaskCategoryController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [TaskCategoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/add', [TaskController::class, 'add'])->name('add');
        Route::post('/create', [TaskController::class, 'doCreate'])->name('do_create');
        Route::get('/update/{id}', [TaskController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TaskController::class, 'doUpdate'])->name('do_update');
        Route::delete('/delete/{id}', [TaskController::class, 'delete'])->name('delete');
    });

    Route::prefix('classrooms')->name('classrooms.')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('index');
        Route::get('/add', [ClassroomController::class, 'add'])->name('add');
        Route::post('/create', [ClassroomController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [ClassroomController::class, 'update'])->name('update');
        Route::post('/update/{id}', [ClassroomController::class, 'doUpdate'])->name('do_update');
        Route::get('/detail/{id}', [ClassroomController::class, 'detail'])->name('detail');
        Route::delete('/delete/{id}', [ClassroomController::class, 'delete'])->name('delete');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/add', [StudentController::class, 'add'])->name('add');
        Route::post('/create', [StudentController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [StudentController::class, 'update'])->name('update');
        Route::post('/update/{id}', [StudentController::class, 'doUpdate'])->name('do_update');
        Route::get('/reset-password/{id}', [StudentController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/reset-password/{id}', [StudentController::class, 'doResetPassword'])->name('doResetPassword');
        Route::delete('/delete/{id}', [StudentController::class, 'delete'])->name('delete');
    });

    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/add', [TeacherController::class, 'add'])->name('add');
        Route::post('/create', [TeacherController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TeacherController::class, 'update'])->name('update');
        Route::post('/update/{id}', [TeacherController::class, 'doUpdate'])->name('do_update');
        Route::get('/reset-password/{id}', [TeacherController::class, 'resetPassword'])->name('resetPassword');
        Route::post('/reset-password/{id}', [TeacherController::class, 'doResetPassword'])->name('doResetPassword');
        Route::delete('/delete/{id}', [TeacherController::class, 'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::post('/change-password', [UserController::class, 'doChangePassword'])->name('do_change_password');
});

    Route::prefix('image-prompts')->name('image-prompts.')->group(function () {
        Route::get('/', [PromptImageController::class, 'index'])->name('index');
        Route::get('/add', [PromptImageController::class, 'add'])->name('add');
        Route::post('/create', [PromptImageController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [PromptImageController::class, 'edit'])->name('update');
        Route::post('/update/{id}', [PromptImageController::class, 'doUpdate'])->name('do_update');
        Route::delete('/delete/{id}', [PromptImageController::class, 'delete'])->name('delete');
    });

    Route::prefix('text-prompts')->name('text-prompt.')->group(function () {
        Route::get('/', [TextPromptController::class, 'index'])->name('index');
        Route::get('/add', [TextPromptController::class, 'add'])->name('add');
        Route::post('/create', [TextPromptController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [TextPromptController::class, 'edit'])->name('update');
        Route::post('/update/{id}', [TextPromptController::class, 'doUpdate'])->name('do_update');
        Route::delete('/delete/{id}', [TextPromptController::class, 'delete'])->name('delete');
    });
});

Route::middleware('auth')->prefix('teacher')->name('teacher.')->group(function () {
    Route::prefix('ai-tools')->name('ai.')->group(function () {
        Route::prefix('materi-ajar')->name('materi_ajar.')->group(function () {
            Route::get('/', [MateriAjarController::class, 'index'])->name('index');
            Route::get('/add', [MateriAjarController::class, 'create'])->name('add');
        });
        Route::prefix('ilustrasi')->name('ilustrasi.')->group(function () {
            Route::get('/', [IlustrasiController::class, 'index'])->name('index');
            Route::get('/add', [IlustrasiController::class, 'create'])->name('add');
        });
    });

    Route::prefix('learning-modules')->name('learning_modules.')->group(function () {
        Route::get('/', [LearningModulesController::class, 'index'])->name('index');
        Route::get('/add', [LearningModulesController::class, 'add'])->name('add');
        Route::post('/create', [LearningModulesController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [LearningModulesController::class, 'update'])->name('update');
        Route::post('/update/{id}', [LearningModulesController::class, 'doUpdate'])->name('do_update');
        Route::get('/detail/{id}', [LearningModulesController::class, 'detail'])->name('detail');
        Route::delete('/delete/{id}', [LearningModulesController::class, 'delete'])->name('delete');
    });
});
