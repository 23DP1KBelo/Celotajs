<template>
    <main class="discover">
        <section class="discover__intro">
            <h1>FIND YOUR<br>DESTINATION</h1>
            <p>
                MARK THE PLACES YOU'VE VISITED AND KEEP YOUR TRAVEL MEMORIES
                ORGANIZED, ONE TRIP AT A TIME.
            </p>
        </section>

        <section class="discover__main">
            <label class="search">
                <svg
                    width="30"
                    height="30"
                    viewBox="0 0 30 30"
                    aria-hidden="true"
                >
                    <circle
                        cx="13"
                        cy="13"
                        r="10"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1"
                    />
                    <path
                        d="M20.5 20.5L28 28"
                        stroke="currentColor"
                        stroke-width="1"
                    />
                </svg>

                <input
                    v-model="search"
                    type="search"
                    placeholder="SEARCH DESTINATIONS"
                    aria-label="Search destinations"
                >
            </label>

            <div class="filters">
                <label class="filter">
                    <select
                        v-model="category"
                        aria-label="Filter by category"
                    >
                        <option value="">ALL CATEGORIES</option>

                        <option
                            v-for="item in categories"
                            :key="item.value"
                            :value="item.value"
                        >
                            {{ item.label }}
                        </option>
                    </select>

                    <span class="filter__arrow" aria-hidden="true">V</span>
                </label>

                <label v-if="isLoggedIn" class="filter">
                    <select
                        v-model="status"
                        aria-label="Filter by status"
                    >
                        <option value="">ALL STATUSES</option>
                        <option value="visited">VISITED</option>
                        <option value="unvisited">UNVISITED</option>
                    </select>

                    <span class="filter__arrow" aria-hidden="true">V</span>
                </label>

                <button
                    v-if="search || category || status"
                    type="button"
                    class="filters__clear"
                    @click="clearFilters"
                >
                    CLEAR
                </button>
            </div>

            <p v-if="loading" class="empty">
                LOADING DESTINATIONS...
            </p>

            <p v-else-if="error" class="empty">
                {{ error }}
            </p>

            <ul v-else-if="filtered.length" class="grid">
                <li
                    v-for="place in filtered"
                    :key="place.id"
                >
                    <router-link
                        :to="`/destination/${place.id}`"
                        class="card"
                        :style="{
                            backgroundImage: `url('${place.image}')`
                        }"
                    >
                        <span>{{ place.name }}</span>
                    </router-link>
                </li>
            </ul>

            <p v-else class="empty">
                NO DESTINATIONS FOUND. TRY A DIFFERENT SEARCH.
            </p>
        </section>
    </main>
</template>

<script>
import axios from 'axios'
import { auth } from '../../auth.js'

