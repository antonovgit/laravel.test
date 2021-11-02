<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class ArticleController extends Controller
{
    public function index() {
        $articles = Article::allPaginate(10); //scopeAllPaginate($query, $numbers)
        return view('app.article.index', compact('articles'));
    }
    
	public function show($slug) {
        $article = Article::findBySlug($slug); //scopeFindBySlug($query, $slug) //Находит статью по слагу
        return view('app.article.show', compact('article'));
    }
	
	//Из ГЕТ запроса получанет входящим параметром тег. Используя отношения многие-ко-многим, мы получаем из данного тега все статьи, применяем к ним скоп findByTag и передаем в шаблон byTag.blade.php
	//http://shmatovskiy.test/articles/tag/5  //href="{{ route('article.tag', $tag->id) }}" //Несмотя на то что в ГЕТ запросе мы получаем только айдишник от нашего тега, нам нет необходимости реализовывать в методе allByTag контроллера поиск данного тега по айди, - Ларавель настолько умный, что он это делает за нас. Нам лишь надо написать параметром модель и переменную. Соответственно получив айдишник, он посмотрит что это модель Tag и самостоятельно найдет нам необходимый тег по его айдишнику
	public function allByTag(Tag $tag) {
        $articles = $tag->articles()->findByTag(); //scopeFindByTag($query)
        //$articles = $tag->articles()->findByTag(10); //scopeFindByTag($query, $numbers)
        return view('app.article.byTag', compact('articles'));
    }
}