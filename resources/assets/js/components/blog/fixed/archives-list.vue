<template>
    <div class="p-3">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
            <li v-for="item in lists"><router-link :to="{name:'blog_index',query:{year:item.year,month:item.month}}" tag="a">{{ item.friendly }}</router-link></li>
        </ol>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lists : []
            }
        },
        mounted() {
            axios.get('/api/blog/article/archiveslist').then(response => {
                this.lists = response.data
            })
        }
    }
</script>
