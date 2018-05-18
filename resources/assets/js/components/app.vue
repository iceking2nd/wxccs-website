<template>
    <div>
        <header-navbar></header-navbar>
        <notification></notification>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import HeaderNavbar from './fixed/header-navbar'
    import jwtToken from './../helpers/jwt'
    import Cookie from 'js-cookie'
    import Notification from './fixed/notification'

    export default {
        created(){
            if(jwtToken.getToken()){
                this.$store.dispatch('setAuthUser')
            }
            else if(Cookie.get('auth_id'))
            {
                this.dispatch('refreshToken')
            }
        },
        components:{
            HeaderNavbar,
            Notification
        }
    }
</script>
