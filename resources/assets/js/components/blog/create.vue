<template>
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    梅尔加尼
                </h3>

                <form method="POST">
                    <div class="blog-post">
                        <h2 class="blog-post-title">
                            <input type="text">
                        </h2>
                        <div>
                            <textarea></textarea>
                        </div>
                    </div><!-- /.blog-post -->
                </form>

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

        },
        data() {
            return {
                article : {}
            }
        },
        methods:{
            ArticleCreate() {

            }
        }
    }
</script>
