//Подключается файл bootstrap
//require('./bootstrap');

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


//Инициализиется новый экземпля Vue
window.Vue = require('vue').default;

//Импортировать store из файла index.js находящийся в папке store. Если файл называется index.js, то вам его прописывать не обязательно, можно ограничиться только директорией
import store from './store'

//Добавляется(регистрирется) комонент. Первый параметр 'article-component' - это имя компонента, второй - путь к файлу данного компонента
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('article-component', require('./components/ArticleComponent.vue').default);
Vue.component('views-component', require('./components/ViewsComponent.vue').default);
Vue.component('likes-component', require('./components/LikesComponent.vue').default);


//Как будет работать данный код? Создается новый экземляр Vue, в хуке created вызывается экшен getArticleData. Данный экшен с помощью библиотеки axios делает гет запрос по адресу '/api/article-json'. В файле api.php указано, что при обращении по данному адесу, должен волнятся метод show() в ArticleController. Метод  show() берет статью из БД и передает ее ресурсу ArticleResource. ArticleResource описан таким образом, что все взаимоотношения статьи с другими моделями он же хранит в себе в виде вложенных массивов. И соответственно в качестве ответа response от сервера мы получаем готовый объект со всеми необходимыми данными. Если ответ от сервера получен и это не ошибка, то вызывается мутатор SET_ARTICLE и данные от сервера передаются в переменную state.article и это теперь уже не пустой объект, а объект полный данных. Происходит эта работа за долисекунды и заметить ее невозможно. У пользователя складывается ощущение, что страница загрузилась и данные уже на ней, хотя на какую то долю секунды данных не было вовсе. Vue JS это реактивный фреймворк, а значит это то, что если вы выводите на сайте переменню и в процессе работа сайта данные в переменной поменялись, то на сайте так же будет выведено новое значение без перезагрузки страницы. Именно этот факт и позволил нам при загрзке страницы с помощью Ajax запроса заполнить пустой объект данными и отобразить их на странице
//const app - это новый экземляр Vue, который привязан к эл с айдишником app
const app = new Vue({
    store,	//подключение данного хранилища в новый экземляр Vue
	el: '#app',
	created() { //хук created ..сразу после создания нового экземляра Vue будет заскаться экшен getArticleData
        //this.$store.dispatch('getArticleData') //dispatch используется для вызова экшенов
		
		let url = window.location.pathname
        let slug = url.substring(url.lastIndexOf('/')+1) //находим индекс последнего символа слеш / и отрезаем все что до него. Таким образом получаем слаг

        console.log(url)	//articles/enim-saepe-quidem-et-harum-hic-enim-animi
        console.log(slug)	//enim-saepe-quidem-et-harum-hic-enim-animi
		//this.$store.dispatch('getArticleData')
		this.$store.commit('SET_SLUG', slug )
		this.$store.dispatch('getArticleData', slug)
		this.$store.dispatch('viewsIncrement', slug)
    }
});
