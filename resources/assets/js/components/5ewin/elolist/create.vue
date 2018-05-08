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
                                    <input type="text" v-model="fewin_doamin_id" class="form-control" id="fewin_doamin_id" placeholder="域ID">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="steam_account">STEAM账号</label>
                                <input type="text" v-model="steam_account" class="form-control" id="steam_account" placeholder="STEAM账号">
                            </div>
                            <div class="form-group">
                                <label for="fewin_account">5EWIN账号</label>
                                <input type="text" v-model="fewin_account" class="form-control" id="fewin_account" placeholder="5EWIN账号">
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
                fewin_account : ''
            }
        },
        methods:{
            create() {
                let formData = {
                    domain_id : this.fewin_doamin_id,
                    steam_account : this.steam_account,
                    fewin_account : this.fewin_account
                }
                axios.post('/api/5ewin/elolist/account',formData).then(response => {
                    this.$router.push({ name:'5ewin_index'})
                })
            }
        }
    }
</script>
