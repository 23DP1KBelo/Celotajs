
import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/pages/Home.vue'
import Discover from '../components/pages/Discover.vue'
import Destination from '../components/pages/Destination.vue'
import AddDestination from '../components/pages/AddDestination.vue'
import Login from '../components/pages/Login.vue'
import Register from '../components/pages/Register.vue'
import Profile from '../components/pages/Profile.vue'

const routes = [
    // Publiskās lapas — pieejamas bez login
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: { access: 'public' }
    },
    {
        path: '/discover',
        name: 'Discover',
        component: Discover,
        meta: { access: 'public' }
    },
    {
        path: '/destination/:id',
        name: 'Destination',
        component: Destination,
        meta: { access: 'public' }
    },

    // Tikai ielogotiem lietotājiem
    {
        path: '/add-destination',
        name: 'AddDestination',
        component: AddDestination,
        meta: { access: 'auth' }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta: { access: 'auth' }
    },

    // Login un Register
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { access: 'guest', hideHeader: true }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { access: 'guest', hideHeader: true }
    },

    // Neeksistējošs maršruts
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 }
    }
})

router.beforeEach((to) => {
    const token = localStorage.getItem('token')

    let user = null

    try {
        const rawUser = localStorage.getItem('user')
        user = rawUser ? JSON.parse(rawUser) : null
    } catch {
        localStorage.removeItem('user')
    }

    const isLoggedIn = Boolean(token && user)

    // Publiskajām lapām nav nepieciešama autentifikācija.
    if (to.meta.access === 'public') {
        return true
    }

    // Pārējām aizsargātajām lapām nepieciešama ielogošanās.
    if (to.meta.access === 'auth' && !isLoggedIn) {
        return {
            name: 'Login',
            query: { redirect: to.fullPath }
        }
    }

    // Ja lietotājs jau ir ielogojies, viņš var atvērt arī login/register.
    return true
})

export default router
