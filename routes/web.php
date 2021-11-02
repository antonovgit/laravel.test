<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index'])->name('article.index');

Route::get('/articles/{slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('article.show');

//Мы не можем написать урл таким образом '/articles/{tag}', потому что в данном слчае это работать не будет, т.к. данный рот будет конфликтовать с роутом '/articles/{slug}', поэтому вложенность роутов будет несколько другая, иначе Ларавель не будет понимать что мы ему предлагаем слаг или тег
Route::get('/articles/tag/{tag}', [App\Http\Controllers\ArticleController::class, 'allByTag'])->name('article.tag');