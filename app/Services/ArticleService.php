<?php

namespace App\Services;
use App\Models\Article;

class ArticleService
{
    //Из реквеста забирает слаг, находит в БД необходимую статью по слагу и возвращает ее
	public function getArticleBySlug($request)
    {
        $slug = $request->get('slug');
        return Article::findBySlug($slug);
    }
}
