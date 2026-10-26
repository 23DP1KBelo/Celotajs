
<template>
    <main class="trip-details">
        <p v-if="loading" class="trip-details__message">
            {{ $t('tripDetails.loading') }}
        </p>

        <section v-else-if="error" class="trip-details__message">
            <h1>{{ $t(error) }}</h1>
            <router-link to="/profile">
                {{ $t('tripDetails.backToTrips') }}
            </router-link>
        </section>

        <template v-else-if="trip">
            <header
                class="trip-hero"
                :style="{
                    backgroundImage: trip.image
                        ? `linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.6)),url('${trip.image}')`
                        : 'linear-gradient(135deg,#75816c,#394638)'
                }"
            >
                <router-link to="/profile" class="trip-hero__back">
                    {{ $t('tripDetails.backToTrips') }}
                </router-link>

                <span
                    class="card__badge"
                    :class="{ 'card__badge--dark': trip.status === 'visited' }"
                >
                    {{ $t(trip.status === 'visited'
                        ? 'common.visited'
                        : 'common.wantToVisit') }}
                </span>

                <div class="trip-hero__content">
                    <p>{{ $t('tripDetails.travelCollection') }}</p>
                    <h1>{{ trip.title || trip.name }}</h1>
                    <p v-if="trip.description">{{ trip.description }}</p>
                </div>
            </header>

            <section class="trip-info">
                <div class="trip-info__item">
                    <span>{{ $t('tripDetails.dateFrom') }}</span>
                    <strong>{{ formatDate(trip.date_from || trip.date_form) }}</strong>
                </div>

                <div class="trip-info__item">
                    <span>{{ $t('tripDetails.dateTill') }}</span>
                    <strong>{{ formatDate(trip.date_till) }}</strong>
                </div>

                <div class="trip-info__item">
                    <span>{{ $t('tripDetails.budget') }}</span>
                    <strong>{{ formatBudget(trip.budget) }}</strong>
                </div>

                <div class="trip-info__item">
                    <span>{{ $t('tripDetails.category') }}</span>
                    <strong>{{ formatCategory(trip.category) }}</strong>
                </div>
            </section>

            <section class="trip-places">
                <div class="trip-places__heading">
                    <div>
                        <p>{{ $t('tripDetails.yourCollection') }}</p>
                        <h2>{{ $t('tripDetails.destinations') }}</h2>
                    </div>
                    <span>
                        {{ $t('tripDetails.places', { count: destinations.length }) }}
                    </span>
                </div>

                <p v-if="!destinations.length" class="trip-details__message">
                    {{ $t('tripDetails.noDestinations') }}
                </p>

                <ul v-else class="grid">
                    <li v-for="item in destinations" :key="item.id">
                        <router-link
                            v-if="getDestinationId(item)"
                            class="card destination-card"
                            :to="{
                                path: `/destination/${getDestinationId(item)}`
                            }"
                            :style="{
                                backgroundImage: getDestinationImage(item)
                                    ? `linear-gradient(transparent 40%,rgba(0,0,0,.6)),url('${getDestinationImage(item)}')`
                                    : 'linear-gradient(180deg,#75816c 55%,#394638)'
                            }"
                        >
                            <span class="card__name">
                                {{ getDestinationName(item) }}
                            </span>
                        </router-link>

                        <article
                            v-else
                            class="card destination-card"
                            :style="{
                                backgroundImage: getDestinationImage(item)
                                    ? `linear-gradient(transparent 40%,rgba(0,0,0,.6)),url('${getDestinationImage(item)}')`
                                    : 'linear-gradient(180deg,#75816c 55%,#394638)'
                            }"
                        >
                            <span class="card__name">
                                {{ getDestinationName(item) }}
                            </span>
                        </article>
                    </li>
                </ul>
            </section>
        </template>
    </main>
</template>

<script>
import axios from 'axios'
import { i18n } from '../../i18n.js'

