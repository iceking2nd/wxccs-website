import VueRouter from 'vue-router'

let routes = [
    {
        path: '/',
        component: require('./components/welcome')
    },
    {
        path: '/5ewin/elolist',
        component: require('./components/5ewin/elolist/index')
    },
    {
        path: '/5ewin/elolist/create',
        component: require('./components/5ewin/elolist/create')
    },
]

export default new VueRouter({
    mode: 'history',
    routes
});