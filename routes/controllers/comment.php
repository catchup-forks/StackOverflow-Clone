<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::post('comments/{comment}/flag', [CommentController::class, 'flag'])->name('comments.flag');
Route::patch('comments/{comment}/admin', [CommentController::class, 'adminUpdate'])->name('comments.adminUpdate');
