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
    export default {
        components:{
            HeaderNavbar
        }
    }
</script>
