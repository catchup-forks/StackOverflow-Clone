<?php

use App\Http\Controllers\Admin\PostController as AdminPostController;
use Illuminate\Support\Facades\Route;

Route::patch('admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
