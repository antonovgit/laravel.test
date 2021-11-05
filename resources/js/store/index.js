import Vue from 'vue'
import Vuex from 'vuex'

//Подключаем модуль article
import * as article from './modules/article.js'

//Чтобы Vue использовал библиотеку Vuex
Vue.use(Vuex)

export default new Vuex.Store({
    modules: { //Зарегистрировать новый модуль article
        article
    },
	state: {  //state - это ханилище состояний. Здесь будут храниться все данные, все переменные
		slug: '',
	},
    actions: { //actions - предназначено для выполнения асинхронных запросов к серверу. Здесь мы будем вызывать мутаторы для записи результата API запросов в 
		
	},
    getters: { //getters использется для вычисляемых свойств
		articleSlugRevers(state) {
            return state.slug.split('').reverse().join('');
        },
    },
    mutations: { //mutations - это аналог сеттеров. Здесь будем записывать переменные и новые значения
		SET_SLUG(state, payload) {
            state.slug = payload;
        }
    }
})

