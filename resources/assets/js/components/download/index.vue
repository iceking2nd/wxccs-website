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
                <th @click="sortby('filename')">文件名</th>
                <th>大小</th>
                <th>上传时间</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="file in sortedDownloads" :key="file.filename">
                <td><a :href="file.download_url">{{ file.filename }}</a></td>
                <td>{{ Math.round((file.meta.size/1048576)*100)/100 }} MB</td>
                <td>{{ getLocalTime(file.meta.timestamp) }}</td>
            </tr>
            </tbody>
        </table>
        <div class="row justify-content-center">
            <div class="col-4">
                <button type="button" class="btn btn-info float-left" @click="prevPage"><i class="fa fa-arrow-left" aria-hidden="true"></i> 上一页</button>
            </div>
            <div class="col-4">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">每页显示</div>
                    </div>
                    <select v-model="pageSize" class="custom-select mr-sm-2" id="perPageSelector">
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
    </div>
</template>

<script>
    let downloads_data = {}

    export default {
        mounted() {
            axios.get('/api/download').then(response => {
                this.downloads = response.data
            })
        },
        data() {
            return {
                downloads : [],
                currentSort:'name',
                currentSortDir:'asc',
                pageSize:5,
                currentPage:1
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
                if((this.currentPage*this.pageSize) < this.downloads.length) this.currentPage++;
            },
            prevPage:function() {
                if(this.currentPage > 1) this.currentPage--;
            },
            getLocalTime:function(time) {
                let ts = time;
                let t,y,m,d,h,i,s;
                t = ts ? new Date(ts*1000) : new Date();
                y = t.getFullYear();
                m = t.getMonth()+1;
                d = t.getDate();
                h = t.getHours();
                i = t.getMinutes();
                s = t.getSeconds();
                // 可根据需要在这里定义时间格式
                return y+'-'+(m<10?'0'+m:m)+'-'+(d<10?'0'+d:d)+' '+(h<10?'0'+h:h)+':'+(i<10?'0'+i:i)+':'+(s<10?'0'+s:s);
            }
        },
        computed:{
            sortedDownloads:function() {
                return this.downloads.sort((a,b) => {
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
            }
        }
    }
</script>
