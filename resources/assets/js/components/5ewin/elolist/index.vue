<style>
    th {
        cursor:pointer;
    }
</style>
<template>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th @click="sortby('id')">#</th>
                <th @click="sortby('domain_id')">域ID</th>
                <th @click="sortby('username')">ID</th>
                <th @click="sortby('avatar_url')">头像</th>
                <th @click="sortby('elo')">ELO</th>
                <th @click="sortby('steam_account')">STEAM账号</th>
                <th @click="sortby('fewin_account')">5ewin账号</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="account in sortedAccounts" :key="account.id">
                <td>{{ account.id }}</td>
                <td><a :href="'https://www.5ewin.com/data/player/' + account.domain_id" target="_blank">{{ account.domain_id }}</a></td>
                <td>{{ account.username }}</td>
                <td><img width="40px" height="40px" :src="'https://oss.5ewin.com/' + account.data.user.avatar_url"></td>
                <td>{{ account.elo }}</td>
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
                this.accounts = response.data
            })
        },
        data() {
            return {
                accounts : [],
                currentSort:'name',
                currentSortDir:'asc'
            }
        },
        methods:{
            sortby:function(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            }
        },
        computed:{
            sortedAccounts:function() {
                return this.accounts.sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                });
            }
        }
    }
</script>
