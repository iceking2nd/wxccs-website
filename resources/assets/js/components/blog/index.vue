<template>
    <div class="container">
      <div class="blog-post" v-for="article in articles.data" :key="article.id">
            <h2 class="blog-post-title"><router-link :to="{ name: 'blog_show_article', params: { id: article.id }}">{{ article.title }}</router-link></h2>
            <p class="blog-post-meta">{{ article.created_at }} by {{ article.author.name }}</p>

            <div style="height: 500px; overflow:hidden; overflow-x:hidden" v-html="article.content"></div>
            <hr>
            <router-link class="float-right" :to="{ name: 'blog_show_article', params: { id: article.id }}">阅读全文</router-link>
            <div class="space"></div>
      </div><!-- /.blog-post -->
        <nav class="blog-pagination">
            <pagination :data="articles" @pagination-change-page="getResults"></pagination>
        </nav>
    </div>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'

    export default {
        components:{
            Pagination
        },
        data() {
            return {
                articles : [],
                year : this.$route.query.year,
                month : this.$route.query.month,
            }
        },
        mounted() {
            // Fetch initial results
            this.getResults();
        },
        methods: {
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                if (this.year != null && this.month != null)
                {
                    axios.get('/api/blog/article?page=' + page + '&year=' + this.year + '&month=' + this.month)
                        .then(response => {
                            this.articles = response.data   ;
                        });
                }
                else
                {
                    axios.get('/api/blog/article?page=' + page)
                        .then(response => {
                            this.articles = response.data   ;
                        });
                }
          }
        },
        watch: {
            $route(to,from){
                console.log(to.query.year)
                this.year = to.query.year
                this.month = to.query.month
                this.getResults()
            }
        }

    }
</script>
