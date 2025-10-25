<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('answer', [AnswerController::class, 'index'])->name('answer.index');
Route::post('answer', [AnswerController::class, 'store'])->name('answer.store');
Route::get('answer/{answer}', [AnswerController::class, 'show'])->name('answer.show');
Route::get('answer/{answer}/edit', [AnswerController::class, 'edit'])->name('answer.edit');
Route::patch('answer/{answer}', [AnswerController::class, 'update'])->name('answer.update');
Route::delete('answer/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');

Route::get('question', [QuestionController::class, 'index'])->name('question.index');
Route::get('question/create', [QuestionController::class, 'create'])->name('question.create');
Route::post('question', [QuestionController::class, 'store'])->name('question.store');
Route::get('question/{question}', [QuestionController::class, 'show'])->name('question.show');
Route::get('question/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
Route::patch('question/{question}', [QuestionController::class, 'update'])->name('question.update');
Route::delete('question/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');

Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::get('tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
Route::patch('tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
Route::post('users/{user}/profile', [UserController::class, 'updateProfile'])->name('users.profile');

Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::post('comments/{comment}/flag', [CommentController::class, 'flag'])->name('comments.flag');
Route::patch('comments/{comment}/admin', [CommentController::class, 'adminUpdate'])->name('comments.adminUpdate');

Route::patch('admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
