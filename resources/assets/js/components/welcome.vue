<style>
    @import './../../sass/welcome.scss';
</style>
<template>
    <div class="flex-center position-ref full-height">
        <div class="fullscreen-bg">
            <video ref="bgv" id="backgorund_video" volume="0.1" controls muted autoplay width="100%"></video>
        </div>

        <div class="warp">
            <h1>wxccs.org</h1>
            <router-link to="/blog" tag="a">BLOG</router-link>
            <a href="https://github.com/iceking2nd/ielmatch-amxx">ielMatch</a>
            <router-link to="./5ewin/elolist">ELOList</router-link>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            axios.get('/api/system/backgroundvideo/randomone').then(response => {
                this.$refs.bgv.src = response.data[0].url
                this.$refs.bgv.type = response.data[0].mime
                this.$refs.bgv.volume = 0.1
                this.$refs.bgv.controls = true
                this.$refs.bgv.play()
            })
        }
    }
</script>
