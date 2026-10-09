import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/pages/Home.vue'
import Discover from '../components/pages/Discover.vue'
import Destination from '../components/pages/Destination.vue'
import AddDestination from '../components/pages/AddDestination.vue'
import Login from '../components/pages/Login.vue'
import Register from '../components/pages/Register.vue'
import Profile from '../components/pages/Profile.vue'

const routes = [
    // Publiski pieejamas lapas
    {
        path: '/',
        component: Home,
        meta: { access: 'public' }
    },
    {
        path: '/discover',
        component: Discover,
        meta: { access: 'public' }
    },
    {
        path: '/destination/:id',
        component: Destination,
        meta: { access: 'public' }
    },

    // Tikai ielogotiem lietotājiem
    {
        path: '/add-destination',
        component: AddDestination,
        meta: { access: 'auth' }
    },
    {
        path: '/profile',
        component: Profile,
        meta: { access: 'auth' }
    },

    // Admin lapas (ja nepieciešams)
    // {
    //     path: '/admin',
    //     redirect: '/admin/destinations'
    // },
    // {
    //     path: '/admin/destinations',
    //     component: () => import('../components/pages/AdminDestinations.vue'),
    //     meta: { access: 'admin' }
    // },

    // Guest lapas — pieejamas VISIEM
    {
        path: '/login',
        component: Login,
        meta: { access: 'guest', hideHeader: true }
    },
    {
        path: '/register',
        component: Register,
        meta: { access: 'guest', hideHeader: true }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to) => {
    const token = localStorage.getItem('token')
    const rawUser = localStorage.getItem('user')

    let user = null

    try {
        user = rawUser ? JSON.parse(rawUser) : null
    } catch {
        user = null
    }

    const isLoggedIn = Boolean(token && user)
    const role = user?.role

    // Tikai ielogotiem lietotājiem
    if (to.meta.access === 'auth' && !isLoggedIn) {
        return {
            path: '/login',
            query: { redirect: to.fullPath }
        }
    }

    // Tikai administratoriem
    if (to.meta.access === 'admin') {
        if (!isLoggedIn) {
            return {
                path: '/login',
                query: { redirect: to.fullPath }
            }
        }

        if (role !== 'admin') {
            return { path: '/' }
        }
    }

    // Login un Register ir pieejamas visiem,
    // tāpēc guest pārbaude šeit nav nepieciešama.

    return true
})

export default router