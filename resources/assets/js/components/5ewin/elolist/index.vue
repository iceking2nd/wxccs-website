<style>
    th {
        cursor:pointer;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
<template>
    <div class="container">
        <transition name="fade">
            <div v-show="loading">
                <div class="row justify-content-center">
                    Loading...
                </div>
                <div class="row justify-content-center">
                    <div class="col-6">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" :style="{ width: progress + '%' }" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">{{progress}}%</div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </transition>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th @click="sortby('id')">#</th>
                    <th @click="sortby('domain_id')">域ID</th>
                    <th @click="sortby('username')">ID</th>
                    <th @click="sortby('avatar_url')">头像</th>
                    <th @click="sortby('elo')">ELO</th>
                    <th @click="sortby('match_total')">赛季比赛场次</th>
                    <th @click="sortby('steam_account')">STEAM账号</th>
                    <th @click="sortby('fewin_account')">5ewin账号</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="account in sortedAccounts" :key="account.id">
                    <td>{{ account.id }}</td>
                    <td><a :href="'https://www.5ewin.com/data/player/' + account.domain_id" target="_blank">{{ account.domain_id }}</a></td>
                    <td>{{ account.username }}</td>
                    <td><img width="40px" height="40px" :src="account.avatar_url"></td>
                    <td>{{ account.elo }}</td>
                    <td>{{ account.match_total }}</td>
                    <td>{{ account.steam_account }}</td>
                    <td>{{ account.fewin_account }}</td>
                </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-6">账号总数：{{ accounts.length }}</div>
                <div class="col-6">已定级账号数：{{ rankedAccounts }}</div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                    <button type="button" class="btn btn-info float-left" @click="prevPage"><i class="fa fa-arrow-left" aria-hidden="true"></i> 上一页</button>
                </div>
                <div class="col-4">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">每页显示</div>
                        </div>
                        <select v-model="pageSize" @change="currentPage = 1" class="custom-select mr-sm-2" id="perPageSelector">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-info float-right" @click="nextPage">下一页 <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>

            </div>
            <div class="row justify-content-center">
                <router-link to="./elolist/create" class="col-sm-6 btn btn-success btn-block"><i class="fa fa-plus" aria-hidden="true"></i>
                    添加新账号</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('/api/5ewin/elolist/getdomainidonly').then(response => {
                this.accounts = response.data
                this.accounts.delayedForEach(function (account) {
                    axios.get('/api/5ewin/elolist/proxy/' + account.domain_id).then(response => {
                        account.elo = response.data.elo
                        account.username = response.data.username
                        account.avatar_url = response.data.avatar_url
                        account.match_total = Number(response.data.match_total)
                        this.processedRecord++
                        if (this.processedRecord >= this.accounts.length) {
                            this.processedRecord = 0
                            this.loading = false
                        }
                    })
                },200,this)
            })
        },
        data() {
            return {
                accounts : [],
                currentSort:'name',
                currentSortDir:'asc',
                pageSize:5,
                currentPage:1,
                loading:true,
                processedRecord:0
            }
        },
        methods:{
            sortby:function(s) {
                //if s == current sort, reverse
                if(s === this.currentSort) {
                    this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
                }
                this.currentSort = s;
            },
            nextPage:function() {
                if((this.currentPage*this.pageSize) < this.accounts.length) this.currentPage++;
            },
            prevPage:function() {
                if(this.currentPage > 1) this.currentPage--;
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
                }).filter((row, index) => {
                    let start = (this.currentPage-1)*this.pageSize;
                    let end = this.currentPage*this.pageSize;
                    if(index >= start && index < end) return true;
                });
            },
            progress:function () {
                return Math.round(this.processedRecord / this.accounts.length * 100)
            },

            rankedAccounts:function () {
                let i = 0;
                this.accounts.forEach(function (item,index) {
                    if(item.match_total >= 10){
                        i++;
                    }
                })
                return i;
            }
        }
    }
</script>
