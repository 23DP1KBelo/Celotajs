import { reactive } from 'vue'
import axios from 'axios'

export const auth = reactive({
    user: null,
    loaded: false
})

// Iegūst pašreizējo lietotāju
export async function fetchUser() {
    const token = localStorage.getItem('token')

    if (!token) {
        auth.user = null
        auth.loaded = true
        return null
    }

    try {
        const { data } = await axios.get('/api/me', {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        })

        auth.user = data.user
        return auth.user
    } catch (error) {
        console.error(
            'fetchUser failed:',
            error.response?.status,
            error.response?.data || error.message
        )

        // Dzēš tokenu tikai tad, ja tas vairs nav derīgs
        if (error.response?.status === 401) {
            auth.user = null
            localStorage.removeItem('token')
        }

        return null
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

    if (data.user) {
        localStorage.setItem('user', JSON.stringify(data.user))
    }

    auth.user = data.user ?? null
    auth.loaded = true

    return data
}


// Izlogošanās
export async function logout() {
    const token = localStorage.getItem('token')

    try {
        if (token) {
            await axios.post(
                '/api/logout',
                {},
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json'
                    }
                }
            )
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