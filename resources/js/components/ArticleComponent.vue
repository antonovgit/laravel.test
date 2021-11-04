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
export default {
    computed:{
        article(){
			return this.$store.state.article;
		},
        tagsLen(){
			return this.$store.state.article.tags.lenght;
		},
		/*//Когда подключаем компонент <views-component></views-component> на страницу, то соответственно нет необходимости использовать computed свойство view()
		view(){
			return this.$store.getters.articleViews;
		},*/
		/*//Когда подключаем компонент <likes-component></likes-component> на страницу, то соответственно нет необходимости использовать computed свойство likes
		likes(){
			return this.$store.getters.articleLikes;
		},*/
    },
    mounted() {
        console.log('Component article mounted.')
    }
}
</script>

<style scoped>


</style>
