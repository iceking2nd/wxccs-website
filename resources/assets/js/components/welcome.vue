<style lang="scss">
    .body {
        font-size: 14px;
    }
    .fullscreen-bg {
        position: fixed;
        background-color: #000000;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        z-index: -100;
    }

    html, body, .warp::after {
        color: #eeeeee;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .warp {
        background-color: rgba(255,255,255,0.7);
        margin: 30px auto;
        width: 1200px;
        text-align: center;
        border-radius: 60px;
        position: relative;
        overflow: hidden;
        /*box-shadow: 0 0 12px 3px rgba(0,0,0,0.18);*/
    }

    .warp h1 {
        font-size: 84px;
        color:#666666;
        text-shadow:0 0 10px rgba(255,255,255,0.2);
    }

    .warp h4 {
        text-align: center;
        font-size: 12px;
        font-family: "PingFang SC Regular","Microsoft Yahei";
    }

    .warp a {
        color: #666666;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .wrap::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 60px;
        z-index: -1;
        filter: blur(20px);
        margin: -30px
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }
</style>
<template>
    <div class="flex-center position-ref full-height">
        <div class="fullscreen-bg">
            <video ref="bgv" id="backgorund_video" volume="0.1" autoplay width="100%"></video>
        </div>

        <div class="warp">
            <h1>wxccs.org</h1>
            <a href="https://blog.wxccs.org">BLOG</a>
            <a href="https://github.com/iceking2nd/ielmatch-amxx">ielMatch</a>
            <a href="/5ewin/elolist">ELOList</a>
            <h4><a href="http://www.miibeian.gov.cn">京ICP备14013733号</a></h4>
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
                this.$refs.bgv.play()
            })
        }
    }
</script>
