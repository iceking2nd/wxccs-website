<template>
    <form @submit.prevent="updateProfile">

        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">电子邮件</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, email: true } }" data-vv-as="电子邮件" v-model="email" id="email" type="email" class="form-control" name="email" placeholder="E-Mail" autofocus>
                <span class="help-block help" v-show="errors.has('email')" :class="{'text-danger' : errors.has('email')}">{{ errors.first('email') }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">用户名</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true } }" data-vv-as="用户名" v-model="name" id="name" type="text" class="form-control" name="name" placeholder="用户名">
                <span class="help-block help" v-show="errors.has('name')" :class="{'text-danger' : errors.has('name')}">{{ errors.first('name') }}</span>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" :disabled="errors.any()" class="btn btn-primary">
                    更新用户资料
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import * as types from './../../store/mutation-type'

    export default {
        created(){
            this.$store.dispatch('setAuthUser');
        },
        computed:{
            name: {
                get() {
                    return this.$store.state.AuthUser.name;
                },
                set(value) {
                    this.$store.commit({
                        type: types.UPDATE_PROFILE_NAME,
                        value: value
                    })
                }
            },
            email: {
                get() {
                    return this.$store.state.AuthUser.email;
                },
                set(value) {
                    this.$store.commit({
                        type: types.UPDATE_PROFILE_EMAIL,
                        value: value
                    })
                }
            }
        },
        methods : {
            updateProfile() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        const formData = {
                            name: this.name,
                            email: this.email
                        }
                        this.$store.dispatch('updateProfileRequest',formData).then(response => {
                            this.$router.push({name:'profile'})
                        }).catch(error => {
                            console.log(error)
                        })
                    }
                })
            }
        }
    }
</script>
