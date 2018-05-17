<template>
    <form method="POST">

        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label text-md-right">密码</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true, min : 8 } }" data-vv-as="密码" v-model="password" id="password" type="password" class="form-control" name="password" placeholder="密码" autofocus>
                <span class="help-block help" v-show="errors.has('password')" :class="{'text-danger' : errors.has('password')}">{{ errors.first('password') }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password_confirm" class="col-md-4 col-form-label text-md-right">确认密码</label>

            <div class="col-md-6">
                <input v-validate="{ rules : { required : true , min : 8 ,  confirmed : 'password' } }" data-vv-as="确认密码" id="password_confirm" type="password" class="form-control" name="password_confirm" placeholder="确认密码">
                <span class="help-block help" v-show="errors.has('password_confirm')" :class="{'text-danger' : errors.has('password_confirm')}">{{ errors.first('password_confirm') }}</span>
            </div>
        </div>


        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" :disabled="errors.any()" class="btn btn-primary">
                    修改密码
                </button>
            </div>
        </div>
    </form>
</template>

<script>

    export default {
        data() {
            return {
                password : ''
            }
        },
        methods : {

        }
    }
</script>
