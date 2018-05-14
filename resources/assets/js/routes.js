import VueRouter from 'vue-router'

let routes = [
    {
        path: '/',
        component: require('./components/welcome')
    },
    {
        path: '/login',
        component: require('./components/users/login')
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
    {
        path: '/blog/article/:id',
        name: 'blog_show_article',
        component: require('./components/blog/show')
    }
]

export default new VueRouter({
    mode: 'history',
    routes
});