<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">个人资料</div>

            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        用户ID
                        <br/>
                        <h4>{{ user.uid }}</h4>
                    </li>
                    <li class="list-group-item">
                        电子邮件
                        <br/>
                        <h4>{{ user.email }}</h4>
                    </li>
                    <li class="list-group-item">
                        用户名
                        <br/>
                        <h4>{{ user.name }}</h4>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        created(){
            this.$store.dispatch('setAuthUser')
        },
        computed:{
            ...mapState({
                user: state => state.AuthUser
            })
        }
    }
</script>
