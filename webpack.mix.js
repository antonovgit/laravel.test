const mix = require('laravel-mix'); //подключается библиотека laravel-mix

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');*/

//!Здесь уже описана вся необходимая логика. Т.е. берется файл app.js, к нему применяется ф-ция vue() и результирующий файл на чистом js будет скопирован в папку public/js.
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css') //файл app.scss берется из данной папки, компилируется и копируется в папку public/css
	.version(); //после добавления сюда в файл webpack.mix.js версионирования version(), если мы запустим работу скрипта сборщика (npm run dev), в папке public появится файл mix-manifest.json. В нем будут указаны уникальные идентификаторы для каждого файла стилей и скритов. Каждый раз, при сборке Вебпаком, данные файловые иденификаторы будут меняться, что не даст браузеру использовать файлы стилей и скриптов из кэша
	//Елисеев: вершен (version() ), чтобы он добавлял хеши к этим вещам: app.css?id=33b5f339521e47175532

mix.copy('resources/img', 'public/img'); //копируем файл img в папку public/img