<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    /*//ВРЕМЕННАЯ ЗАГЛУШКА: Получим данные первой страницы с вложенными комментариями, тегами и статистикой в формете json
	//Метод  show() берет статью из БД и передает ее ресурсу ArticleResource. ArticleResource описан таким образом, что все взаимоотношения статьи с другими моделями он же хранит в себе в виде вложенных массивов.
	public function show() {
        //return 123;
		$article = Article::with('comments', 'tags', 'state')->first(); //Берем самую первую статью, ее берем вместе с комментариями, тегами и статистикой
		return new ArticleResource($article); //возвращает новый экземпляр ресурса, которому мы передаем только что полученную статью
    }*/
	
	//Сделаем так, чтобы выводилась правильная статья
	public function show(Request $request) {
        $slug = $request->get('slug');
		$article = Article::findBySlug($slug); //scopeFindBySlug($query, $slug) //Находит статью по слагу
        return new ArticleResource($article);
    }
}
