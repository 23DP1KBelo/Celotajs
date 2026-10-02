<template>
    <div>
        <h1>Register</h1>

        <form @submit.prevent="register">
            <input
                v-model="Username"
                type="text"
                placeholder="Username"
            >

            <input
                v-model="email"
                type="email"
                placeholder="Email"
            >

            <input
                v-model="password"
                type="password"
                placeholder="Password"
            >

            <input
                v-model="password_confirmation"
                type="password"
                placeholder="Confirm password"
            >

            <button type="submit">
                Register
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
            email: '',
            password: '',
            password_confirmation: '',
            message: ''
        }
    },

    methods: {
        async register() {
            try {
                await axios.get('/sanctum/csrf-cookie', {
                    withCredentials: true
                })

                const response = await axios.post('/api/register', {
                    Username: this.Username,
                    email: this.email,
                    password: this.password,
                }, {
                    withCredentials: true
                })

                console.log(response.data)

                this.message = 'Registration successful!'

            } catch (error) {
                console.log(error.response)

                this.message =
                    error.response?.data?.message || 'Registration failed'
            }
        }
    }
}
</script>