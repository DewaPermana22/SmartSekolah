<?php

use App\Http\Controllers\ToolsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//AI Tools
Route::prefix('tools/text')->group(function () {
    Route::post('/generate-text', [ToolsController::class, 'generateText'])->name('generate_text');
    Route::post('/gemini', [ToolsController::class, 'testingGeminiUsecase'])->name('generate_text_gemini');
});

Route::prefix('tools/image')->group(function () {
    Route::post('/infographics', [ToolsController::class, 'generateInfographics'])->name('generate_image_infographics');
});

Route::prefix('status')->group(function () {
    Route::get('/text/{referenceId}', [ToolsController::class, 'JobTextStatus'])->name('job_status_text');
    Route::get('/image/{referenceId}', [ToolsController::class, 'JobImageStatus'])->name('job_status_image');
});
