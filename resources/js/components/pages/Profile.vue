<template>
    <main class="profile">
        <transition name="toast">
            <div v-if="toast" class="toast" role="status">{{ toast }}</div>
        </transition>

        <header class="profile__hero">
            <p>Your saved places, your visited ones, and everything about your account in one place.</p>
            <h1>PROFILE</h1>
        </header>

        <section class="user">
            <div class="user__info">
                <div class="user__avatar" aria-hidden="true">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7" />
                    </svg>
                </div>

                <div>
                    <h2>{{ username || 'YOUR NAME' }}</h2>
                    <p>{{ user?.email || 'you@example.com' }}</p>
                    <p v-if="memberSince">MEMBER SINCE {{ memberSince }}</p>
                </div>
            </div>

            <div class="stats">
                <div>
                    <strong>{{ saved.length }}</strong>
                    <span>SAVED PLACES</span>
                </div>
                <div>
                    <strong>{{ visitedCount }}</strong>
                    <span>VISITED</span>
                </div>
                <div>
                    <strong>{{ countriesCount }}</strong>
                    <span>COUNTRIES</span>
                </div>
            </div>
        </section>

        <section class="mine">
            <div class="mine__head">
                <h2>MY TRIPS</h2>

                <div class="mine__tools">
                    <div class="tabs" role="tablist">
                        <button
                            v-for="tab in tabs"
                            :key="tab.value"
                            type="button"
                            role="tab"
                            class="tabs__item"
                            :class="{ 'tabs__item--on': filter === tab.value }"
                            :aria-selected="filter === tab.value"
                            @click="filter = tab.value"
                        >
                            {{ tab.label }}
                        </button>
                    </div>

                    <button type="button" class="mine__add" @click="openModal">+ ADD TRIP</button>
                </div>
            </div>

            <p v-if="loadingTrips" class="mine__empty">LOADING…</p>
            <p v-else-if="!trips.length" class="mine__empty">
                YOU HAVE NO TRIPS YET. CLICK “ADD TRIP” TO CREATE YOUR FIRST ONE.
            </p>

            <article v-for="trip in trips" :key="trip.id" class="trip">
                <header class="trip__head">
                    <h3>{{ trip.name }}</h3>
                    <span>{{ (trip.destinations || []).length }} PLACES</span>
                </header>
                <p v-if="trip.description" class="trip__desc">{{ trip.description }}</p>

                <ul v-if="visibleDestinations(trip).length" class="grid">
                    <li v-for="place in visibleDestinations(trip)" :key="place.id">
                        <router-link
                            :to="`/destination/${place.id}`"
                            class="card"
                            :style="{ backgroundImage: `url('${place.image}')` }"
                        >
                            <span class="card__badge" :class="{ 'card__badge--dark': place.status === 'visited' }">
                                {{ place.status === 'visited' ? 'VISITED' : 'WANT TO VISIT' }}
                            </span>
                            <span class="card__name">{{ place.name }}</span>
                        </router-link>
                    </li>
                </ul>

                <p v-else class="trip__empty">
                    NO PLACES HERE YET.
                    <router-link to="/discover">BROWSE DESTINATIONS</router-link>
                </p>
            </article>
        </section>

        <section class="account">
            <div class="account__intro">
                <h2>ACCOUNT<br>DETAILS</h2>
                <p>KEEP YOUR DETAILS UP TO DATE SO YOUR LIST IS ALWAYS YOURS.</p>
            </div>

            <form class="account__form" @submit.prevent="saveChanges">
                <label class="field">
                    <span>FULL NAME</span>
                    <input :value="username" type="text" placeholder="YOUR NAME" readonly>
                </label>

                <label class="field">
                    <span>EMAIL</span>
                    <input v-model.trim="form.email" type="email" placeholder="YOU@EXAMPLE.COM" autocomplete="email">
                    <small v-if="errors.email">{{ errors.email[0] }}</small>
                </label>

                <label class="field">
                    <span>NEW PASSWORD</span>
                    <input v-model="form.password" type="password" placeholder="**********" autocomplete="new-password">
                    <small v-if="errors.password">{{ errors.password[0] }}</small>
                </label>

                <label v-if="form.password" class="field">
                    <span>CURRENT PASSWORD</span>
                    <input v-model="form.current_password" type="password" autocomplete="current-password">
                    <small v-if="errors.current_password">{{ errors.current_password[0] }}</small>
                </label>

                <div class="account__actions">
                    <button type="submit" class="account__save" :disabled="saving">
                        {{ saving ? 'SAVING...' : 'SAVE CHANGES' }}
                    </button>
                    <button type="button" class="account__delete" @click="deleteAccount">DELETE ACCOUNT</button>
                </div>
            </form>
        </section>

        <transition name="fade">
            <div v-if="modal" class="modal" @click.self="closeModal" @keydown.esc="closeModal">
                <form
                    class="modal__box"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="trip-title"
                    @submit.prevent="createTrip"
                >
                    <h2 id="trip-title">NEW TRIP</h2>

                    <label class="field">
                        <span>NAME</span>
                        <input
                            ref="tripName"
                            v-model.trim="tripForm.name"
                            type="text"
                            maxlength="100"
                            placeholder="E.G. SUMMER IN NORWAY"
                        >
                        <small v-if="tripErrors.name">{{ tripErrors.name[0] }}</small>
                    </label>

                    <label class="field">
                        <span>DESCRIPTION</span>
                        <textarea
                            v-model.trim="tripForm.description"
                            rows="4"
                            placeholder="WHAT IS THIS TRIP ABOUT?"
                        />
                        <small v-if="tripErrors.description">{{ tripErrors.description[0] }}</small>
                    </label>

                    <div class="account__actions">
                        <button type="submit" class="account__save" :disabled="creating">
                            {{ creating ? 'SAVING...' : 'CREATE TRIP' }}
                        </button>
                        <button type="button" class="account__delete" @click="closeModal">CANCEL</button>
                    </div>
                </form>
            </div>
        </transition>
    </main>
