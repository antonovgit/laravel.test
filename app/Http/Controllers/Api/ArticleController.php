<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    /*//ВРЕМЕННАЯ ЗАГЛУШКА: Получим данные первой страницы с вложенными комментариями, тегами и статистикой в формете json
	//Метод  show() берет статью из БД и передает ее ресурсу ArticleResource. ArticleResource описан таким образом, что все взаимоотношения статьи с другими моделями он же хранит в себе в виде вложенных массивов.
	public function show() {
        //return 123;
		$article = Article::with('comments', 'tags', 'state')->first(); //Берем самую первую статью, ее берем вместе с комментариями, тегами и статистикой
		return new ArticleResource($article); //возвращает новый экземпляр ресурса, которому мы передаем только что полученную статью
    }*/
	
	/*//Сделаем так, чтобы выводилась правильная статья
	public function show(Request $request) {
        $slug = $request->get('slug');
		
		$article = Article::findBySlug($slug); //scopeFindBySlug($query, $slug) //Находит статью по слагу
        return new ArticleResource($article);
    }
	
	public function viewsIncrement(Request $request) {
        $slug = $request->get('slug');
		$article = Article::findBySlug($slug);
		
		$article->state->increment('views');
        return new ArticleResource($article);
    }

    public function likesIncrement(Request $request) {
        $slug = $request->get('slug');
		$article = Article::findBySlug($slug);
		
		$inc = $request->get('increment');
        $inc ? $article->state->increment('likes') : $article->state->decrement('likes'); //Если increment тру то инкрементируется счетчик лайков. Если значение инкремента false, то выполняется дикремент лайков
        return new ArticleResource($article);
    }*/
	
	protected $service;

	// В конструкторе мы значению протектед переменной service нашего контроллера присвоили новый экземпляр ArticleService. И используя конструкцию $this->service, где уже хранится экземпляр класса ArticleService, мы можем дергать все методы, которые находятся в ArticleService
	//Таким образом мы подключили сервис ArticleService и можем использовать его методы в данном контроллере
	public function __construct(ArticleService $service) {
        $this->service = $service;
    }
	
	public function show(Request $request) {
        $article = $this->service->getArticleBySlug($request);
        return new ArticleResource($article);
    }

    public function viewsIncrement(Request $request) {
        $article = $this->service->getArticleBySlug($request);

        $article->state->increment('views');
        return new ArticleResource($article);
    }

    public function likesIncrement(Request $request) {
        $article = $this->service->getArticleBySlug($request);

        $inc = $request->get('increment');
        $inc ? $article->state->increment('likes') : $article->state->decrement('likes');
        return new ArticleResource($article);
    }
}
