<template>
    <main class="discover">
        <section class="discover__intro">
            <h1>FIND YOUR<br>DESTINATION</h1>
            <p>MARK THE PLACES YOU'VE VISITED AND KEEP YOUR TRAVEL MEMORIES ORGANIZED, ONE TRIP AT A TIME.</p>
        </section>

        <section class="discover__main">
            <label class="search">
                <svg width="30" height="30" viewBox="0 0 30 30" aria-hidden="true">
                    <circle cx="13" cy="13" r="10" fill="none" stroke="currentColor" stroke-width="1" />
                    <path d="M20.5 20.5L28 28" stroke="currentColor" stroke-width="1" />
                </svg>
                <input
                    v-model.trim="search"
                    type="search"
                    placeholder="TYPE IN YOUR SEARCH"
                    aria-label="Search destinations"
                >
            </label>

            <div class="filters">
                <label class="filter">
                    <select v-model="category" aria-label="Filter by category">
                        <option value="">FILTER BY CATEGORY</option>
                        <option v-for="item in categories" :key="item" :value="item">
                            {{ item.toUpperCase() }}
                        </option>
                    </select>
                    <span class="filter__arrow" aria-hidden="true">V</span>
                </label>

                <label class="filter">
                    <select v-model="status" aria-label="Filter by status">
                        <option value="">FILTER BY STATUS</option>
                        <option v-for="item in statuses" :key="item.value" :value="item.value">
                            {{ item.label }}
                        </option>
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

            <ul v-if="filtered.length" class="grid">
                <li v-for="place in filtered" :key="place.id">
                    <router-link
                        :to="`/destination/${place.id}`"
                        class="card"
                        :style="{ backgroundImage: `url('${place.image}')` }"
                    >
                        <span>{{ place.name }}</span>
                    </router-link>
                </li>
            </ul>

            <p v-else class="empty">NO DESTINATIONS FOUND. TRY A DIFFERENT SEARCH.</p>
        </section>
    </main>
</template>

<script>

import { destinations } from '../../data/destinations.js'
export default {
    data() {
        return {
            search: '',
            category: '',
            status: '',

            categories: ['Daba', 'Atpūta', 'Izklaide'],
            statuses: [
                { value: 'visited', label: 'APMEKLĒTS' },
                { value: 'not_visited', label: 'NEAPMEKLĒTS' }
            ],
             destinations 
        }
    },

    computed: {
        filtered() {
            const query = this.search.toLowerCase()

            return this.destinations.filter((place) => {
                const matchesSearch = !query || place.name.toLowerCase().includes(query)
                const matchesCategory = !this.category || place.category === this.category
                const matchesStatus = !this.status || place.status === this.status

                return matchesSearch && matchesCategory && matchesStatus
            })
        }
    },

    methods: {
        clearFilters() {
            this.search = ''
            this.category = ''
            this.status = ''
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