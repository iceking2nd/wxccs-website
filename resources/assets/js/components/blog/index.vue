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
            <button :class="{'disabled' : !prevPage}" :disabled="!prevPage" class="btn btn-outline-primary" @click.prevent="goToPrev">上一页</button>
            {{ paginatonCount }}
            <button :class="{'disabled' : !nextPage}" :disabled="!nextPage" class="btn btn-outline-secondary" @click.prevent="goToNext">下一页</button>
        </nav>
    </div>
</template>

<script>
    import axios from 'axios'

    const getArticles = ( page , callback ) => {
        const params = { page };

        axios
            .get('/api/blog/article', {params})
            .then(response => {
                callback(null,response.data)
            }).catch(error => {
                callback(error,error.response.data)
        });
    };

    export default {
        data() {
            return {
                articles : [],
                meta : null,
                links : {
                    first : null,
                    last : null,
                    next : null,
                    prev : null
                },
                error : null
            }
        },
        computed: {
            nextPage() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            prevPage() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        beforeRouteEnter (to, from, next) {
            getArticles(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        // when route changes and this component is already rendered,
        // the logic will be slightly different.
        beforeRouteUpdate (to, from, next) {
            this.articles = this.links = this.meta = null
            getArticles(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods: {
            fetchData() {
                this.error = this.articles = null;
                this.loading = true;
                axios
                    .get('/api/blog/article')
                    .then(response => {
                        this.loading = false;
                        this.articles = response.data;
                    }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                });
            },
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'blog_index',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            setData(err, { data: articles, links, meta }) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.articles = articles;
                    this.links = links;
                    this.meta = meta;
                }
            },
        },
        created() {
            this.fetchData();
        }
    }
</script>
