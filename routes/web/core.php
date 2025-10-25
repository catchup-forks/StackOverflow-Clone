<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::resource('answer', AnswerController::class);
Route::resource('question', QuestionController::class);
Route::resource('questions', QuestionsController::class);
Route::resource('tag', TagController::class);
Route::resource('tags', TagsController::class);
Route::resource('user', UserController::class);
Route::resource('users', UsersController::class);

Route::get('test', function () {
    $posts = Post::where('post_type_id', '=', 1)->paginate(10);

    return $posts->links();
});
