
<script setup>
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { auth, fetchUser, logout } from '../auth.js'

const route = useRoute()
const router = useRouter()

const showHeader = computed(() => !route.meta.hideHeader)
const isLoggedIn = computed(() => Boolean(auth.user))

onMounted(async () => {
    try {
        await fetchUser()
    } catch (error) {
        console.error('Neizdevās ielādēt lietotāja datus:', error)
    }
})

async function handleLogout() {
    try {
        await logout()
        await router.push('/')
    } catch (error) {
        console.error('Neizdevās izrakstīties:', error)
    }
}
</script>

<template>
    <v-app>
        <header v-if="showHeader" class="header">
            <nav class="header__nav" aria-label="Main navigation">
                <router-link to="/" class="header__link">
                    HOME
                </router-link>

                <router-link to="/discover" class="header__link">
                    DISCOVER
                </router-link>

                <template v-if="isLoggedIn">
                    <router-link
                        to="/add-destination"
                        class="header__link"
                    >
                        ADD DESTINATION
                    </router-link>

                    <router-link
                        to="/profile"
                        class="header__link"
                    >
                        PROFILE
                    </router-link>
                </template>
            </nav>

            <div class="header__right">
                <span class="header__lang">EN | LV</span>

                <template v-if="auth.loaded">
                    <template v-if="!isLoggedIn">
                        <router-link
                            to="/login"
                            class="pill pill--dark"
                        >
                            LOG IN
                        </router-link>

                        <router-link
                            to="/register"
                            class="pill pill--light"
                        >
                            SIGN UP
                        </router-link>
                    </template>

                    <button
                        v-else
                        type="button"
                        class="pill pill--light"
                        @click="handleLogout"
                    >
                        LOG OUT
                    </button>
                </template>
            </div>
        </header>

        <v-main>
            <RouterView />
        </v-main>
    </v-app>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

html,
body,
#app {
    min-height: 100%;
    margin: 0;
}

body {
    font-family: 'Jost', system-ui, sans-serif;
}

.header {
    position: relative;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 0.8rem 1.2rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    font-size: 0.75rem;
    letter-spacing: 0.04em;
}

.header__nav,
.header__right {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.header__right {
    gap: 0.75rem;
}

.header__link {
    color: #000;
    text-decoration: none;
    transition: opacity 0.2s;
}

.header__link:hover {
    opacity: 0.6;
}

.header__link.router-link-active {
    text-decoration: underline;
    text-underline-offset: 5px;
}

.header a:focus-visible,
.header button:focus-visible {
    outline: 2px solid #5aa9e6;
    outline-offset: 3px;
}

.header__lang {
    white-space: nowrap;
}

.pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.45rem 1.2rem;
    border: 1px solid #222;
    border-radius: 999px;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    font-family: inherit;
    font-size: 0.75rem;
    letter-spacing: 0.04em;
}

.pill--dark {
    background: #222;
    color: #fff !important;
}

.pill--light {
    background: #fff;
    color: #000 !important;
}

.pill:hover {
    opacity: 0.75;
}

@media (max-width: 760px) {
    .header {
        flex-direction: column;
        align-items: center;
        padding: 1rem 0.75rem;
    }

    .header__nav {
        justify-content: center;
        gap: 0.8rem 1.2rem;
    }

    .header__right {
        justify-content: center;
        flex-wrap: wrap;
    }
}
</style>
