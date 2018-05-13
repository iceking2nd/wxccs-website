<template>
    <form method="POST" @submit.prevent="login">

        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">电子邮件</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, email: true } }" v-model="email" id="email" type="email" class="form-control" name="email" placeholder="E-Mail" required autofocus>
                <span class="help-block" v-show="errors.has('email')" :class="{'invalid-feedback' : errors.has('email')}">{{ errors.first('email') }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, min: 8 } }" v-model="password" id="password" type="password" class="form-control" name="password" placeholder="密码" required>
                <span class="help-block" v-show="errors.has('password')" :class="{'invalid-feedback' : errors.has('password')}">{{ errors.first('password') }}</span>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    登录
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                email : '',
                password : '',
            }
        },
        methods : {
            login() {
                let formData = {
                    client_id : '',
                    client_secret : '',
                    grant_type : 'password',
                    scope : '',
                    email : this.email,
                    password : this.password
                }
                axios.post('/oauth/token',formData).then(response => {

                })
            }
        }
    }
</script>
