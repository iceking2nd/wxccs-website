<template>
    <form @submit.prevent="ArticleUpdate">
        <div class="blog-post">
            <h2 class="blog-post-title">
                标题<input v-validate="'required'" data-vv-as="标题" v-model="article.title" id="title" name="title" type="text" placeholder="标题" autofocus>
            </h2>
            <div class="blog-post-meta" v-show="errors.has('title')">
                <span class="help-block help" v-show="errors.has('title')" :class="{'text-danger' : errors.has('title')}">{{ errors.first('title') }}</span>
            </div>
            <div>
                <u-editor v-model="article.content" :config="UEconfig"></u-editor>
                <hr>
            </div>
            <div>
                <button type="submit" :disabled="errors.any()" class="btn btn-primary">
                    发布修改
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
            axios.get('/api/blog/article/' + this.$route.params.id).then(response => {
                this.article = response.data
            })
        },
        data() {
            return {
                article:{
                    id: null,
                    title: null,
                    content: '',
                },
                UEconfig: {
                    UEDITOR_HOME_URL: '/vendor/ueditor/',
                    serverUrl: '/ueditor/server',
                }
            }
        },
        methods:{
            ArticleUpdate() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let formData = {
                            title : this.title,
                            content : this.content
                        }
                        axios.patch('/api/blog/article/' + this.$route.params.id,formData).then(response => {
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
