<template>
    <form method="POST" @submit.prevent="login">

        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">电子邮件</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, email: true } }" data-vv-as="电子邮件" v-model="email" id="email" type="email" class="form-control" name="email" placeholder="E-Mail" autofocus>
                <span class="help-block help" v-show="errors.has('email')" :class="{'text-danger' : errors.has('email')}">{{ errors.first('email') }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">密码</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, min: 8 } }" data-vv-as="密码" v-model="password" id="password" type="password" class="form-control" name="password" placeholder="密码">
                <span class="help-block help" v-show="errors.has('password')" :class="{'text-danger' : errors.has('password')}">{{ errors.first('password') }}</span>
                <span class="help-block help" v-if="mismatchError" :class="{'text-danger' : bag.has('password:auth')}">{{ bag.first('password:auth') }}</span>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" :disabled="errors.any()" class="btn btn-primary">
                    登录
                </button>
            </div>
        </div>
    </form>
</template>

<script>

    import {ErrorBag} from 'vee-validate'

    export default {
        data() {
            return {
                email : '',
                password : '',
                bag : new ErrorBag()
            }
        },
        computed:{
            mismatchError(){
                return this.bag.has('password:auth') && !this.errors.has('password')
            }
        },
        watch:{
            password(){
                if (this.bag.has('password:auth'))
                {
                    this.bag.remove('password')
                }
            }
        },
        methods : {
            login() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let formData = {
                            email : this.email,
                            password : this.password
                        }
                        this.$store.dispatch('loginRequest',formData).then(response => {
                            this.$router.push({name:'profile'})
                        }).catch(error => {
                            if (error.response.status === 421)
                            {
                                this.bag.add('password','电子邮件和密码不相符','auth')
                            }
                            console.log(error.response)
                        })
                    }
                })
            }
        }
    }
</script>
