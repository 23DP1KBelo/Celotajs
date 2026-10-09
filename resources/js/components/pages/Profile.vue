<template>
    <main class="profile">
        <transition name="toast">
            <div v-if="toast" class="toast" role="status">
                {{ toast }}
            </div>
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
            <!-- <div class="stats">
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
            </div> -->
        </section>
        <section class="mine">
            <div class="mine__head">
                <h2>MY TRIPS</h2>
                <div class="mine__tools">
                    <div class="tabs" role="tablist">
                        <button v-for="tab in tabs" :key="tab.value" type="button" role="tab" class="tabs__item" :class="{ 'tabs__item--on': filter === tab.value }" :aria-selected="filter === tab.value" @click="filter = tab.value">{{ tab.label }}</button>
                    </div>
                    <button type="button" class="mine__add" @click="openModal">+ ADD TRIP</button>
                </div>
            </div>
            <p v-if="loadingTrips" class="mine__empty">LOADING…</p>
            <p v-else-if="!filteredTrips.length" class="mine__empty">NO TRIPS FOUND. CLICK “ADD TRIP” TO CREATE YOUR FIRST ONE.</p>
            <ul v-else class="grid trip-grid">
                <li v-for="trip in filteredTrips" :key="trip.id">
                    <article class="card trip-card" :style="{ backgroundImage: trip.image ? `linear-gradient(transparent 45%,rgba(0,0,0,.5)),url('${trip.image}')` : 'linear-gradient(180deg,#75816c 55%,#394638)' }">
                        <span class="card__badge" :class="{ 'card__badge--dark': trip.status === 'visited' }">{{ trip.status === 'visited' ? 'VISITED' : 'WANT TO VISIT' }}</span>
                        <span class="card__name">{{ trip.title || trip.name }}</span>
                    </article>
                </li>
            </ul>
        </section>
        <section class="account">
            <div class="account__intro">
                <h2>ACCOUNT<br>DETAILS</h2>
                <p>KEEP YOUR DETAILS UP TO DATE SO YOUR LIST IS ALWAYS YOURS.</p>
            </div>
            <form class="account__form" @submit.prevent="saveChanges">
                <label class="field">
                    <span>FULL NAME</span>
                    <input
                        :value="username"
                        type="text"
                        placeholder="YOUR NAME"
                        readonly
                    >
                </label>
                <label class="field">
                    <span>EMAIL</span>
                    <input
                        v-model.trim="form.email"
                        type="email"
                        placeholder="YOU@EXAMPLE.COM"
                        autocomplete="email"
                    >
                    <small v-if="errors.email">
                        {{ errors.email[0] }}
                    </small>
                </label>
                <label class="field">
                    <span>NEW PASSWORD</span>
                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="Leave empty to keep current password"
                        autocomplete="new-password"
                    >
                    <small v-if="errors.password">
                        {{ errors.password[0] }}
                    </small>
                </label>
                <label v-if="form.password" class="field">
                    <span>CURRENT PASSWORD</span>
                    <input
                        v-model="form.current_password"
                        type="password"
                        placeholder="CURRENT PASSWORD"
                        autocomplete="current-password"
                    >
                    <small v-if="errors.current_password">
                        {{ errors.current_password[0] }}
                    </small>
                </label>
                <div class="account__actions">
                    <button
                        type="submit"
                        class="account__save"
                        :disabled="saving"
                    >
                        {{ saving ? 'SAVING...' : 'SAVE CHANGES' }}
                    </button>

                    <button
                        type="button"
                        class="account__delete"
                        :disabled="saving"
                        @click="deleteAccount"
                    >
                        DELETE ACCOUNT
                    </button>
                </div>
            </form>
        </section>
        <transition name="fade">
            <div
                v-if="modal"
                class="modal"
                @click.self="closeModal"
                @keydown.esc="closeModal"
            >
                <form
                    class="modal__box"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="trip-title"
                    @submit.prevent="createTrip"
                >
                    <div class="trip-stepper" aria-label="Trip creation progress">
                        <span v-for="number in 3" :key="number"
                              class="trip-stepper__item"
                              :class="{ 'trip-stepper__item--active': step === number, 'trip-stepper__item--done': step > number }">
                            0{{ number }}
                        </span>
                    </div>
                    <p class="trip-form__eyebrow">STEP 0{{ step }} / 03</p>
                    <h2 id="trip-title">
                        {{ step === 1 ? 'TRIP DETAILS' : step === 2 ? 'DATES & CATEGORY' : 'REVIEW & CONFIRM' }}
                    </h2>
                    <div v-if="step === 1" class="form-step">
                        <label class="field">
                            <span>TRIP NAME *</span>
                            <input
                                ref="tripName"
                                v-model.trim="tripForm.title"
                                type="text"
                                maxlength="255"
                                placeholder="E.G. SUMMER IN NORWAY"
                                required
                            >
                            <small v-if="tripErrors.title">{{ tripErrors.title[0] }}</small>
                        </label>
                        <label class="field">
                            <span>DESCRIPTION</span>
                            <textarea
                                v-model.trim="tripForm.description"
                                rows="4"
                                placeholder="WHAT IS THIS TRIP ABOUT?"
                            ></textarea>
                            <small v-if="tripErrors.description">{{ tripErrors.description[0] }}</small>
                        </label>
                    </div>
                    <div v-else-if="step === 2" class="form-step">
                        <div class="trip-form__row">
                            <label class="field">
                                <span>DATE FROM *</span>
                                <input v-model="tripForm.date_from" type="date" required>
                                <small v-if="tripErrors.date_from">{{ tripErrors.date_from[0] }}</small>
                            </label>
                            <label class="field">
                                <span>DATE TILL *</span>
                                <input
                                    v-model="tripForm.date_till"
                                    type="date"
                                    :min="tripForm.date_from || undefined"
                                    required
                                >
                                <small v-if="tripErrors.date_till">{{ tripErrors.date_till[0] }}</small>
                            </label>
                        </div>
                        <label class="field">
                            <span>BUDGET (€)</span>
                            <input
                                v-model="tripForm.budget"
                                type="number"
                                min="0"
                                step="0.01"
                                placeholder="E.G. 500"
                            >
                            <small v-if="tripErrors.budget">{{ tripErrors.budget[0] }}</small>
                        </label>
                        <label class="field">
                            <span>STATUS *</span>
                            <select v-model="tripForm.status" required>
                                <option value="unvisited">WANT TO VISIT</option>
                                <option value="visited">VISITED</option>
                            </select>
                            <small v-if="tripErrors.status">{{ tripErrors.status[0] }}</small>
                        </label>
                        <label class="field">
                            <span>KATEGORIJA</span>
                            <select v-model="tripForm.category">
                                <option value="">IZVĒLIES KATEGORIJU</option>
                                <option value="nature">DABA</option>
                                <option value="adventure">IZKLAIDE</option>
                                <option value="rest">ATPŪTA</option>
                            </select>
                            <small v-if="tripErrors.category">
                                {{ tripErrors.category[0] }}
                            </small>
                        </label>
                    </div>
                    <div v-else class="form-step">
                        <label class="field">
                            <span>TRIP PHOTO (JPG, PNG · MAX 2 MB)</span>
                            <input type="file" accept=".jpg,.jpeg,.png" @change="onTripImageChange">
                            <small v-if="tripErrors.image">{{ tripErrors.image[0] }}</small>
                        </label>
                        <div class="trip-review">
                            <p class="trip-review__label">TRIP NAME</p>
                            <p class="trip-review__value">{{ tripForm.title || '—' }}</p>
                            <p class="trip-review__label">DATES</p>
                            <p class="trip-review__value">
                                {{ tripForm.date_from || '—' }} — {{ tripForm.date_till || '—' }}
                            </p>
                            <p class="trip-review__label">BUDGET</p>
                            <p class="trip-review__value">
                                {{ tripForm.budget !== '' ? `€${tripForm.budget}` : 'Not specified' }}
                            </p>
                            <p class="trip-review__label">CATEGORY</p>
                            <p class="trip-review__value">{{ tripForm.category ? tripForm.category.toUpperCase() : 'Not specified' }}</p>
                        </div>
                        <p v-if="tripErrors.user_id" class="field__error">
                            {{ tripErrors.user_id[0] }}
                        </p>
                        <p v-if="tripErrors.general" class="field__error">
                            {{ tripErrors.general[0] }}
                        </p>
                    </div>
                    <div class="trip-form__navigation">
                        <button
                            v-if="step > 1"
                            type="button"
                            class="trip-form__back"
                            @click="step--"
                        >
                            ← BACK
                        </button>
                        <button
                            type="button"
                            class="trip-form__cancel"
                            @click="closeModal"
                        >
                            CANCEL
                        </button>
                        <button
                            v-if="step < 3"
                            type="button"
                            class="account__save"
                            @click="nextTripStep"
                        >
                            CONTINUE →
                        </button>
                        <button
                            v-else
                            type="submit"
                            class="account__save"
                            :disabled="creating"
                        >
                            {{ creating ? 'SAVING...' : 'CONFIRM' }}
                        </button>
                    </div>
                </form>
            </div>
        </transition>
    </main>