</template>

<script>
import axios from 'axios'
import { auth } from '../../auth.js'

export default {
    data() {
        return {
            user: null,

            filter: 'all',

            tabs: [
                { value: 'all', label: 'ALL' },
                { value: 'not_visited', label: 'WANT TO VISIT' },
                { value: 'visited', label: 'VISITED' }
            ],

            // Trips + destinations inside them come from GET /api/user/trips
            trips: [],
            loadingTrips: true,

            modal: false,
            creating: false,
            tripForm: { name: '', description: '' },
            tripErrors: {},

            form: {
                email: '',
                password: '',
                current_password: ''
            },

            errors: {},
            saving: false,
            toast: '',
            toastTimer: null
        }
    },

    computed: {
        username() {
            return this.user?.username
                || this.user?.Username
                || ''
        },

        memberSince() {
            if (!this.user?.created_at) return ''

            const date = new Date(this.user.created_at)

            return Number.isNaN(date.getTime())
                ? ''
                : date.getFullYear()
        },

        // all places from all trips, without duplicates
        saved() {
            const unique = new Map()

            this.trips.forEach((trip) => {
                (trip.destinations || []).forEach((place) => unique.set(place.id, place))
            })

            return [...unique.values()]
        },

        visitedCount() {
            return this.saved.filter(
                place => place.status === 'visited'
            ).length
        },

        countriesCount() {
            return new Set(
                this.saved.map(place => place.country)
            ).size
        }
    },

    async mounted() {
        await Promise.all([this.loadProfile(), this.loadTrips()])
    },

    methods: {
        async loadProfile() {
            try {
                const { data } = await axios.get('/api/profile', {
                    withCredentials: true
                })

                this.user = data.user || null
                this.form.email = data.user?.email || ''
            } catch (error) {
                console.error(
                    'Neizdevās ielādēt profilu:',
                    error.response?.data || error.message
                )

                this.showToast('FAILED TO LOAD PROFILE')
            }
        },

        async loadTrips() {
            this.loadingTrips = true

            try {
                const { data } = await axios.get('/api/user/trips', {
                    withCredentials: true
                })

                this.trips = Array.isArray(data) ? data : (data.trips || [])
            } catch (error) {
                console.error(
                    'Neizdevās ielādēt trips:',
                    error.response?.data || error.message
                )

                this.showToast('FAILED TO LOAD TRIPS')
            } finally {
                this.loadingTrips = false
            }
        },

        visibleDestinations(trip) {
            const places = trip.destinations || []

            return this.filter === 'all'
                ? places
                : places.filter(place => place.status === this.filter)
        },

        openModal() {
            this.tripForm = { name: '', description: '' }
            this.tripErrors = {}
            this.modal = true
            this.$nextTick(() => this.$refs.tripName?.focus())
        },

        closeModal() {
            this.modal = false
        },

        async createTrip() {
            if (this.creating) return

            this.tripErrors = {}

            if (!this.tripForm.name) {
                this.tripErrors = { name: ['This field is required.'] }
                return
            }

            this.creating = true

            try {
                await axios.post('/api/user/trips', {
                    name: this.tripForm.name,
                    description: this.tripForm.description
                }, {
                    withCredentials: true
                })

                this.closeModal()
                await this.loadTrips()
                this.showToast('TRIP CREATED')
            } catch (error) {
                console.error(
                    'Neizdevās izveidot trip:',
                    error.response?.data || error.message
                )

                this.tripErrors = error.response?.data?.errors || {}

                if (error.response?.status === 401) {
                    this.showToast('PLEASE LOG IN AGAIN')
                } else if (Object.keys(this.tripErrors).length === 0) {
                    this.showToast('FAILED TO CREATE TRIP')
                }
            } finally {
                this.creating = false
            }
        },

        async saveChanges() {
            if (this.saving) return

            this.errors = {}
            this.saving = true

            try {
                // Atjaunojam e-pastu tikai tad, ja tas ir mainīts.
                if (
                    this.form.email !== this.user?.email
                    && this.form.email
                ) {
                    const { data } = await axios.put(
                        '/api/profile/email',
                        {
                            email: this.form.email
                        },
                        {
                            withCredentials: true
                        }
                    )

                    if (data.user) {
                        this.user = data.user
                    } else if (this.user) {
                        this.user.email = this.form.email
                    }
                }

                // Paroli mainām tikai tad, ja ievadīta jauna parole.
                if (this.form.password) {
                    await axios.put(
                        '/api/profile/password',
                        {
                            current_password:
                                this.form.current_password,
                            password: this.form.password,
                            password_confirmation:
                                this.form.password
                        },
                        {
                            withCredentials: true
                        }
                    )

                    this.form.password = ''
                    this.form.current_password = ''
                }

                this.showToast('CHANGES SAVED')
            } catch (error) {
                console.error(
                    'Neizdevās saglabāt izmaiņas:',
                    error.response?.data || error.message
                )

                this.errors =
                    error.response?.data?.errors || {}

                if (error.response?.status === 401) {
                    this.showToast('PLEASE LOG IN AGAIN')
                } else if (Object.keys(this.errors).length === 0) {
                    this.showToast('FAILED TO SAVE CHANGES')
                }
            } finally {
                this.saving = false
            }
        },

        async deleteAccount() {
            const confirmed = window.confirm(
                'Delete your account? This cannot be undone.'
            )

            if (!confirmed) return

            try {
                await axios.delete('/api/profile', {
                    withCredentials: true
                })

                auth.user = null

                await this.$router.push('/')
            } catch (error) {
                console.error(
                    'Neizdevās dzēst kontu:',
                    error.response?.data || error.message
                )

                this.showToast('FAILED TO DELETE ACCOUNT')
            }
        },

        showToast(message) {
            this.toast = message

            if (this.toastTimer) {
                clearTimeout(this.toastTimer)
            }

            this.toastTimer = setTimeout(() => {
                this.toast = ''
                this.toastTimer = null
            }, 2500)
        }
    },

    beforeUnmount() {
        if (this.toastTimer) {
            clearTimeout(this.toastTimer)
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.profile {
    --muted: #555;
    --link: #5aa9e6;
    --serif: 'Italiana', serif;

    padding: 0 0.6rem 6rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.profile h1,
.profile h2,
.profile h3 {
    margin: 0;
    font-family: var(--serif);
    font-weight: 400;
}

.profile a {
    color: inherit;
    text-decoration: none;
}

.profile a:focus-visible,
.profile button:focus-visible,
.profile input:focus-visible,
.profile textarea:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

/* ---------- Hero ---------- */
.profile__hero {
    position: relative;
    height: 21rem;
    border-radius: 1.2rem;
    overflow: hidden;
    color: #fff;
    background:
        linear-gradient(rgba(0, 0, 0, 0.28), rgba(0, 0, 0, 0.28)),
        #3b4a3a url('/image/profile-hero.jpg') center / cover no-repeat;
}

.profile__hero p {
    position: absolute;
    top: 1.8rem;
    left: 1.5rem;
    margin: 0;
    max-width: 21rem;
    font-size: 0.95rem;
    line-height: 1.35;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.35);
}

.profile__hero h1 {
    position: absolute;
    left: 1.5rem;
    bottom: -0.4rem;
    font-size: clamp(3.5rem, 11vw, 9.5rem);
    line-height: 1;
    letter-spacing: 0.02em;
}

/* ---------- User ---------- */
.user {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 2rem 3rem;
    padding: 3rem 1rem;
    border-bottom: 1px solid #bdbdbd;
}

.user__info {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.user__avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: none;
    width: 6.5rem;
    height: 6.5rem;
    border: 1px solid #000;
    border-radius: 50%;
}

.user h2 {
    margin-bottom: 0.4rem;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    line-height: 1.1;
    text-transform: uppercase;
}

.user p {
    margin: 0.3rem 0 0;
    font-size: 0.8rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: var(--muted);
}

.stats {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem 3.5rem;
}

.stats div {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.stats strong {
    font-weight: 400;
    font-family: var(--serif);
    font-size: 3.3rem;
    line-height: 1;
}

.stats span {
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

/* ---------- My trips ---------- */
.mine {
    padding: 3.5rem 1rem 0;
}

.mine__head {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem 2rem;
    margin-bottom: 1.8rem;
}

.mine__head h2 {
    font-size: 1.65rem;
}

.mine__tools {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem 2rem;
}

.mine__add {
    padding: 0.8rem 1.8rem;
    border: 0;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.75rem;
    font-weight: 400;
    letter-spacing: 0.06em;
    cursor: pointer;
    transition: background 0.2s;
}

.mine__add:hover {
    background: #222;
}

.mine__empty,
.trip__empty {
    margin: 1.5rem 0;
    font-size: 0.8rem;
    color: var(--muted);
}

.trip__empty a {
    margin-left: 0.5rem;
    color: var(--link);
    text-decoration: underline;
    text-underline-offset: 3px;
}

.tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem 1.75rem;
}

.tabs__item {
    padding: 0.75rem 0;
    border: 0;
    border-bottom: 1px solid transparent;
    background: none;
    font-family: var(--serif);
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    color: var(--muted);
    cursor: pointer;
}

.tabs__item--on {
    border-bottom-color: #000;
    color: #000;
}

.trip {
    margin-bottom: 3.5rem;
}

.trip__head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 1rem;
    padding-bottom: 0.8rem;
    border-bottom: 1px solid #bdbdbd;
}

.trip__head h3 {
    font-size: 1.6rem;
    letter-spacing: 0.03em;
}

.trip__head span {
    font-size: 0.7rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

.trip__desc {
    max-width: 40rem;
    margin: 1rem 0 1.5rem;
    font-size: 0.85rem;
    line-height: 1.45;
    text-transform: uppercase;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
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
    border-radius: 1rem;
    background: #6b7a63 center / cover no-repeat;
    color: #fff;
    transition: transform 0.25s;
}

.card:hover {
    transform: translateY(-4px);
}

.card::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: linear-gradient(transparent 50%, rgba(0, 0, 0, 0.45));
}

.card__name {
    position: relative;
    color: #fff;
    font-family: var(--serif);
    font-size: 1.1rem;
    letter-spacing: 0.03em;
    text-shadow: 0 1px 10px rgba(0, 0, 0, 0.5);
}

.card__badge {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    padding: 0.3rem 0.75rem;
    border-radius: 999px;
    background: #fff;
    color: #000;
    font-size: 0.7rem;
    font-weight: 400;
    letter-spacing: 0.06em;
}

.card__badge--dark {
    background: #000;
    color: #fff;
}

/* ---------- Account details ---------- */
.account {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem 5rem;
    padding: 5rem 1rem 0;
}

.account__intro {
    flex: 1 1 18rem;
    max-width: 26rem;
}

.account__intro h2 {
    margin-bottom: 0.9rem;
    font-size: clamp(2.2rem, 4vw, 2.9rem);
    line-height: 1.1;
}

.account__intro p {
    margin: 0;
    max-width: 15rem;
    font-size: 0.8rem;
    line-height: 1.4;
}

.account__form {
    flex: 1 1 22rem;
    max-width: 39rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.field span {
    font-size: 0.7rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

.field input,
.field textarea {
    padding: 0.75rem 0;
    border: 0;
    border-bottom: 1px solid #767676;
    border-radius: 0;
    background: transparent;
    font: inherit;
    font-size: 0.9rem;
    color: #000;
    outline: none;
}

.field textarea {
    resize: vertical;
}

.field input::placeholder,
.field textarea::placeholder {
    color: #767676;
}

.field input:focus,
.field textarea:focus {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.field input[readonly] {
    color: var(--muted);
}

.field small {
    font-size: 0.7rem;
    color: #c0392b;
}

.account__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem 1.75rem;
    margin-top: 0.5rem;
}

.account__save {
    min-height: 3.25rem;
    padding: 0 3.5rem;
    border: 0;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.8rem;
    font-weight: 400;
    letter-spacing: 0.06em;
    cursor: pointer;
    transition: background 0.2s;
}

.account__save:hover {
    background: #222;
}

.account__save:disabled {
    cursor: default;
    opacity: 0.6;
}

.account__delete {
    padding: 0.85rem 0;
    border: 0;
    border-bottom: 1px solid #000;
    background: none;
    font: inherit;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    color: #000;
    cursor: pointer;
}

/* ---------- Modal ---------- */
.modal {
    position: fixed;
    inset: 0;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    background: rgba(0, 0, 0, 0.45);
}

.modal__box {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    width: 100%;
    max-width: 30rem;
    padding: 2.5rem 2.2rem;
    border-radius: 1.2rem;
    background: #fff;
}

.modal__box h2 {
    font-size: 2rem;
    letter-spacing: 0.04em;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* ---------- Toast ---------- */
.toast {
    position: fixed;
    top: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 30;
    padding: 1rem 1.8rem;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font-size: 0.8rem;
    font-weight: 400;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
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
    .profile__hero {
        height: 16rem;
    }

    .user {
        padding: 2rem 0.5rem;
    }

    .user__avatar {
        width: 4.5rem;
        height: 4.5rem;
    }

    .stats {
        gap: 1.5rem 2rem;
    }

    .stats strong {
        font-size: 2.5rem;
    }

    .mine,
    .account {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .account {
        padding-top: 3.5rem;
    }

    .modal__box {
        padding: 2rem 1.5rem;
    }
}
</style>