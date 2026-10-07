import { reactive } from 'vue'
import axios from 'axios'

export const auth = reactive({
    user: null,
    loaded: false
})

export async function fetchUser() {
    try {
        const { data } = await axios.get('/api/user', { withCredentials: true })
        auth.user = data
    } catch (error) {
        auth.user = null
    } finally {
        auth.loaded = true
    }
}

export async function logout() {
    try {
        await axios.post('/api/logout', {}, { withCredentials: true })
    } catch (error) {
        console.log(error.response)
    }
    auth.user = null
}