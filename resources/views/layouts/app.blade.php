<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
		<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
		
    </head>
    <body>
        <div class="container">
            <!-- https://getbootstrap.com/docs/5.1/components/navbar/  -->
            <nav class="navbar navbar-expand bg-light navbar-light">
                <div class="container-fluid">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link menu-link menu-link__active} "
                               href="{{-- route('home') --}}">Главная страница</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link"
                               href="{{-- route('article.index') --}}">Каталог статей</a>
                        </li>
                    </ul>
                    <!-- https://icons.getbootstrap.com/  -->
					<!-- <a class="d-flex justify-content-end " href="https://github.com/rageserg"> -->
					<a class="d-flex justify-content-end " href="https://github.com/antonovgit/laravel.test">
                        <i class="bi bi-github" style="font-size: 2rem; color: #000000;"></i>
                    </a>
                </div>
            </nav>
			
			@yield('hero') <!-- Секция с фото это декоативный прийом. Мы ее будем показывать на первой странице, а так же в каталоге статей -->
            @yield('content')
            @yield('vue')  <!-- vue код будет подгружаться только на странице отдельной статьи. Если данный скрипт подключить на все стараницы сайта, то это будет ошибкой. Во-первых на странице будет подгружаться ненужный код. Во-вторых данный код когда не найдет эл с айдишником app, консоль браузера выдаст ошибку -->
			
        </div>
    </body>
</html>