export default {
    data() {
        return {
            trip: null,
            destinations: [],
            loading: true,
            error: ''
        }
    },

    computed: {
        currentLocale() {
            return i18n.locale
        }
    },

    async mounted() {
        await this.loadTrip()
    },

    watch: {
        '$route.params.id'() {
            this.loadTrip()
        }
    },

    methods: {
        async loadTrip() {
            this.loading = true
            this.error = ''

            try {
                const token = localStorage.getItem('token')

                if (!token) {
                    await this.$router.push('/login')
                    return
                }

                const headers = {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }

                const { data } = await axios.get(
                    `/api/trips/${this.$route.params.id}`,
                    { headers }
                )

                let trip = data.trip || data.data || data

                if (!trip || !trip.id) {
                    throw new Error('Trip not found')
                }

                let destinations =
                    trip.trip_destinations || trip.destinations || []

                if (!Array.isArray(destinations) || destinations.length === 0) {
                    const response = await axios.get(
                        '/api/user/trips',
                        { headers }
                    )

                    const trips = response.data.data || response.data

                    const fullTrip = Array.isArray(trips)
                        ? trips.find(item => Number(item.id) === Number(trip.id))
                        : null

                    if (fullTrip) {
                        trip = { ...trip, ...fullTrip }

                        destinations =
                            fullTrip.trip_destinations ||
                            fullTrip.destinations ||
                            []
                    }
                }

                this.trip = trip
                this.destinations = Array.isArray(destinations)
                    ? destinations
                    : []

            } catch (error) {
                console.error(
                    'Failed to load trip:',
                    error.response?.data || error.message
                )

                if (error.response?.status === 401) {
                    await this.$router.push('/login')
                } else if (error.response?.status === 404) {
                    this.error = 'tripDetails.notFound'
                } else {
                    this.error = 'tripDetails.loadError'
                }
            } finally {
                this.loading = false
            }
        },

        getDestination(item) {
            return item?.destination || item?.place || item || {}
        },

        getDestinationId(item) {
            const destination = this.getDestination(item)

            return destination.id ||
                item?.destination_id ||
                item?.id ||
                null
        },

        getDestinationName(item) {
            const destination = this.getDestination(item)

            return destination.name ||
                destination.title ||
                destination.place?.name ||
                destination.place?.title ||
                this.$t('tripDetails.untitledDestination')
        },

        getDestinationImage(item) {
            const destination = this.getDestination(item)

            return destination?.image ||
                `https://picsum.photos/seed/destination-${destination.id || item.destination_id || item.id}/600/350`
        },

        formatDate(value) {
            if (!value) {
                return this.$t('common.notSpecified')
            }

            const date = new Date(`${value}T00:00:00`)

            if (Number.isNaN(date.getTime())) {
                return value
            }

            return date.toLocaleDateString(
                this.currentLocale === 'lv' ? 'lv-LV' : 'en-GB',
                {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }
            )
        },

        formatBudget(value) {
            if (value === null || value === undefined || value === '') {
                return this.$t('common.notSpecified')
            }

            return `€${value}`
        },

        formatCategory(value) {
            if (!value) {
                return this.$t('common.notSpecified')
            }

            const key = `categories.${value}`

            const translated = this.$t(key)

            return translated === key
                ? value.charAt(0).toUpperCase() + value.slice(1)
                : translated
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.trip-details {
    padding: 0 0.6rem 6rem;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
     background: #fff;
}

.trip-hero {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 27rem;
    padding: 1.5rem;
    overflow: hidden;
    background-position: center;
    background-size: cover;
    color: #fff;
}

.trip-hero__back {
    align-self: flex-start;
    color: #fff;
    font-size: 0.7rem;
    text-decoration: none;
}

.card__badge {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    background: #fff;
    color: #000;
    font-size: 0.7rem;
    font-weight: 400;
}

.card__badge--dark {
    background: #000;
    color: #fff;
}

.trip-hero__content {
    position: relative;
    max-width: 55rem;
}

.trip-hero__content > p:first-child {
    font-size: 0.75rem;
    letter-spacing: 0.12em;
}

.trip-hero__content h1,
.trip-places h2 {
    margin: 0;
    font-family: 'Italiana', serif;
    font-weight: 400;
}

.trip-hero__content h1 {
    font-size: clamp(3rem, 9vw, 7rem);
    line-height: 1;
    overflow-wrap: anywhere;
}

.trip-hero__content > p:last-child {
    max-width: 40rem;
    font-size: 0.9rem;
    line-height: 1.6;
}

.trip-info {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1.5rem;
    padding: 2.5rem 1rem;
    border-bottom: 1px solid #bdbdbd;
    background: #fff;
}

.trip-info__item {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    overflow-wrap: anywhere;
     
}

.trip-info__item span {
    color: #555;
    font-size: 0.7rem;
    letter-spacing: 0.08em;
}

.trip-info__item strong {
    font-size: 1rem;
    font-weight: 400;
}

.trip-places {
    padding: 3.5rem 1rem 0;
     background: #fff;
}

.trip-places__heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
     background: #fff;
}

.trip-places__heading p {
    margin: 0 0 0.5rem;
    color: #555;
    font-size: 0.7rem;
    letter-spacing: 0.1em;
}

.trip-places h2 {
    font-size: 2.5rem;
}

.trip-places__heading > span {
    font-size: 0.7rem;
}

.grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin: 1.5rem 0 0;
    padding: 0;
    list-style: none;
     
}

.card {
    position: relative;
    display: flex;
    align-items: flex-end;
    height: 15rem;
    padding: 0.75rem;
    overflow: hidden;
    border-radius: 1rem;
    background-position: center;
    background-size: cover;
    color: #fff;
    text-decoration: none;
    transition: transform 0.25s;
}

.card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(transparent 50%, rgba(0, 0, 0, 0.45));
}

.card:hover {
    transform: translateY(-4px);
}

.card__name {
    position: relative;
    color: #fff;
    font-family: 'Italiana', serif;
    font-size: 1.1rem;
    letter-spacing: 0.03em;
    text-shadow: 0 1px 10px rgba(0, 0, 0, 0.5);
}

.trip-details__message {
    margin: 2rem 0;
    font-size: 0.85rem;
}

.trip-details__message a {
    display: inline-block;
    margin-top: 1rem;
    color: #5aa9e6;
}

@media (max-width: 900px) {
    .trip-info {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {
    .trip-hero {
        min-height: 22rem;
        padding: 1rem;
    }

    .trip-hero__content h1 {
        font-size: 3rem;
    }

    .trip-info {
        gap: 1.5rem 1rem;
        padding: 2rem 0.5rem;
    }

    .trip-places {
        padding: 2.5rem 0.5rem 0;
    }

    .trip-places h2 {
        font-size: 2rem;
    }

    .grid {
        grid-template-columns: 1fr;
    }
}
</style>
