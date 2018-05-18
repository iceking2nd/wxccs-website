<template>
                <div class="blog-post">
                    <h2 class="blog-post-title">{{ article.title }}</h2>
                    <p class="blog-post-meta">{{ article.created_at }} by {{ article.author.name }}</p>

                    <div v-html="article.content"></div>
                    <hr>
                    <router-link v-show="user.uid === article.author.id" :to="{ name: 'blog_edit_article', params: { id: article.id }}" class="btn btn-primary btn-lg btn-block" tag="button">编辑文章</router-link>
                </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        created(){
            this.$store.dispatch('setAuthUser')
        },
        computed:{
            ...mapState({
                user: state => state.AuthUser
            })
        },
        mounted() {
            axios.get('/api/blog/article/' + this.$route.params.id).then(response => {
                this.article = response.data
            })
        },
        data() {
            return {
                article : {
                    id: null,
                    author : {},
                    created_at : null,
                    title:null,
                    content:null
                }
            }
        }
    }
</script>
