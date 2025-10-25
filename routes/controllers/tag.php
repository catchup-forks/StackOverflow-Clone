<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::get('tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
Route::patch('tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
