<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">修改密码</div>

            <div class="card-body">
                <change-password-form></change-password-form>
            </div>
        </div>
    </div>
</template>

<script>
    import ChangePasswordForm from './ChangePasswordForm'

    export default {
        name: 'password-change',
        components:{
            ChangePasswordForm
        }
    }
</script>
