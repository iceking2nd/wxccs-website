<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>域ID</th>
                <th>ID</th>
                <th>头像</th>
                <th>ELO</th>
                <th>STEAM账号</th>
                <th>5ewin账号</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="account in accounts" :key="account.id">
                <td>{{ account.id }}</td>
                <td><a :href="'https://www.5ewin.com/data/player/' + account.domain_id" target="_blank"></a>{{ account.domain_id }}</td>
                <td>{{ account.fewin_data.data.user.username }}</td>
                <td><img width="40px" height="40px" :src="'https://oss.5ewin.com/' + account.fewin_data.data.user.avatar_url"></td>
                <td>{{ account.fewin_data.data.data.elo }}</td>
                <td>{{ account.steam_account }}</td>
                <td>{{ account.fewin_account }}</td>
            </tr>
            </tbody>
        </table>
        <div class="row justify-content-center">
            <router-link to="./elolist/create" class="col-sm-6 btn btn-success btn-block">添加新账号</router-link>
        </div>
    </div>
</template>

<script>
    let accounts_data = {}

    export default {
        mounted() {
            axios.get('/api/5ewin/elolist/getallaccounts').then(response => {
                let accounts_data = response.data
                accounts_data.forEach(function (element,index){
                    console.log(element.domain_id)
                    axios('https://app.5ewin.com/api/data/player/' + element.domain_id,{
                        method: 'GET',
                        mode: 'no-cors',
                        headers: {
                            "Access-Control-Allow-Origin": "*",
                            'Content-Type': 'application/json',
                        }
                }).then(response => {
                        accounts[index].push(element)
                        accounts[index].fewin_data = response.data
                    })
                })
            })
        },
        data() {
            return {
                accounts : []
            }
        }
    }
</script>