</template>

<script>
import axios from 'axios'
import { auth, fetchUser } from '../../auth.js'

export default {
    data() {
        return {
            user: auth.user,
            filter: 'all',
            tabs: [
                { value: 'all', label: 'ALL' },
                { value: 'unvisited', label: 'WANT TO VISIT' },
                { value: 'visited', label: 'VISITED' }
            ],
            trips: [],
            loadingTrips: true,
            modal: false,
            creating: false,
            step: 1,
            tripForm: {
                title: '',
                description: '',
                date_from: '',
                date_till: '',
                budget: '',
                status: 'unvisited',
                category: ''
            },
            tripImage: null,
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
            return this.user?.username || this.user?.Username || ''
        },

        memberSince() {
            if (!this.user?.created_at) return ''

            const date = new Date(this.user.created_at)

            return Number.isNaN(date.getTime())
                ? ''
                : date.getFullYear()
        },

        saved() {
            const unique = new Map()

            this.trips.forEach(trip => {
                const destinations =
                    trip.destinations || trip.trip_destinations || []

                destinations.forEach(place => {
                    unique.set(place.id, place)
                })
            })

            return [...unique.values()]
        },

        filteredDestinations() {
            return this.saved.filter(place =>
                this.filter === 'all' ||
                place.status === this.filter ||
                (this.filter === 'unvisited' && place.status === 'not_visited')
            )
        },

        filteredTrips() {
            return this.trips.filter(trip =>
                this.filter === 'all' ||
                trip.status === this.filter ||
                (this.filter === 'unvisited' && trip.status === 'not_visited')
            )
        },

        visitedCount() {
            return this.saved.filter(place => place.status === 'visited').length
        },

        countriesCount() {
            return new Set(this.saved.map(place => place.country)).size
        }
    },

    async mounted() {
        try {
            await fetchUser()
            this.user = auth.user

            if (!this.user) {
                await this.$router.push('/login')
                return
            }

            this.form.email = this.user.email || ''
            await this.loadTrips()
        } catch (error) {
            console.error('Failed to load profile:', error)
            this.showToast('FAILED TO LOAD PROFILE')
        }
    },

    methods: {
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
            this.loadingTrips = true

            try {
                const { data } = await axios.get(
                    '/api/user/trips',
                    this.getAuthConfig()
                )

                const list = Array.isArray(data)
                    ? data
                    : Array.isArray(data.data)
                        ? data.data
                        : data.trips || []

                this.trips = list.map(trip => ({
                    ...trip,
                    date_from: trip.date_from || trip.date_form || '',
                    destinations:
                        trip.destinations || trip.trip_destinations || []
                }))
            } catch (error) {
                console.error(
                    'Failed to load trips:',
                    error.response?.data || error.message
                )

                if (
                    error.message === 'AUTH_REQUIRED' ||
                    error.response?.status === 401
                ) {
                    this.showToast('PLEASE LOG IN AGAIN')
                } else {
                    this.showToast('FAILED TO LOAD TRIPS')
                }
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
            this.step = 1

            this.tripForm = {
                title: '',
                description: '',
                date_from: '',
                date_till: '',
                budget: '',
                status: 'unvisited',
                category: ''
            }

            this.tripImage = null
            this.tripErrors = {}
            this.modal = true

            this.$nextTick(() => {
                this.$refs.tripName?.focus()
            })
        },

        closeModal() {
            this.modal = false
        },

        onTripImageChange(event) {
            const file = event.target.files?.[0] || null

            delete this.tripErrors.image
            this.tripImage = null

            if (!file) return

            const allowedTypes = ['image/jpeg', 'image/png']

            if (!allowedTypes.includes(file.type)) {
                event.target.value = ''
                this.tripErrors.image = [
                    'Attēlam jābūt JPG vai PNG formātā.'
                ]
                return
            }

            if (file.size > 2 * 1024 * 1024) {
                event.target.value = ''
                this.tripErrors.image = [
                    'Attēla izmērs nedrīkst pārsniegt 2 MB.'
                ]
                return
            }

            this.tripImage = file
        },

        nextTripStep() {
            this.tripErrors = {}

            if (this.step === 1) {
                if (!this.tripForm.title.trim()) {
                    this.tripErrors.title = [
                        'Ceļojuma nosaukums ir obligāts.'
                    ]
                    return
                }

                this.step = 2
                return
            }

            if (this.step === 2) {
                if (!this.tripForm.date_from) {
                    this.tripErrors.date_from = [
                        'Norādi ceļojuma sākuma datumu.'
                    ]
                    return
                }

                if (!this.tripForm.date_till) {
                    this.tripErrors.date_till = [
                        'Norādi ceļojuma beigu datumu.'
                    ]
                    return
                }

                if (this.tripForm.date_till <= this.tripForm.date_from) {
                    this.tripErrors.date_till = [
                        'Beigu datumam jābūt vēlākam par sākuma datumu.'
                    ]
                    return
                }

                if (
                    this.tripForm.budget !== '' &&
                    Number(this.tripForm.budget) < 0
                ) {
                    this.tripErrors.budget = [
                        'Budžets nedrīkst būt negatīvs.'
                    ]
                    return
                }

                this.step = 3
            }
        },

        async createTrip() {
            if (this.creating) return

            this.creating = true
            this.tripErrors = {}

            try {
                const formData = new FormData()

                // Saglabāts saderībai ar pašreizējo backend validāciju.
                // Drošāk ir user_id noteikt Laravel kontrolierī.
                formData.append('user_id', String(this.user.id))

                Object.entries(this.tripForm).forEach(([key, value]) => {
                    if (value !== '' && value !== null && value !== undefined) {
                        formData.append(key, String(value))
                    }
                })

                if (this.tripImage) {
                    formData.append('image', this.tripImage)
                }

                const response = await axios.post(
                    '/api/trips',
                    formData,
                    this.getAuthConfig()
                )

                console.log('Trip created:', response.data)

                this.closeModal()
                this.step = 1

                this.tripForm = {
                    title: '',
                    description: '',
                    date_from: '',
                    date_till: '',
                    budget: '',
                    status: 'unvisited',
                    category: ''
                }

                this.tripImage = null

                await this.loadTrips()
                this.showToast('TRIP CREATED')
            } catch (error) {
                console.error(
                    'Failed to create trip:',
                    error.response?.data || error.message
                )

                if (
                    error.message === 'AUTH_REQUIRED' ||
                    error.response?.status === 401
                ) {
                    this.showToast('PLEASE LOG IN AGAIN')
                    return
                }

                this.tripErrors = error.response?.data?.errors || {}

                this.tripErrors.general = [
                    error.response?.data?.message ||
                    'Neizdevās izveidot ceļojumu.'
                ]

                this.step = 3
            } finally {
                this.creating = false
            }
        },

        async saveChanges() {
            if (this.saving) return

            this.saving = true
            this.errors = {}

            try {
                const config = this.getAuthConfig()

                if (
                    this.form.email &&
                    this.form.email !== this.user?.email
                ) {
                    const { data } = await axios.put(
                        '/api/profile/email',
                        { email: this.form.email },
                        config
                    )

                    if (data.user) {
                        this.user = data.user
                        auth.user = data.user
                    } else if (this.user) {
                        this.user.email = this.form.email
                    }

                    this.form.email = this.user?.email || ''
                }
                if (this.form.password) {
                    await axios.put(
                        '/api/profile/password',
                        {
                            current_password: this.form.current_password,
                            password: this.form.password,
                            password_confirmation: this.form.password
                        },
                        config
                    )

                    this.form.password = ''
                    this.form.current_password = ''
                }

                this.showToast('CHANGES SAVED')
            } catch (error) {
                console.error(
                    'Failed to save changes:',
                    error.response?.data || error.message
                )

                if (
                    error.message === 'AUTH_REQUIRED' ||
                    error.response?.status === 401
                ) {
                    this.showToast('PLEASE LOG IN AGAIN')
                    await this.$router.push('/login')
                    return
                }

                this.errors = error.response?.data?.errors || {}

                if (error.response?.status === 422) {
                    this.showToast('PLEASE CHECK YOUR DETAILS')
                } else {
                    this.showToast('FAILED TO SAVE CHANGES')
                }
            } finally {
                this.saving = false
            }
        },

        async deleteAccount() {
            const confirmed = window.confirm(
                'Vai tiešām vēlies dzēst savu kontu? Šo darbību nevar atsaukt.'
            )

            if (!confirmed) return

            try {
                await axios.delete(
                    '/api/profile',
                    this.getAuthConfig()
                )

                localStorage.removeItem('token')
                localStorage.removeItem('user')

                auth.user = null
                this.user = null

                await this.$router.push('/')
            } catch (error) {
                console.error(
                    'Failed to delete account:',
                    error.response?.data || error.message
                )

                if (
                    error.message === 'AUTH_REQUIRED' ||
                    error.response?.status === 401
                ) {
                    this.showToast('PLEASE LOG IN AGAIN')
                } else {
                    this.showToast('FAILED TO DELETE ACCOUNT')
                }
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
@import url('https\\://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');
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
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin: 1.5rem 0 0;
    padding: 0;
    list-style: none;
}
.trip-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin: 1.5rem 0 0;
    padding: 0;
    list-style: none;
}
.trip-card {
    height: 15rem;
    padding: 0.75rem;
    border-radius: 1rem;
    background-position: center;
    background-size: cover;
}
.trip-card .card__name {
    z-index: 1;
}
.card {
    position: relative;
    display: flex;
    align-items: flex-end;
    height: 15rem;
    padding: 0.75rem;
    overflow: hidden;
    border-radius: 1rem;
    background: linear-gradient(180deg, #75816c 55%, #394638) center / cover no-repeat;
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
@media (max-width: 900px) {
    .grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 900px) {
    .trip-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 600px) {
    .grid {
        grid-template-columns: 1fr;
    }
    .trip-grid {
        grid-template-columns: 1fr;
    }
}

/* Account */
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
.trip-stepper {
    display: flex;
    gap: 0.55rem;
    margin-bottom: 0.25rem;
}
.trip-stepper__item {
    display: grid;
    place-items: center;
    width: 2rem;
    height: 2rem;
    border: 1px solid #bdbdbd;
    border-radius: 50%;
    color: #777;
    font-size: 0.7rem;
    transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.trip-stepper__item--active,
.trip-stepper__item--done {
    border-color: #000;
    background: #000;
    color: #fff;
}
.trip-form__eyebrow {
    margin: 0;
    color: var(--link);
    font-size: 0.7rem;
    letter-spacing: 0.12em;
}
.form-step {
    min-height: 17rem;
    animation: trip-step-in 0.25s ease;
}
.trip-form__row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
.modal__box .field {
    margin: 0 0 1.5rem;
}
.modal__box .field input,
.modal__box .field textarea,
.modal__box .field select {
    width: 100%;
    padding: 0.75rem 0;
    border: 0;
    border-bottom: 1px solid #767676;
    border-radius: 0;
    background: transparent;
    color: #000;
    font: inherit;
    font-size: 0.9rem;
}
.modal__box .field textarea {
    resize: vertical;
}
.modal__box .field small,
.field__error {
    margin-top: 0.35rem;
    color: #c0392b;
    font-size: 0.72rem;
}
.trip-review {
    padding: 1.25rem;
    border: 1px solid #d4d4d4;
    border-radius: 0.8rem;
    background: #fafafa;
}
.trip-review__label {
    margin: 0.8rem 0 0.2rem;
    color: #666;
    font-size: 0.65rem;
    letter-spacing: 0.08em;
}
.trip-review__label:first-child {
    margin-top: 0;
}
.trip-review__value {
    margin: 0;
    overflow-wrap: anywhere;
    font-size: 0.9rem;
}
.trip-form__navigation {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-top: 0.5rem;
}
.trip-form__back,
.trip-form__cancel {
    padding: 0.8rem 0;
    border: 0;
    border-bottom: 1px solid #000;
    background: transparent;
    color: #000;
    font: inherit;
    font-size: 0.72rem;
    letter-spacing: 0.04em;
    cursor: pointer;
}
.trip-form__back {
    margin-right: auto;
}
.trip-form__navigation .account__save {
    min-height: 3rem;
    padding: 0 2rem;
}
@keyframes trip-step-in {
    from {
        opacity: 0;
        transform: translateY(6px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@media (max-width: 600px) {
    .trip-form__row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .modal {
        padding: 0.75rem;
        align-items: flex-start;
        overflow-y: auto;
    }
    .modal__box {
        margin: auto 0;
        max-height: none;
        padding: 1.75rem 1.25rem;
        gap: 1.25rem;
    }
    .form-step {
        min-height: 0;
    }
}
@media (prefers-reduced-motion: reduce) {
    .form-step {
        animation: none;
    }
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
.trip-form__row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.field select {
    padding: 0.75rem 0;
    border: 0;
    border-bottom: 1px solid #767676;
    border-radius: 0;
    background: transparent;
    font: inherit;
    font-size: 0.9rem;
    color: #000;
}
.field__error {
    color: #c0392b;
    font-size: 0.75rem;
}
@media (max-width: 600px) {
    .trip-form__row {
        grid-template-columns: 1fr;
        gap: 0;
    }
    .modal__box {
        max-height: 90vh;
        overflow-y: auto;
    }
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

.card--add {
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: .8rem;
    border: 1px solid #111;
    background: #fff;
    color: #111;
    text-align: center;
    font-family: var(--serif);
    font-size: .9rem;
}
.card--add::before {
    display: none;
}
.card--add svg {
    position: relative;
}
.card--add:hover {
    background: #f7f7f5;
}
@media (max-width: 600px) {
   .grid {
        grid-template-columns: repeat(auto-fill,minmax(13rem,1fr));
    }
}

</style>
