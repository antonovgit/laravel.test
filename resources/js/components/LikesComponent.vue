<template>
    <!--<span @click="addLike()" class="badge likesButton" :class="isLike ? 'bg-primary': 'bg-danger'">{{ likesNumber }} <i class="far fa-thumbs-up"></i></span>-->
	<span @click="addLike()" class="badge likesButton" :class="isLike ? 'bg-primary': 'bg-danger'">{{ articleLikes }} <i class="far fa-thumbs-up"></i></span>
</template>

<script>

//Подключив вспомогательную ф-цию mapGetters, мы имеем возможность воспользоваться всеми геттерами, которые нам надо
import { mapGetters } from 'vuex'

export default {
    computed: {
        isLike(){
            //return this.$store.state.likeIt;
			return this.$store.state.article.likeIt; //с модулем
        },
        ...mapGetters('article', ['articleLikes']), //Чтобы нам воспользоваться всеми геттерами, которые нам надо используется такая констркция. 'article' - название модуля и название геттера 'articleLikes'
    },
    /*methods: {
        addLike(){
            this.$store.dispatch('addLike', {
                slug : this.$store.state.slug,
                increment: this.isLike
            })
        }
    },*/
	methods: {
        addLike(){
            this.$store.dispatch('article/addLike', {
                slug : this.$store.state.slug,
                increment: this.isLike
            })
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>

<style scoped>

.likesButton {
    cursor: pointer;
}

</style>
