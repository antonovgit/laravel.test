<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('article-json', [App\Http\Controllers\Api\ArticleController::class, 'show']);

Route::put('article-views-increment', [App\Http\Controllers\Api\ArticleController::class, 'viewsIncrement']);
Route::put('article-likes-increment', [App\Http\Controllers\Api\ArticleController::class, 'likesIncrement']);

Route::post('article-add-comment', [App\Http\Controllers\Api\CommentController::class, 'store']);

//Если человек введет любой не использующийся роут. ..Как у нас ..в качестве ГЕТ запроса человек ввел роут, который был предназначен для ПОСТ запроса, то будет выдаваться 404 ошибка..и при этом не важно переменная APP_DEBUG false или true в файле .env
Route::fallback(function() {
    abort(404);
});