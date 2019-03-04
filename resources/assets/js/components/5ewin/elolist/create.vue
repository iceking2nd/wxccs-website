<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">新建账号</div>

                    <div class="card-body">
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <label class="sr-only" for="fewin_doamin_id">域ID</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">http://www.5ewin.com/data/player/</div>
                                    </div>
                                    <input type="text" v-validate="'required'" data-vv-as="域ID"  v-model="fewin_doamin_id" class="form-control" id="fewin_doamin_id" name="fewin_doamin_id" placeholder="域ID">
                                </div>
                                <div v-show="errors.has('fewin_doamin_id')">
                                    <span class="help-block help" v-show="errors.has('fewin_doamin_id')" :class="{'text-danger' : errors.has('fewin_doamin_id')}">{{ errors.first('fewin_doamin_id') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="steam_account">STEAM账号</label>
                                <input type="text" v-validate="'required'" data-vv-as="STEAM账号" v-model="steam_account" class="form-control" id="steam_account" name="steam_account" placeholder="STEAM账号">
                                <div v-show="errors.has('steam_account')">
                                    <span class="help-block help" v-show="errors.has('steam_account')" :class="{'text-danger' : errors.has('steam_account')}">{{ errors.first('steam_account') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fewin_account">5EWIN账号</label>
                                <input type="text" v-validate="'required'" data-vv-as="5EWIN账号" v-model="fewin_account" class="form-control" id="fewin_account" name="fewin_account" placeholder="5EWIN账号">
                                <div v-show="errors.has('fewin_account')">
                                    <span class="help-block help" v-show="errors.has('fewin_account')" :class="{'text-danger' : errors.has('fewin_account')}">{{ errors.first('fewin_account') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fewin_account">OTPAUTH URL</label>
                                <input type="text" v-model="otpauth_uri" class="form-control" id="otpauth_uri" placeholder="OTPAUTH URL">
                            </div>
                            <button type="submit" class="btn btn-primary">确认提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fewin_doamin_id : '',
                steam_account : '',
                fewin_account : '',
                otpauth_uri : '',
            }
        },
        methods:{
            create() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let formData = {
                            domain_id : this.fewin_doamin_id,
                            steam_account : this.steam_account,
                            fewin_account : this.fewin_account,
                            otpauth_uri : this.otpauth_uri,
                        }
                        axios.post('/api/5ewin/elolist/account',formData).then(response => {
                            this.$router.push({ name:'5ewin_index'})
                        })
                    }
                })
            }
        }
    }
</script>
