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
Route::resource('answer', AnswerController::class)->except(['create']);
Route::resource('question', QuestionController::class);
Route::get('questions', [QuestionController::class, 'index'])->name('questions.index');
Route::resource('tag', TagController::class);
Route::resource('tags', TagController::class);
Route::resource('users', UserController::class);

Route::post('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
Route::post('users/{user}/profile', [UserController::class, 'updateProfile'])->name('users.profile');

Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::post('comments/{comment}/flag', [CommentController::class, 'flag'])->name('comments.flag');
Route::patch('comments/{comment}/admin', [CommentController::class, 'adminUpdate'])->name('comments.adminUpdate');

Route::patch('admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
