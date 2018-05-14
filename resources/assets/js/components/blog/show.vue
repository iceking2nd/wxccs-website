<template>
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    梅尔加尼
                </h3>

                <div class="blog-post">
                    <h2 class="blog-post-title">{{ article.title }}</h2>
                    <p class="blog-post-meta">{{ article.created_at }} by {{ article.author.name }}</p>

                    <div v-html="article.content"></div>
                </div><!-- /.blog-post -->

<!--
                <nav class="blog-pagination">
                    <a class="btn btn-outline-primary" href="#">Older</a>
                    <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
                </nav>
-->

            </div><!-- /.blog-main -->
            <aside-bar></aside-bar>
        </div><!-- /.row -->

    </main>
</template>

<script>
    import AsideBar from './fixed/aside-bar'

    export default {
        components: {
            AsideBar
        },
        mounted() {
            axios.get('/api/blog/article/' + this.$route.params.id).then(response => {
                this.article = response.data
            })
        },
        data() {
            return {
                article : {}
            }
        }
    }
</script>
