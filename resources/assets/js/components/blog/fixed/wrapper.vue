<template>
    <main role="main" class="container">
        <div class="row">
            <div class="col-md-8 blog-main">
                <h3 class="pb-3 mb-4 font-italic border-bottom">
                    梅尔加尼
                </h3>

                <transition name="fade" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div><!-- /.blog-main -->
            <aside-bar></aside-bar>
        </div><!-- /.row -->

    </main>
</template>

<script>
    import AsideBar from './aside-bar'

    export default {
        name : 'blog_wrapper',
        components : {
            AsideBar
        }
    }
</script>
