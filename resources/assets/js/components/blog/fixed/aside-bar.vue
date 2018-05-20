<template>
    <aside class="col-md-4 blog-sidebar">
        <div class="p-3">
            <router-link v-if="user.authenticated" class="btn btn-info" :to="{ name : 'blog_create_article' }">发布新文章</router-link>
        </div>
        <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">
                一个84年出生的稍微会点PHP、稍微会点系统管理、喜欢玩CSGO的网络工程师。
            </p>
        </div>

        <archives-list></archives-list>

        <div class="p-3">
            <h4 class="font-italic">Elsewhere</h4>
            <ol class="list-unstyled">
                <li><a href="https://github.com/iceking2nd">GitHub</a></li>
                <li><a href="https://twitter.com/iceking2nd">Twitter</a></li>
                <li><a href="https://www.facebook.com/iceking2nd">Facebook</a></li>
            </ol>
        </div>
    </aside><!-- /.blog-sidebar -->
</template>

<script>
    import ArchivesList from './archives-list'
    import {mapState} from 'vuex'

    export default {
        components:{
            ArchivesList
        },
        computed:{
            ...mapState({
                user : state => state.AuthUser
            })
        }
    }
</script>
