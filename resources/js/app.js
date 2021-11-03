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
//Vue.component('views-component', require('./components/ViewsComponent.vue').default);
//Vue.component('likes-component', require('./components/LikesComponent.vue').default);
//Vue.component('comments-component', require('./components/CommentsComponent.vue').default);

//const app - это новый экземляр Vue, который привязан к эл с айдишником app
const app = new Vue({
    store,	//подключение данного хранилища в новый экземляр Vue
	el: '#app',
});
