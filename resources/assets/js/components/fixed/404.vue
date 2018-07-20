<template>
    <div class="container-fluid">
        <div class="row uno_main_body">
            <div class="col-sm-12">
                <img src="https://oss.wxccs.org/website/images/errors/404.png" class="img-fluid uno_hero_img" id="anim" alt="" width="500px">


            </div>
            <div class="col-sm-12">
                <h1 class="uno_title">OPPS !!</h1>
                <p class="uno_title_sec">您要找的页面飞走了！</p>
                <a href="/">
                    <button type="button" name="button" class="btn btn-light uno_btn">点击我回到主页</button>
                </a>
            </div>

        </div><!-- row -->

    </div>
</template>

<style>
    body {
        background: #faa823;
    }
    .uno_main_body {
        text-align: center;
    }

    .uno_hero_img {
        margin-top: 4%;
    }
    .uno_title {
        font-family: 'Gloria Hallelujah', cursive;
    }
    .uno_title_sec{
        font-family: 'Neucha', cursive;
    }
    .uno_btn {
        cursor: pointer;
        font-family: 'Neucha', cursive;
    }
    @-webkit-keyframes hero_img {
        0%, 100% {
            margin-top: 15px;
        }
        50% {
            margin-top: 25px;
        }
    }
    .uno_hero_img{
        -webkit-animation: hero_img 2100ms infinite;
    }
</style>

<script>
    export default {

    }
</script>
