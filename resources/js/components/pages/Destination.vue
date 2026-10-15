<template>
    <main class="place">
        <transition name="toast">
            <div v-if="toast" class="toast" role="alert">
                <span>{{ $t('destination.registerToAdd') }}</span>
                <router-link to="/register">{{ $t('destination.register') }}</router-link>
            </div>
        </transition>

        <div class="place__inner">
            <router-link to="/discover" class="place__back">
                <svg
                    width="30"
                    height="8"
                    viewBox="0 0 30 8"
                    aria-hidden="true"
                >
                    <path
                        d="M30 4H1M4 1L1 4l3 3"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="0.8"
                    />
                </svg>
                {{ $t('common.backToDiscover') }}
            </router-link>

            <p v-if="loading" class="place__missing">
                {{ $t('destination.loading') }}
            </p>

            <p v-else-if="error" class="place__missing">
                {{ $t(error) }}
            </p>

            <template v-else-if="place">
                <header class="place__head">
                    <div>
                        <h1>{{ place.title }}</h1>

                        <p class="place__where">
                            {{ place.city }}
                            <span v-if="place.city && place.country">, </span>
                            {{ place.country }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="place__add"
                        :class="{ 'place__add--on': added }"
                        :disabled="added"
                        @click="addToList"
                    >
                        {{ added ? $t('destination.inList') : $t('destination.addToList') }}
                    </button>
                </header>

                <p v-if="added" class="place__in">
                    {{ $t('destination.inTrips', { trips: inTrips.map(trip => trip.title).join(', ') }) }}
                </p>

                <form v-if="picker" class="picker" @submit.prevent="confirmAdd">
                    <fieldset class="picker__options">
                        <legend>{{ $t('destination.chooseTrip') }}</legend>

                        <label v-for="trip in trips" :key="trip.id" class="picker__option">
                            <input v-model="selectedTrip" type="radio" name="trip" :value="trip.id">
                            <span>{{ trip.title }}</span>
                        </label>

                        <label class="picker__option">
                            <input v-model="selectedTrip" type="radio" name="trip" value="new">
                            <span>{{ $t('add.newTrip') }}</span>
                        </label>
                    </fieldset>

                    <label v-if="selectedTrip === 'new'" class="picker__field">
                        <span>{{ $t('common.tripName') }}</span>
                        <input
                            v-model.trim="newTripTitle"
                            type="text"
                            maxlength="255"
                            :placeholder="$t('common.tripNamePlaceholder')"
                        >
                    </label>

                    <p v-if="pickerError" class="picker__error" role="alert">
                        {{ pickerError }}
                    </p>

                    <div class="picker__actions">
                        <button type="submit" class="picker__save" :disabled="saving">
                            {{ saving ? $t('common.saving') : $t('destination.addHere') }}
                        </button>

                        <button type="button" class="picker__cancel" @click="picker = false">
                            {{ $t('common.cancel') }}
                        </button>
                    </div>
                </form>

                <img
                    class="place__img"
                    :src="place.image"
                    :alt="place.title"
                    @error="handleImageError"
                >

                <p class="place__desc">
                    {{ place.description || $t('destination.noDescription') }}
                </p>

                <h2 class="place__sub">{{ $t('destination.basicInfo') }}</h2>

                <dl class="info">
                    <div class="info__row">
                        <dt>{{ $t('common.country') }}</dt>
                        <dd>{{ place.country || '—' }}</dd>
                    </div>

                    <div class="info__row">
                        <dt>{{ $t('common.city') }}</dt>
                        <dd>{{ place.city || '—' }}</dd>
                    </div>

                    <div class="info__row">
                        <dt>{{ $t('common.category') }}</dt>
                        <dd>{{ place.category ? $t(`categories.${place.category}`) : '—' }}</dd>
                    </div>
                </dl>

                <p v-if="!added" class="place__hint">
                    {{ $t('destination.hint') }}
                </p>
            </template>

            <p v-else class="place__missing">
                {{ $t('destination.notFound') }}
            </p>
        </div>
    </main>
</template>

<script>
import axios from 'axios'
import { auth } from '../../auth.js'

export default {
    data() {
        return {
            place: null,
            loading: false,
            error: '',
            toast: false,

            // Lietotāja ceļojumi (no GET /api/user/trips)
            trips: [],
            picker: false,
            selectedTrip: '',
            newTripTitle: '',
            pickerError: '',
            saving: false
        }
    },

    computed: {
        isLoggedIn() {
            return Boolean(auth.user)
        },

        // Ceļojumi, kuros šis galamērķis jau ir
        inTrips() {
            if (!this.place) return []

            return this.trips.filter(trip =>
                (trip.trip_destinations || []).some(item =>
                    Number(item.destination_id) === Number(this.place.id)
                )
            )
        },

        added() {
            return this.inTrips.length > 0
        }
    },

    mounted() {
        this.fetchDestination()
    },

    watch: {
        '$route.params.id'() {
            this.toast = false
            this.picker = false
            this.fetchDestination()
        },

        isLoggedIn: {
            immediate: true,
            handler(loggedIn) {
                if (loggedIn) {
                    this.loadTrips()
                } else {
                    this.trips = []
                    this.picker = false
                }
            }
        }
    },

    methods: {
        async fetchDestination() {
            this.loading = true
            this.error = ''
            this.place = null

            try {
                const response = await axios.get(
                    `/api/trip/destinations/${this.$route.params.id}`
                )

                const data = response.data
                const destination = data.destination || {}
                const location = destination.place || {}
                const country = location.country || {}
                const trip = data.trip || {}

                const destinationId =
                    destination.id ||
                    data.destination_id ||
                    data.id ||
                    this.$route.params.id

                this.place = {
                    id: destinationId,

                    title:
                        destination.title ||
                        destination.name ||
                        location.name ||
                        'Travel destination',

                    city: location.name || '',

                    country: country.name || '',

                    category: trip.category || destination.category || '',

                    description:
                        destination.description ||
                        location.description ||
                        trip.description ||
                        '',

                    image:
                        destination.image ||
                        location.image ||
                        trip.image ||
                        `https://picsum.photos/seed/destination-${destinationId}/1200/600`
                }
            } catch (error) {
                console.error(
                    'Failed to load destination:',
                    error.response?.data || error.message
                )

                this.error =
                    error.response?.status === 404
                        ? 'destination.notFound'
                        : 'destination.loadError'
            } finally {
                this.loading = false
            }
        },

        handleImageError(event) {
            const fallback =
                `https://picsum.photos/seed/fallback-${this.place?.id || 'travel'}/1200/600`

            if (event.target.src !== fallback) {
                event.target.src = fallback
            }
        },

        getAuthConfig() {
            const token = localStorage.getItem('token')

            if (!token) {
                throw new Error('AUTH_REQUIRED')
            }

            return {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }
        },

        async loadTrips() {
            try {
                const { data } = await axios.get('/api/user/trips', this.getAuthConfig())

                this.trips = Array.isArray(data) ? data : (data.data || [])
            } catch (error) {
                console.error(
                    'Failed to load trips:',
                    error.response?.data || error.message
                )

                this.trips = []
            }
        },

        // Atver ceļojuma izvēli
        addToList() {
            if (!this.isLoggedIn) {
                this.toast = true
                return
            }

            this.pickerError = ''
            this.newTripTitle = ''
            this.selectedTrip = this.trips[0]?.id ?? 'new'
            this.picker = true
        },

        // Pievieno galamērķi izvēlētajam (vai jaunam) ceļojumam
        async confirmAdd() {
            this.pickerError = ''

            if (this.selectedTrip === 'new' && !this.newTripTitle) {
                this.pickerError = this.$t('add.tripNameError')
                return
            }

            this.saving = true

            try {
                const config = this.getAuthConfig()
                let tripId = this.selectedTrip

                if (tripId === 'new') {
                    const { data } = await axios.post(
                        '/api/trips',
                        { title: this.newTripTitle },
                        config
                    )

                    tripId = data.trip.id
                }

                await axios.post(
                    '/api/trip-destinations',
                    {
                        trip_id: tripId,
                        destination_id: this.place.id
                    },
                    config
                )

                await this.loadTrips()
                this.picker = false
            } catch (error) {
                console.error(
                    'Failed to add destination:',
                    error.response?.data || error.message
                )

                this.pickerError =
                    error.message === 'AUTH_REQUIRED' || error.response?.status === 401
                        ? this.$t('common.pleaseLogInAgain')
                        : error.response?.data?.message || this.$t('destination.addFailed')
            } finally {
                this.saving = false
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

.place__in {
    margin: -2rem 0 2.5rem;
    font-size: 0.8rem;
    text-align: right;
    color: var(--muted);
}

/* ---------- Trip picker ---------- */
.picker {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin: -1.5rem 0 3.5rem auto;
    max-width: 30rem;
    padding: 1.8rem 2rem;
    border: 1px solid #000;
    border-radius: 1rem;
}

.picker__options {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    margin: 0;
    padding: 0;
    border: 0;
}

.picker__options legend {
    margin-bottom: 1rem;
    font-family: var(--serif);
    font-size: 1.2rem;
    letter-spacing: 0.04em;
}

.picker__option {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 0.85rem;
    cursor: pointer;
}

.picker__option input {
    accent-color: #000;
}

.picker__field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.picker__field span {
    font-size: 0.7rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

.picker__field input {
    padding: 0.6rem 0;
    border: 0;
    border-bottom: 1px solid #767676;
    background: transparent;
    font: inherit;
    font-size: 0.9rem;
    text-transform: uppercase;
    outline: none;
}

.picker__field input:focus {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.picker__error {
    margin: 0;
    font-size: 0.75rem;
    color: #c0392b;
}

.picker__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem 1.5rem;
}

.picker__save {
    padding: 0.9rem 2.2rem;
    border: 0;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.8rem;
    font-weight: 400;
    text-transform: uppercase;
    cursor: pointer;
}

.picker__save:disabled {
    opacity: 0.6;
    cursor: default;
}

.picker__cancel {
    padding: 0.3rem 0;
    border: 0;
    border-bottom: 1px solid #000;
    background: none;
    font: inherit;
    font-size: 0.75rem;
    text-transform: uppercase;
    cursor: pointer;
}

.picker button:focus-visible,
.picker input:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
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

.place__add:disabled {
    cursor: default;
}

.toast {
    position: fixed;
    top: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 1.8rem;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 400;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
}

.toast a {
    color: #8cc4f0;
    text-decoration: underline;
    text-underline-offset: 3px;
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translate(-50%, -1rem);
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