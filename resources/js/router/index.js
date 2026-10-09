import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/pages/Home.vue'
import Discover from '../components/pages/Discover.vue'
import Destination from '../components/pages/Destination.vue' 
import Login from '../components/pages/Login.vue'
import Register from '../components/pages/Register.vue'
import Profile from '../components/pages/Profile.vue'


const routes = [
    { path: '/', component: Home},
    { path: '/discover', component: Discover },
    { path: '/destination/:id', component: Destination },
    { path: '/profile', component: Profile },
    { path: '/login', component: Login, meta: { hideHeader: true } },
    { path: '/register', component: Register, meta: { hideHeader: true }},
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router