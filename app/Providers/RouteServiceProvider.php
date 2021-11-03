<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
	//!В данном методе описан лимит обращения к сайту в минута. Здесь указано что лимит равен 60 обращениям. Сделано это для того чтобы избежать DOS атак на ваш сайт. Если кол-во обращений по какому-либо роуту превысит указанную здесь цифру, например 61, то ответом от сервера будет 429 ошибка, т.е. превышения лимита обращения к серверу   //429 | TOO MANY REQUESTS //СЛИШКОМ МНОГО ЗАПРОСОВ
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
            //return Limit::perMinute(3);
			
			//Если вы полностью доверяете вашим пользователям, то вы можете наисать здесь следующую логику:
			//return Limit::none(); //Теперь количество попыток доступа неограничено
        });
    }
}
