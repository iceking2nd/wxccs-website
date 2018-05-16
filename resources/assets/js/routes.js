import VueRouter from 'vue-router'
import Store from './store/index'
import jwtToken from './helpers/jwt'

let routes = [
    {
        path: '/',
        component: require('./components/welcome'),
        meta: {}
    },
    {
        path: '/login',
        name: 'login',
        component: require('./components/users/login'),
        meta: {requiresGuest: true}
    },
    {
        path: '/5ewin/elolist',
        name: '5ewin_index',
        component: require('./components/5ewin/elolist/index'),
        meta: {}
    },
    {
        path: '/5ewin/elolist/create',
        component: require('./components/5ewin/elolist/create'),
        meta: {}
    },
    {
        path: '/blog',
        name: 'blog_index',
        component: require('./components/blog/index'),
        meta: {}
    },
    {
        path: '/blog/article/create',
        name: 'blog_create_article',
        component: require('./components/blog/create'),
        meta: {requiresAuth: true}
    },
    {
        path: '/blog/article/:id',
        name: 'blog_show_article',
        component: require('./components/blog/show'),
        meta: {}
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to,from,next) => {
    if (to.meta.requiresAuth)
    {
        if(Store.state.AuthUser.authenticated || jwtToken.getToken())
        {
            return next()
        }
        else
        {
            return next({name:'login'})
        }
    }
    if (to.meta.requiresGuest)
    {
        if (Store.state.AuthUser.authenticated || jwtToken.getToken())
        {
            return next({name:'blog_index'})
        }
        else
        {
            return next()
        }
    }

    return next()
})

export default router