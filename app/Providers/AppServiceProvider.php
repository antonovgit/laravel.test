<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
	//Laravel содержит шаблоны постраничной навигации, созданные с использованием Bootstrap CSS. Чтобы использовать эти шаблоны вместо шаблонов Tailwind по умолчанию, вы можете вызвать метод пагинатора useBootstrap в методе boot класса App\Providers\AppServiceProvider:
    public function boot()
    {
        Paginator::useBootstrap();
		$this->activeLinks(); //регистрирую ф-цию activeLinks()
    }
	
	//Как это работает: Для представление layouts\app.blade.php мы добавляем две переменные. В переменную mainLink записывается класс 'menu-link__active', при выполнении данного условия. В переменную articleLink записывается класс 'menu-link__active' при выполнении условия
	//Соответственно при добавлении новых пунктов меню в данном файле будем добавлять новые строчки и прописывать в них похожую логику
	public function  activeLinks() {
        View::composer('layouts.app', function($view) {
           $view->with('mainLink', request()->is('/') ? 'menu-link__active' : '');
           $view->with('articleLink', (request()->is('articles') or  request()->is('articles/*')) ? 'menu-link__active' : '');
        });
    }
}
