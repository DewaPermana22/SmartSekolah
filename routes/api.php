<?php

use App\Http\Controllers\ToolsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//AI Tools
Route::prefix('tools')->group(function () {
    Route::post('/generate-text', [ToolsController::class, 'generate'])->name('generate_text');
    Route::post('/testing-gpt-usecase', [ToolsController::class, 'testingGptUsecase'])->name('testing_gpt_usecase');
    Route::get('/status/{referenceId}', [ToolsController::class, 'status'])->name('generate_text_status');
});
