<template>
    <main class="register">
        <aside class="register__photo">
            <span class="register__brand">WANDERLIST</span>
        </aside>

        <section class="register__panel">
            <div class="register__inner">
                <router-link to="/" class="register__back">
                    <svg width="26" height="8" viewBox="0 0 26 8" aria-hidden="true">
                        <path d="M26 4H1M4 1L1 4l3 3" fill="none" stroke="currentColor" stroke-width="0.8" />
                    </svg>
                    BACK TO HOME
                </router-link>

                <p class="register__kicker">JOIN WANDERLIST</p>
                <h1 class="register__title">CREATE AN ACCOUNT</h1>
                <p class="register__lead">SAVE, PLAN, AND REMEMBER EVERY PLACE YOU WANT TO GO.</p>

                <form class="register__form" @submit.prevent="register">
                    <div class="field">
                        <label for="name">USERNAME</label>
                        <input
                            id="name"
                            v-model="Username"
                            type="text"
                            autocomplete="name"
                            placeholder="YOUR NAME"
                        >
                    </div>

                    <div class="field">
                        <label for="email">EMAIL</label>
                        <input
                            id="email"
                            v-model="email"
                            type="email"
                            autocomplete="email"
                            placeholder="YOU@EXAMPLE.COM"
                        >
                    </div>

                    <div class="field">
                        <label for="password">PASSWORD</label>
                        <input
                            id="password"
                            v-model="password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="••••••••••"
                        >
                    </div>

                    <p v-if="message" class="register__message" role="status">
                        {{ message }}
                    </p>

                    <button type="submit" class="register__submit">
                        CREATE ACCOUNT
                    </button>

                    <p class="register__signin">
                        ALREADY HAVE ACCOUNT?
                        <router-link to="/login">SIGN IN</router-link>
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
            email: '',
            password: '',
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
                this.$router.push('/login')

            } catch (error) {
                console.log(error.response)

                this.message =
                    error.response?.data?.message || 'Registration failed'
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.register {
    --muted: #555;
    --line: #444;
    --link: #5aa9e6;

    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.05fr);
    min-height: calc(100vh - 4.5rem);
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.register__photo {
    display: flex;
    align-items: flex-end;
    background: #6b7a63 url('/image/register-cover.png') center / cover no-repeat;
}

.register__brand {
    padding: 0 1.25rem 0.5rem;
    font-family: 'Italiana', serif;
    font-size: clamp(3rem, 8.5vw, 8rem);
    line-height: 1;
    color: #fff;
}

.register__panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
}

.register__inner {
    width: 100%;
    max-width: 26rem;
}

.register__back {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.65rem;
    color: var(--link);
    text-decoration: none;
}

.register__kicker {
    margin: 3rem 0 2.8rem;
    font-size: 0.95rem;
    font-weight: 400;
}

.register__title {
    margin: 0 0 0.75rem;
    font-family: 'Italiana', serif;
    font-weight: 400;
    font-size: clamp(1.9rem, 3.2vw, 2.5rem);
    letter-spacing: 0.04em;
    line-height: 1.1;
}

.register__lead {
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

.register__message {
    margin: -0.8rem 0 1.2rem;
    font-size: 0.75rem;
    text-align: center;
}

.register__submit {
    display: block;
    width: calc(100% - 2rem);
    margin: 0 auto;
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

.register__submit:hover {
    background: #222;
}

.register__submit:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

.register__signin {
    margin: 0.7rem 0 0;
    text-align: center;
    font-size: 0.6rem;
}

.register__signin a {
    color: inherit;
    text-decoration: underline;
    text-underline-offset: 2px;
}

@media (max-width: 860px) {
    .register {
        grid-template-columns: 1fr;
    }

    .register__photo {
        min-height: 32vh;
    }

    .register__brand {
        font-size: clamp(2.5rem, 14vw, 4.5rem);
    }

    .register__panel {
        padding: 2.5rem 1.5rem 3rem;
    }

    .register__kicker {
        margin: 2rem 0;
    }
}
</style>