<template>
<div class="row mt-5">
<div class="col-12 p-3">
    <img :src="article.img" class="border rounded mx-auto d-block" alt="...">
    <h5 class="mt-5">{{article.title}}</h5>
    <p>
        <span class="tag" v-for="(tag,index) in article.tags">
            <span v-if="tagsLen == (index+1)">{{tag.label}}</span>
            <span v-else>{{tag.label}} | </span>
        </span>
    </p>
    <p class="card-text">{{article.body}}</p>
    <p>Опубликованно:  <i>{{article.created_at}}</i></p>
    <div class="mt-3">
		<!--<span class="badge bg-danger">{{$article.statistic.views}} <i class="far fa-eye"></i></span>
        <span class="badge bg-primary">{{$article.statistic.likes}} <i class="far fa-thumbs-up"></i></span>-->
        <!--<span class="badge bg-danger" v-if="article.statistic">{{$article.statistic.views}} <i class="far fa-eye"></i></span>
        <span class="badge bg-primary" v-if="article.statistic">{{$article.statistic.likes}} <i class="far fa-thumbs-up"></i></span>-->
        <!--<span class="badge bg-danger">{{view}} <i class="far fa-eye"></i></span>
        <span class="badge bg-primary">{{likes}} <i class="far fa-thumbs-up"></i></span>-->
		
		<views-component></views-component>
		<likes-component></likes-component>
		
    </div>
</div>
</div>
</template>

<script>

//Подключив вспомогательную ф-цию mapState, мы имеем доступ к простанству имен article
import { mapState }  from 'vuex'

export default {
    computed: mapState({
        // article: 'article',  //Есть более короткий вариант, написать так, то тогда придется использовать префикс .article в нашей разметке:  {{article.article.created_at}}. НО стрелочная ф-ция я считаю более короткий вариант
        article: state => state.article.article, //стрелочная ф-ция
        tagsLen: state => state.article.article.tags.length, //стрелочная ф-ция
    }),
	/*computed:{
        article(){
			//return this.$store.state.article;
			return this.$state.article.article;
		},
        tagsLen(){
			//return this.$store.state.article.tags.lenght;
			return this.$state.article.article.tags.length;
		},
    },*/
    mounted() {
        console.log('Component article mounted.')
    }
}
</script>

<style scoped>


</style>
