<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <router-link tag="h5" to="/" class="my-0 mr-md-auto font-weight-normal">wxccs.org</router-link>
        <nav class="my-2 my-md-0 mr-md-3">
            <router-link class="p-2 text-dark" to="/blog">Blog</router-link>
            <router-link class="p-2 text-dark" to="/5ewin/elolist">5E ELOList</router-link>
            <router-link class="p-2 text-dark" to="/download">Downloads</router-link>
        </nav>
        <router-link v-if="user.authenticated" class="btn btn-outline-primary" to="/profile">个人中心</router-link>
        <li @click="logout" v-if="user.authenticated" class="btn btn-outline-primary"><a>登出</a></li>
        <router-link v-if="!user.authenticated" class="btn btn-outline-primary" to="/login">登录</router-link>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        computed:{
            ...mapState({
                user: state => state.AuthUser
            })
        },
        methods:{
            logout(){
                this.$store.dispatch('logoutRequest').then(response => {
                    this.$router.push({name:'blog_index'})
                })
            }
        }
    }
</script>
