<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const showHeader = computed(() => !route.meta.hideHeader)
</script>
<template>
    <v-app>
        <header v-if="showHeader" class="header">
        <nav class="header__nav" aria-label="Main">
            <router-link to="/discover">DISCOVER</router-link>
            <router-link to="/add-destination">ADD DESTINATION</router-link>
            <router-link to="/profile">PROFILE</router-link>
            <router-link to="/statistics">STATISTICS</router-link>
        </nav>
 
        <div class="header__right">
            <span class="header__lang">EN | LV</span>
            <router-link to="/login" class="pill pill--dark">LOG IN</router-link>
            <router-link to="/register" class="pill pill--light">SIGN UP</router-link>
        </div>
    </header>

        <v-main>
        <RouterView />
        </v-main>
    </v-app>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');
 
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 0.6rem;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    font-size: 0.75rem;
    letter-spacing: 0.04em;
    background: #fff;
}
 
.header__nav,
.header__right {
    display: flex;
    align-items: center;
    gap: 2rem;
}
 
.header a {
    color: #000;
    text-decoration: none;
}
 
.header__right {
    gap: 1rem;
}
 
.pill {
    padding: 0.35rem 1.4rem;
    border: 1px solid #222;
    border-radius: 999px;
}
 
.pill--dark {
    background: #222;
    color: #fff !important;
}
 
.header a:focus-visible {
    outline: 2px solid #5aa9e6;
    outline-offset: 3px;
}
 
@media (max-width: 760px) {
    .header {
        flex-direction: column;
        gap: 0.8rem;
    }
 
    .header__nav {
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
 