<template>
    <div>
        <header-navbar></header-navbar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import HeaderNavbar from './fixed/header-navbar'
    import jwtToken from './../helpers/jwt'

    export default {
        created(){
            if(jwtToken.getToken()){
                this.$store.dispatch('setAuthUser')
            }
        },
        components:{
            HeaderNavbar
        }
    }
</script>
