<?php

use App\Http\Controllers\Teacher\ToolsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//AI Tools
Route::prefix('tools')->group(function () {
    Route::post('/ilustration', [ToolsController::class, 'doCreate'])->name('create_ilustration');
Route::post('/materi', [ToolsController::class, 'doCreateMateri'])->name('create_materi');
});

Route::prefix('status')->group(function () {
    Route::get('/text/{referenceId}', [ToolsController::class, 'JobTextStatus'])->name('job_status_text');
    Route::get('/ilustration/{referenceId}', [ToolsController::class, 'JobImageStatus'])->name('job_status_image');
});
