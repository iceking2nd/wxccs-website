import VueRouter from 'vue-router'

let routes = [
    {
        path: '/',
        component: require('./components/welcome')
    }
]

export default new VueRouter({
    mode: 'history',
    routes
});