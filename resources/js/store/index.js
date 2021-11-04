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
		likeIt: true,
		commentSuccess: false,
		errors: [],
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
		//Делаем put запрос по адресу '/api/article-views-increment' и передаем в качестве параметра слаг. Метод контроллера должен получить слаг, найти нужную страницу синкрементировать счетчик просмотров и передать обратно ресурс страницы но уже с новым значением просмотров. Новые обновленные данные станицы мы присваиваем в переменную article с помощью мутатора SET_ARTICLE.
		//Тут один инципиальный момент: чтобы инкрементировать просмотры, мы заново возващаем всю статью, делаем казалось бы лишнюю работу. В противовес можно было бы оперировать статьей, лайками и просмотрами по отдельности, но тогда было бы больше запросов к серверу. Поэтому я решил выбрать первый ваиант, когда данные одной статьи, вместе со статистикой и комментариями, формируются на сервере в один единый json объект
		//setTimeout - это таймер и весь код, который находится внутри запустится через указанное время. Таким обазом лайки синкрементируются через 5 секунд, когда запустится данный экшен. Вызывать его мы будем в хуке created() в файле app.js
		viewsIncrement(context, payload){
			setTimeout(() => {
				axios.put('/api/article-views-increment', {slug:payload }).then((response) =>{
					//Когда получили ответ от сервера, мы обновляем данные на нашей странице с помощью мутатора SET_ARTICLE
					context.commit('SET_ARTICLE', response.data.data)
				}).catch(()=>{
					console.log('Ошибка')
				});
			}, 5000)
		},
		//При клике по кнопке мы вызываем экшен, он делат put запрос по адресу '/api/article-likes-increment' и передаем 2 параметра: слаг и increment. После того как метод likesIncrement контроллера ArticleController отработал, мы на выходе получаем новые данные статьи и устанавливаем с помощью мутатора SET_LIKE противоположное значение likeIt
		//Именно значение переменной likeIt регулирует логику, какой добавить класс стилей и инкрементировать или декрементировать кол-во лайков
		addLike(context, payload){
			axios.put('/api/article-likes-increment', {slug:payload.slug, increment:payload.increment }).then((response) =>{
				context.commit('SET_ARTICLE', response.data.data)
				context.commit('SET_LIKE', !context.state.likeIt)
			}).catch(()=>{
				console.log('Ошибка addLike')
			});
			console.log("После клика по кнопке", context.state.likeIt)
		},
		//Делаем ПОСТ запрос по адресу '/api/article-add-comment' передаем в качестве параметров тему, тело комментария и айди статьи. И если метод контроллера отработал успешно, выставляем переменную commentSuccess в противоположное значение с помощью мутатора SET_COMMENT_SUCCESS. Как только это произошло, форма должна исчезнуть и появится сообщение о том, что комментарий успешно отправлен
		addComment(context, payload){
			axios.post('/api/article-add-comment', { subject:payload.subject, body:payload.body, article_id:payload.article_id}).then((response) =>{
				context.commit('SET_COMMENT_SUCCESS', !context.state.commentSuccess)
				context.dispatch('getArticleData', context.state.slug) //!данная сткочка дергает экшен getArticleData в другом экшене.. соответственно в экшене addComment, и когда комментарий будет добавлен, мы перезаписываем данные артикл и соответственно они уже вернуться с вновь добавленным комментарием
			}).catch((error)=>{
				if(error.response.status === 422) {
					context.state.errors = error.response.data.errors //присваиваем данные из ошибок в массив errors
				}
			});
		}
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
            return state.article = payload;
        },
		SET_SLUG(state, payload) {
            return state.slug = payload;
        },
		SET_LIKE(state, payload) {
			return state.likeIt = payload;
		},
		SET_COMMENT_SUCCESS(state, payload){
			state.commentSuccess = payload;
		}
    }
})

