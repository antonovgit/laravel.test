<template>
    <span class="badge bg-danger">{{viewsNumber}} <i class="far fa-eye"></i></span>
</template>

<script>
export default {
    computed: {
        viewsNumber() {
            //return this.$store.getters.articleViews;
			return this.$store.getters['article/articleViews']; //с модулем //так можно добаться до геттера конкретного компонента не используя мепгетес
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style scoped>



</style>
