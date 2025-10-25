<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('question', [QuestionController::class, 'index'])->name('question.index');
Route::get('question/create', [QuestionController::class, 'create'])->name('question.create');
Route::post('question', [QuestionController::class, 'store'])->name('question.store');
Route::get('question/{question}', [QuestionController::class, 'show'])->name('question.show');
Route::get('question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
Route::patch('question/{question}', [QuestionController::class, 'update'])->name('question.update');
Route::delete('question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');
