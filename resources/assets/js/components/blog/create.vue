<template>
    <form @submit.prevent="ArticleCreate">
        <div class="blog-post">
            <h2 class="blog-post-title">
                标题<input v-validate="'required'" data-vv-as="标题" v-model="title" id="title" name="title" type="text" placeholder="标题" autofocus>
            </h2>
            <div class="blog-post-meta" v-show="errors.has('title')">
                <span class="help-block help" v-show="errors.has('title')" :class="{'text-danger' : errors.has('title')}">{{ errors.first('title') }}</span>
            </div>
            <div>
                <u-editor v-model="content" :config="UEconfig"></u-editor>
                <hr>
            </div>
            <div>
                <button type="submit" :disabled="errors.any()" class="btn btn-primary">
                    发布文章
                </button>
            </div>
        </div><!-- /.blog-post -->
    </form>

</template>

<script>
    import UEditor from 'vue-ueditor-wrap'

    export default {
        components: {
            UEditor
        },
        mounted() {

        },
        data() {
            return {
                title: null,
                content: '',
                UEconfig: {
                    UEDITOR_HOME_URL: '/vendor/ueditor/',
                    serverUrl: '/ueditor/server',
                }
            }
        },
        methods:{
            ArticleCreate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let formData = {
                            title : this.title,
                            content : this.content
                        }
                        axios.post('/api/blog/article',formData).then(response => {
                            this.$router.push({ name: 'blog_show_article', params: { id: response.data.id }})
                        }).catch(error => {
                            console.log(error)
                        })
                    }
                })
            }
        }
    }
</script>
