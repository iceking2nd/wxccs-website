<template>
    <div class="container">
      <div class="blog-post" v-for="article in articles" :key="article.id">
            <h2 class="blog-post-title"><router-link :to="{ name: 'blog_show_article', params: { id: article.id }}">{{ article.title }}</router-link></h2>
            <p class="blog-post-meta">{{ article.created_at }} by {{ article.author.name }}</p>

            <div style="height: 500px; overflow:hidden; overflow-x:hidden" v-html="article.content"></div>
            <hr>
            <router-link class="float-right" :to="{ name: 'blog_show_article', params: { id: article.id }}">阅读全文</router-link>
            <div class="space"></div>
      </div><!-- /.blog-post -->
        <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
        </nav>
    </div>
</template>

<script>

    export default {
        mounted() {
            axios.get('/api/blog/article').then(response => {
                this.articles = response.data.data
            })
        },
        data() {
            return {
                articles : []
            }
        }
    }
</script>
