<template>
    <div>
        <h1>Login</h1>

        <form @submit.prevent="login">
            <input
                v-model="Username"
                type="text"
                placeholder="Username"
            >

            <input
                v-model="password"
                type="password"
                placeholder="Password"
            >

            <button type="submit">
                Login
            </button>
        </form>

        <p v-if="message">
            {{ message }}
        </p>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            Username: '',
            password: '',
            message: ''
        }
    },

    methods: {
        async login() {
            try {
                await axios.get('/sanctum/csrf-cookie', {
                    withCredentials: true
                })

                const response = await axios.post('/api/login', {
                    Username: this.Username,
                    password: this.password
                }, {
                    withCredentials: true
                })

                console.log(response.data)

                this.message = 'Login successful!'

            } catch (error) {
                console.log(error.response)

                this.message =
                    error.response?.data?.message || 'Login failed'
            }
        }
    } 
}
</script>