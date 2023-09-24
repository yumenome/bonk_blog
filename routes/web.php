<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::get('/comments/delete/{id}', [CommentController::class, 'delete']);
Route::post('/comments/add', [CommentController::class, 'create']);

                    // to use the method(index) inside ArticleController
Route::get('/articles', [ArticleController::class,'index']);

Route::post('/articles/ballon/{id}', [ArticleController::class, 'ballon']);

Route::get('/articles/detail/{id}', [ArticleController::class, 'detail']);

Route::get('/articles/delete/{id}', [ArticleController::class, 'delete']);

Route::get('/articles/add', [ArticleController::class, 'add']);
Route::post('/articles/add', [ArticleController::class, 'create']);

Route::get('/articles/edit/{id}', [ArticleController::class, 'edit']);
Route::post('/articles/edit/{id}', [ArticleController::class, 'update']);

Route::get('/', [ArticleController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
