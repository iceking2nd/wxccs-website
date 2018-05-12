import VueRouter from 'vue-router'

let routes = [
    {
        path: '/',
        component: require('./components/welcome')
    },
    {
        path: '/5ewin/elolist',
        name: '5ewin_index',
        component: require('./components/5ewin/elolist/index')
    },
    {
        path: '/5ewin/elolist/create',
        component: require('./components/5ewin/elolist/create')
    },
    {
        path: '/blog',
        name: 'blog_index',
        component: require('./components/blog/index')
    },
]

export default new VueRouter({
    mode: 'history',
    routes
});