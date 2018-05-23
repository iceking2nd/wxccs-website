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
        path: '/blog',
        component: require('./components/blog/fixed/wrapper'),
        children: [
            {
                path: '/',
                name: 'blog_index',
                component: require('./components/blog/index'),
                meta: {}
            },
            {
                path: '/article/create',
                name: 'blog_create_article',
                component: require('./components/blog/create'),
                meta: {requiresAuth: true}
            },
            {
                path: '/article/:id/edit',
                name: 'blog_edit_article',
                component: require('./components/blog/edit'),
                meta: {requiresAuth: true}
            },
            {
                path: '/article/:id',
                name: 'blog_show_article',
                component: require('./components/blog/show'),
                meta: {}
            }
        ],
        meta: {}
    },
    {
        path: '/download',
        name: 'download_index',
        component: require('./components/download/index'),
        meta: {}
    },
    {
        path: '/profile',
        component: require('./components/users/ProfileWrapper'),
        children: [
            {
                path: '',
                name: 'profile',
                component: require('./components/users/ProfileShow'),
                meta: {requiresAuth: true}
            },
            {
                path: '/edit',
                name: 'profile.editProfile',
                component: require('./components/users/ProfileEdit'),
                meta: {requiresAuth: true}
            },
            {
                path: '/password',
                name: 'profile.changePassword',
                component: require('./components/users/ChangePassword'),
                meta: {requiresAuth: true}
            },
        ],
        meta: {requiresAuth: true}
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