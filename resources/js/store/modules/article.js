//Неймсейс тру - это значит, что мы создаем модулю собственное пространство имен, чтобы изолировать его от других модулей. Основано оно на пути по которому зарегистрированы модули, т.е. в нашем случае пространство имен для данного модуля будет article. Именно так и называется наш файл
//Если мы создадим в папке modules какую то директорию, допустим app и в нее полижим файл article.js, соответственно пространстро имен у нас будет app/article
export const namespaced = true

//state - это ханилище состояний. Здесь будут храниться все данные, все переменные
export const state = {
    article: {
        comments:[],
        tags: [],
        statistic:{
            likes: 0,
            views: 0
        }
    },
    likeIt: true,
    commentSuccess: false,
    errors: []
}

//actions - предназначено для выполнения асинхронных запросов к серверу. Здесь мы будем вызывать мутаторы для записи результата API запросов в переменные состояния
export const actions = {
    // context = {state, commit}
    getArticleData(context, payload) {
        console.log("context", context)
        console.log("payload", payload) //payload tempora-asperiores-rerum-necessitatibus-sunt
        axios.get('/api/article-json', { params: {slug:payload } }).then((response) =>{
            context.commit('SET_ARTICLE', response.data.data)
        }).catch(()=>{
            console.log('Ошибка')
        });
    },
    viewsIncrement(context, payload){
        console.log("rootState.slug", context.rootState.slug) //название переменной
        console.log("rootGetters.articleSlugRevers", context.rootGetters.articleSlugRevers) //название гетера
        setTimeout(() => {
            axios.put('/api/article-views-increment',  {slug:payload }).then((response) =>{
                context.commit('SET_ARTICLE', response.data.data)
            }).catch(()=>{
                console.log('Ошибка')
            });
        }, 5000)
    },
    addLike(context, payload){
        axios.put('/api/article-likes-increment', {slug:payload.slug, increment:payload.increment }).then((response) =>{
            context.commit('SET_ARTICLE', response.data.data)
            context.commit('SET_LIKE', !state.likeIt)
        }).catch(()=>{
            console.log('Ошибка addLike')
        });
        console.log("После клика по кнопке", state.likeIt)
    },
    addComment(context, payload){
        axios.post('/api/article-add-comment', { subject:payload.subject, body:payload.body, article_id:payload.article_id}).then((response) =>{
            //context.commit('SET_COMMENT_SUCCESS', !context.state.commentSuccess) //так было в index.js
			context.commit('SET_COMMENT_SUCCESS', !state.commentSuccess)
            context.dispatch('getArticleData', context.rootState.slug) //rootState это объект из index.js..слаг теперь у нас живет в rootState
        }).catch((error)=>{
            if(error.response.status === 422) {
                context.state.errors = error.response.data.errors
            }
        });
    }

}

//getters использется для вычисляемых свойств
export const getters = {
    articleLikes(state) {
        return state.article.statistic.likes;
    },
    articleViews(state) {
        return state.article.statistic.views;
    }
}

//mutations - это аналог сеттеров. Здесь будем записывать переменные и новые значения
export const mutations = {
    SET_ARTICLE(state, payload) {
        state.article = payload;
    },
    SET_LIKE(state, payload) {
        state.likeIt = payload;
    },
    SET_COMMENT_SUCCESS(state, payload){
        state.commentSuccess = payload;
    }
}
