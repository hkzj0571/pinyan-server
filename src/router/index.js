import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name:'index',
            component: (resolve) => require(['../views/Index.vue'], resolve),
            children: []
        },
        {
            path: '/login',
            name:'login',
            component: (resolve) => require(['../views/Auth/Login.vue'], resolve)
        },
        {
            path: '/active/:token',
            name:'active',
            component: (resolve) => require(['../views/Auth/Active.vue'], resolve)
        },
        {
            path: '/article',
            name:'article.create',
            component: (resolve) => require(['../views/Articles/Create.vue'], resolve)
        },
        {
            path: '/article/:article',
            name:'article.show',
            component: (resolve) => require(['../views/Articles/Show.vue'], resolve)
        },
        {
            path: '/article/:article/edit',
            name:'article.edit',
            component: (resolve) => require(['../views/Articles/Edit.vue'], resolve)
        },
        {
            path: '/topics/:topic',
            name:'topics.index',
            component: (resolve) => require(['../views/Topics/Index.vue'], resolve),
        },
        {
            path: '/topics/:topic/edit',
            name:'topics.edit',
            component: (resolve) => require(['../views/Topics/Edit.vue'], resolve)
        },
        {
            path: '/topics',
            name:'topics.create',
            component: (resolve) => require(['../views/Topics/Create.vue'], resolve)
        },
        {
            path: '/settings',
            name:'user.settings',
            component: (resolve) => require(['../views/Users/Settings/Settings.vue'], resolve)
        },
        {
            path: '/user/:user',
            name:'user.show',
            component: (resolve) => require(['../views/Users/Show/Basic.vue'], resolve),
            children:[
                {
                    path: 'profile',
                    name:'user.show.profile',
                    component: (resolve) => require(['../views/Users/Show/Profile.vue'], resolve)
                },
                {
                    path: 'focus',
                    name:'user.show.focus',
                    component: (resolve) => require(['../views/Users/Show/Focus.vue'], resolve)
                },
                {
                    path: 'follow',
                    name:'user.show.follow',
                    component: (resolve) => require(['../views/Users/Show/Follow.vue'], resolve)
                },
            ]
        },
    ]
})
