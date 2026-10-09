
import { reactive } from 'vue'
import axios from 'axios'

export const auth = reactive({
    user: null,
    loaded: false
})

// Iegūst pašreizējo lietotāju
export async function fetchUser() {
    try {
        const token = localStorage.getItem('token')

        if (!token) {
            auth.user = null
            return
        }

        const { data } = await axios.get('/api/me', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        // Laravel me() atgriež { user: UserResource }
        auth.user = data.user
    } catch (error) {
        auth.user = null
        localStorage.removeItem('token')
    } finally {
        auth.loaded = true
    }
}

// Ielogošanās
export async function login(Username, password) {
    const { data } = await axios.post('/api/login', {
        Username,
        password
    })

    localStorage.setItem('token', data.token)
    auth.user = data.user
    auth.loaded = true

    return data
}

// Izlogošanās
export async function logout() {
    const token = localStorage.getItem('token')

    try {
        if (token) {
            await axios.post('/api/logout', {}, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
        }
    } catch (error) {
        console.error(
            'Logout failed:',
            error.response?.data || error.message
        )
    } finally {
        localStorage.removeItem('token')
        auth.user = null
        auth.loaded = true
    }
}

