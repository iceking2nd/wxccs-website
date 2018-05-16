<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <router-link tag="h5" to="/" class="my-0 mr-md-auto font-weight-normal">wxccs.org</router-link>
        <nav class="my-2 my-md-0 mr-md-3">
            <router-link class="p-2 text-dark" to="/blog">Blog</router-link>
            <router-link class="p-2 text-dark" to="/5ewin/elolist">5E ELOList</router-link>
        </nav>
        <router-link v-if="user.authenticated" class="btn btn-outline-primary" to="/logout">登出</router-link>
        <router-link v-if="!user.authenticated" class="btn btn-outline-primary" to="/login">登陆</router-link>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        computed:{
            ...mapState({
                user: state => state.AuthUser
            })
        }
    }
</script>