export default {
    data() {
        return {
            search: '',
            category: '',
            status: '',
            destinations: [],
            loading: false,
            error: '',
            searchTimeout: null,

            categories: [
                { value: 'rest', label: 'REST' },
                { value: 'nature', label: 'NATURE' },
                { value: 'adventure', label: 'ADVENTURE' }
            ]
        }
    },

    computed: {
        isLoggedIn() {
            return !!auth.user
        },

        filtered() {
            return this.destinations.filter(place => {
                return !this.category ||
                    place.category === this.category
            })
        }
    },

    watch: {
        search() {
            clearTimeout(this.searchTimeout)

            this.searchTimeout = setTimeout(() => {
                this.fetchDestinations()
            }, 350)
        },

        category() {
            this.fetchDestinations()
        },

        status() {
            this.fetchDestinations()
        },

        isLoggedIn(loggedIn) {
            if (!loggedIn) {
                this.status = ''
            } else {
                this.fetchDestinations()
            }
        }
    },

    mounted() {
        this.fetchDestinations()
    },

    beforeUnmount() {
        clearTimeout(this.searchTimeout)
    },

    methods: {
        async fetchDestinations() {
            this.loading = true
            this.error = ''

            try {
                const searchTerm = this.search.trim()
                const token = localStorage.getItem('token')

                let endpoint
                let params = {}
                let config = {}

                if (this.isLoggedIn && this.status) {
                    endpoint = '/api/recommendations/status'

                    params = {
                        status: this.status,
                        search: searchTerm || undefined,
                        category: this.category || undefined
                    }

                    if (token) {
                        config.headers = {
                            Authorization: `Bearer ${token}`
                        }
                    }
                } else if (this.category && !searchTerm) {
                    endpoint = '/api/recommendations/category'

                    params = {
                        category: this.category
                    }
                } else {
                    endpoint = '/api/recommendations/search'

                    params = {
                        search: searchTerm || undefined
                    }
                }

                const { data } = await axios.get(endpoint, {
                    ...config,
                    params
                })

                if (!Array.isArray(data)) {
                    throw new Error('Invalid API response')
                }

                this.destinations = data.map(item => {
                    const destination = item.destination || {}
                    const place = destination.place || {}
                    const country = place.country || {}
                    const trip = item.trip || {}

                    const title =
                        destination.title ||
                        place.name ||
                        'Travel destination'

                    return {
                        id: destination.id ||
                            item.destination_id ||
                            item.id,

                        name: [
                            title,
                            place.name !== title ? place.name : '',
                            country.name || ''
                        ].filter(Boolean).join(' | '),

                        category: trip.category || '',
                        status: trip.status || 'unvisited',

                        image:
                            destination.image ||
                            place.image ||
                            trip.image ||
                            `https://picsum.photos/seed/destination-${destination.id || item.destination_id || item.id}/600/350`
                    }
                })
            } catch (error) {
                console.error(
                    'Failed to load destinations:',
                    error.response?.data || error.message
                )

                this.destinations = []

                this.error = error.response?.status === 401
                    ? 'PLEASE LOG IN TO FILTER BY STATUS.'
                    : 'FAILED TO LOAD DESTINATIONS. PLEASE TRY AGAIN.'
            } finally {
                this.loading = false
            }
        },

        clearFilters() {
            clearTimeout(this.searchTimeout)

            this.search = ''
            this.category = ''
            this.status = ''

            this.fetchDestinations()
        }
    }
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.discover {
    --muted: #777;
    --link: #5aa9e6;
    --serif: 'Italiana', serif;

    display: grid;
    grid-template-columns: minmax(0, 0.8fr) minmax(0, 1.4fr);
    gap: 3rem;
    align-items: center;
    min-height: calc(100vh - 4.5rem);
    padding: 2rem 2rem 4rem 1.5rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}


.discover__intro h1 {
    margin: 0 0 2rem;
    font-family: var(--serif);
    font-weight: 400;
    font-size: clamp(2.6rem, 5.2vw, 4.5rem);
    line-height: 1.1;
    letter-spacing: 0.03em;
}

.discover__intro p {
    margin: 0;
    max-width: 21rem;
    font-size: 1.05rem;
    line-height: 1.35;
    font-weight: 400;
}


.search {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding-bottom: 0.4rem;
    border-bottom: 1px solid #555;
    color: var(--muted);
}

.search input {
    flex: 1;
    border: 0;
    background: transparent;
    font-family: var(--serif);
    font-size: 1.15rem;
    letter-spacing: 0.04em;
    color: #000;
    outline: none;
}

.search input::placeholder {
    color: var(--muted);
}

.search:focus-within {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}


.filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    margin: 1.8rem 0 3.5rem;
}

.filter {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.filter select {
    padding-right: 1.8rem;
    border: 0;
    background: transparent;
    font-family: var(--serif);
    font-size: 1.05rem;
    letter-spacing: 0.04em;
    color: var(--muted);
    appearance: none;
    cursor: pointer;
    outline: none;
}

.filter select:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 4px;
}

.filter__arrow {
    position: absolute;
    right: 0;
    font-family: var(--serif);
    font-size: 1.1rem;
    color: var(--muted);
    pointer-events: none;
}

.filters__clear {
    border: 0;
    background: none;
    padding: 0;
    font: inherit;
    font-size: 0.7rem;
    color: var(--link);
    text-decoration: underline;
    text-underline-offset: 3px;
    cursor: pointer;
}


.grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.2rem;
    margin: 0;
    padding: 0;
    list-style: none;
}

.card {
    display: flex;
    align-items: flex-end;
    aspect-ratio: 1.25 / 1;
    padding: 0.7rem 0.8rem;
    border-radius: 1rem;
    background: #6b7a63 center / cover no-repeat;
    color: #fff;
    text-decoration: none;
    font-family: var(--serif);
    font-size: clamp(1rem, 1.5vw, 1.35rem);
    letter-spacing: 0.03em;
    text-shadow: 0 1px 10px rgba(0, 0, 0, 0.5);
    transition: transform 0.25s;
}

.card:hover {
    transform: translateY(-4px);
}

.card:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

.empty {
    margin: 0;
    font-size: 0.85rem;
    color: var(--muted);
}

/* ---------- Mobile / tablet ---------- */
@media (max-width: 1000px) {
    .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 860px) {
    .discover {
        grid-template-columns: 1fr;
        gap: 2.5rem;
        padding: 2rem 1.2rem 3rem;
    }

    .filters {
        margin-bottom: 2rem;
    }
}

@media (max-width: 520px) {
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>