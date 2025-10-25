<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;

Route::get('answer', [AnswerController::class, 'index'])->name('answer.index');
Route::post('answer', [AnswerController::class, 'store'])->name('answer.store');
Route::get('answer/{answer}', [AnswerController::class, 'show'])->name('answer.show');
Route::get('answer/{answer}/edit', [AnswerController::class, 'edit'])->name('answer.edit');
Route::patch('answer/{answer}', [AnswerController::class, 'update'])->name('answer.update');
Route::delete('answer/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');
