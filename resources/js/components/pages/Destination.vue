<template>
    <main class="place">
        <div class="place__inner">
            <router-link to="/discover" class="place__back">
                <svg width="30" height="8" viewBox="0 0 30 8" aria-hidden="true">
                    <path d="M30 4H1M4 1L1 4l3 3" fill="none" stroke="currentColor" stroke-width="0.8" />
                </svg>
                BACK TO DISCOVER
            </router-link>

            <template v-if="place">
                <header class="place__head">
                    <div>
                        <h1>{{ place.title }}</h1>
                        <p class="place__where">{{ place.city }}, {{ place.country }}</p>
                    </div>

                    <button
                        type="button"
                        class="place__add"
                        :class="{ 'place__add--on': added }"
                        :aria-pressed="added"
                        @click="toggleList"
                    >
                        {{ added ? '✓ IN MY LIST' : '+ ADD TO MY LIST' }}
                    </button>
                </header>

                <img class="place__img" :src="place.image" :alt="place.title">

                <p class="place__desc">{{ place.description }}</p>

                <h2 class="place__sub">BASIC INFORMATION</h2>
                <dl class="info">
                    <div class="info__row">
                        <dt>COUNTRY</dt>
                        <dd>{{ place.country }}</dd>
                    </div>
                    <div class="info__row">
                        <dt>CITY</dt>
                        <dd>{{ place.city }}</dd>
                    </div>
                    <div class="info__row">
                        <dt>CATEGORY</dt>
                        <dd>{{ place.category }}</dd>
                    </div>
                </dl>

                <p v-if="!added" class="place__hint">
                    ADD THIS PLACE TO YOUR LIST TO SET A BUDGET, PRIORITY, AND TRACK YOUR VISIT STATUS.
                </p>
            </template>

            <p v-else class="place__missing">PLACE NOT FOUND.</p>
        </div>
    </main>
</template>

<script>
import axios from 'axios'
import { findDestination } from '../../data/destinations.js'

export default {
    data() {
        return {
            added: false
        }
    },

    computed: {
        place() {
            return findDestination(this.$route.params.id)
        }
    },

    watch: {
        '$route.params.id'() {
            this.added = false
        }
    },

    methods: {
        async toggleList() {
            this.added = !this.added

            try {
                await axios.post('/api/my-list', {
                    destination_id: this.place.id
                }, {
                    withCredentials: true
                })
            } catch (error) {
                console.log(error.response)
                this.added = !this.added   
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.place {
    --muted: #555;
    --link: #5aa9e6;
    --serif: 'Italiana', serif;

    min-height: calc(100vh - 4.5rem);
    padding: 3rem 1.5rem 6rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
    text-transform: uppercase;
}

.place__inner {
    max-width: 66rem;
    margin: 0 auto;
}

.place__back {
    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 0.7rem;
    color: var(--link);
    text-decoration: none;
}


.place__head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.5rem;
    margin: 4rem 0 3.5rem;
}

.place__head h1 {
    margin: 0 0 0.6rem;
    font-family: var(--serif);
    font-weight: 400;
    font-size: clamp(2.2rem, 5vw, 3.6rem);
    line-height: 1.05;
    letter-spacing: 0.04em;
}

.place__where {
    margin: 0;
    font-size: 0.85rem;
}

.place__add {
    flex-shrink: 0;
    padding: 1.35rem 3rem;
    border: 1px solid #000;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.85rem;
    font-weight: 400;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}

.place__add:hover {
    background: #222;
}

.place__add--on {
    background: #fff;
    color: #000;
}

.place__add:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

/* ---------- Image + text ---------- */
.place__img {
    display: block;
    width: 100%;
    aspect-ratio: 1.44 / 1;
    max-height: 70vh;
    object-fit: cover;
    background: #6b7a63;
}

.place__desc {
    max-width: 52rem;
    margin: 4rem 0 5rem;
    font-size: 1.15rem;
    line-height: 1.5;
}


.place__sub {
    margin: 0 0 1.6rem;
    font-size: 0.9rem;
    font-weight: 400;
}

.info {
    margin: 0;
    border-top: 1px solid #777;
}

.info__row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.6rem 0.5rem;
    border-bottom: 1px solid #aaa;
}

.info dt {
    font-size: 0.85rem;
    color: var(--muted);
}

.info dd {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 400;
    text-align: right;
}

.place__hint {
    margin: 4.5rem 0 0 0.5rem;
    font-size: 0.8rem;
    color: var(--link);
}

.place__missing {
    margin: 4rem 0;
    font-size: 0.9rem;
}

/* ---------- Mobile ---------- */
@media (max-width: 700px) {
    .place__head {
        flex-direction: column;
        align-items: flex-start;
        margin: 2.5rem 0;
    }

    .place__add {
        padding: 1rem 2rem;
    }

    .place__desc {
        margin: 2.5rem 0 3rem;
        font-size: 1rem;
    }
}
</style>