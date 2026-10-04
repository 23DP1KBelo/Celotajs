<template>
    <main class="login">
        <aside class="login__photo">
            <span class="login__brand">WANDERLIST</span>
        </aside>

        <section class="login__panel">
            <div class="login__inner">
                <router-link to="/" class="login__back">
                    <svg width="26" height="8" viewBox="0 0 26 8" aria-hidden="true">
                        <path d="M26 4H1M4 1L1 4l3 3" fill="none" stroke="currentColor" stroke-width="0.8" />
                    </svg>
                    BACK TO HOME
                </router-link>

                <p class="login__kicker">WELCOME BACK</p>
                <h1 class="login__title">SIGN IN</h1>
                <p class="login__lead">PICK UP WHERE YOU LEFT OFF WITH YOUR SAVED PLACES.</p>

                <form class="login__form" @submit.prevent="login">
                    <div class="field">
                        <label for="email">EMAIL</label>
                        <input
                            id="email"
                            v-model="Username"
                            type="text"
                            autocomplete="username"
                            placeholder="YOU@EXAMPLE.COM"
                        >
                    </div>

                    <div class="field">
                        <label for="password">PASSWORD</label>
                        <input
                            id="password"
                            v-model="password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="••••••••••"
                        >
                    </div>

                    <p v-if="message" class="login__message" role="status">
                        {{ message }}
                    </p>

                    <button type="submit" class="login__submit">
                        SIGN IN
                    </button>

                    <p class="login__switch">
                        NEW TO WANDERLIST?
                        <router-link to="/register">CREATE AN ACCOUNT</router-link>
                    </p>
                </form>
            </div>
        </section>
    </main>
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
                this.$router.push('/')

            } catch (error) {
                console.log(error.response)

                this.message =
                    error.response?.data?.message || 'Login failed'
            }
        }
    } 
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.login {
    --muted: #555;
    --line: #444;
    --link: #5aa9e6;

    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.05fr);
    min-height: 100vh;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.login__photo {
    display: flex;
    align-items: flex-end;
    background: #5f7f8a url('/image/login-cover.png') center / cover no-repeat;
}

.login__brand {
    padding: 0 1.25rem 0.5rem;
    font-family: 'Italiana', serif;
    font-size: clamp(3rem, 8.5vw, 8rem);
    line-height: 1;
    color: #fff;
}

.login__panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
}

.login__inner {
    width: 100%;
    max-width: 26rem;
}

.login__back {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.65rem;
    color: var(--link);
    text-decoration: none;
}

.login__kicker {
    margin: 3rem 0 2.8rem;
    font-size: 0.95rem;
    font-weight: 400;
}

.login__title {
    margin: 0 0 0.75rem;
    font-family: 'Italiana', serif;
    font-weight: 400;
    font-size: clamp(1.9rem, 3.2vw, 2.5rem);
    letter-spacing: 0.04em;
    line-height: 1.1;
}

.login__lead {
    margin: 0 0 3.5rem;
    font-size: 0.72rem;
}

.field {
    display: flex;
    flex-direction: column;
    margin-bottom: 2.4rem;
}

.field label {
    font-size: 0.65rem;
    color: var(--muted);
}

.field input {
    padding: 0.9rem 0 0.4rem;
    border: 0;
    border-bottom: 1px solid var(--line);
    border-radius: 0;
    background: transparent;
    font: inherit;
    font-size: 0.95rem;
    outline: none;
}

.field input::placeholder {
    font-size: 0.65rem;
    color: #8a8a8a;
}

.field input:focus-visible {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.login__message {
    margin: 0 0 1.2rem;
    font-size: 0.75rem;
    text-align: center;
}

.login__submit {
    display: block;
    width: calc(100% - 2rem);
    margin: 4.5rem auto 0;
    padding: 1.1rem 1rem;
    border: 0;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.8rem;
    font-weight: 400;
    cursor: pointer;
}

.login__submit:hover {
    background: #222;
}

.login__submit:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

.login__switch {
    margin: 0.7rem 0 0;
    text-align: center;
    font-size: 0.6rem;
}

.login__switch a {
    color: inherit;
    text-decoration: underline;
    text-underline-offset: 2px;
}

@media (max-width: 860px) {
    .login {
        grid-template-columns: 1fr;
    }

    .login__photo {
        min-height: 32vh;
    }

    .login__brand {
        font-size: clamp(2.5rem, 14vw, 4.5rem);
    }

    .login__panel {
        padding: 2.5rem 1.5rem 3rem;
    }

    .login__kicker {
        margin: 2rem 0;
    }

    .login__submit {
        margin-top: 2rem;
    }
}
</style>