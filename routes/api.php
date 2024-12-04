<?php
use App\Http\Controllers\Api\NotebookController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/notebook')->group(function () {
    Route::get('/',        [NotebookController::class, 'index']);   // Список с пагинацией
    Route::post('/',       [NotebookController::class, 'store']);   // Создание новой записи
    Route::get('/{id}',    [NotebookController::class, 'show']);    // Просмотр записи по ID
    Route::post('/{id}',   [NotebookController::class, 'update']);  // Обновление записи
    Route::delete('/{id}', [NotebookController::class, 'destroy']); // Удаление записи
});
