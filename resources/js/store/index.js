import Vue from 'vue'
import Vuex from 'vuex'

//Чтобы Vue использовал библиотеку Vuex
Vue.use(Vuex)

export default new Vuex.Store({
    state: {  //state - это ханилище состояний. Здесь будут храниться все данные, все переменные
        //article: {},
		//Другой подход, чтобы избежать ошибок в консоли - это заранее четко прописать структуру объекта state. Можем избавиться в геттеах от if условий
        article: {
			comments: [],
			tags: [],
			statistic: {
				likes: 0,
				views: 0,
			}
		},
		slug: '',
    },
    actions: { //actions - предназначено для выполнения асинхронных запросов к серверу. Здесь мы будем вызывать мутаторы для записи результата API запросов в переменные состояния
		/*getArticleData(context, payload) { //вызывать экшен getArticleData мы будем в app.js
			axios.get('/api/article-json').then((response) =>{
				context.commit('SET_ARTICLE', response.data.data)
			}).catch(()=>{  //если в процесе обращения к серверу происходит какая-либо ошибка,данная ошибка перехватывается и в консоль выводится слово 'Error'
				console.log('Error')
			});
		},*/
		getArticleData(context, payload) { //вызывать экшен getArticleData мы будем в app.js
			console.log("context", context)
			console.log("payload", payload)
			axios.get('/api/article-json', { params: {slug:payload } }).then((response) =>{
				context.commit('SET_ARTICLE', response.data.data)
			}).catch(()=>{  //если в процесе обращения к серверу происходит какая-либо ошибка,данная ошибка перехватывается и в консоль выводится слово 'Error'
				console.log('Error')
			});
		},
    },
    getters: { //getters использется для вычисляемых свойств
		/*articleViews(state) {
			if(state.article.statistic) {
				return state.article.statistic.views;
			}
		},
		articleLikes(state) {
			if(state.article.statistic) {
				return state.article.statistic.likes;
			}
		},*/
		articleViews(state) {
			return state.article.statistic.views;
		},
		articleLikes(state) {
			return state.article.statistic.likes;
		},
    },
    mutations: { //mutations - это аналог сеттеров. Здесь будем записывать переменные и новые значения
		SET_ARTICLE(state, payload) {
            state.article = payload;
        },
		SET_SLUG(state, payload) {
            state.slug = payload;
        }
    }
})

