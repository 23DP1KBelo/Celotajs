<template>
    <main class="add">
        <div class="add__inner">
            <router-link to="/discover" class="add__back">
                <svg width="30" height="8" viewBox="0 0 30 8" aria-hidden="true">
                    <path d="M30 4H1M4 1L1 4l3 3" fill="none" stroke="currentColor" stroke-width="0.8" />
                </svg>
                BACK TO DISCOVER
            </router-link>

            <h1>ADD A DESTINATION</h1>
            <p class="add__lead">SHARE A PLACE WORTH VISITING AND ADD IT TO ONE OF YOUR TRIPS.</p>

            <p v-if="!isLoggedIn && auth.loaded !== false" class="notice" role="alert">
                Please login to add a destination
                <router-link to="/login">LOG IN</router-link>
            </p>

            <form class="form" novalidate @submit.prevent="submit">
                <fieldset class="lock" :disabled="!isLoggedIn">
                    <div class="field">
                        <label for="title">NAME</label>
                        <input id="title" v-model.trim="form.title" type="text" placeholder="E.G. GEIRANGERFJORD">
                        <small v-if="errors.title" class="field__error">{{ errors.title[0] }}</small>
                    </div>

                    <div class="row">
                        <div class="field">
                            <label for="country">COUNTRY</label>
                            <input id="country" v-model.trim="form.country" type="text" placeholder="E.G. NORWAY">
                            <small v-if="errors.country" class="field__error">{{ errors.country[0] }}</small>
                        </div>

                        <div class="field">
                            <label for="city">CITY</label>
                            <input id="city" v-model.trim="form.city" type="text" placeholder="E.G. GEIRANGER">
                            <small v-if="errors.city" class="field__error">{{ errors.city[0] }}</small>
                        </div>
                    </div>

                    <div class="field">
                        <label for="category">CATEGORY</label>
                        <div class="select">
                            <select id="category" v-model="form.category">
                                <option value="" disabled>CHOOSE A CATEGORY</option>
                                <option v-for="item in categories" :key="item" :value="item">
                                    {{ item.toUpperCase() }}
                                </option>
                            </select>
                            <span class="select__arrow" aria-hidden="true">V</span>
                        </div>
                        <small v-if="errors.category" class="field__error">{{ errors.category[0] }}</small>
                    </div>

                    <fieldset class="field status">
                        <legend>STATUS</legend>
                        <label v-for="item in statuses" :key="item.value" class="status__option">
                            <input v-model="form.status" type="radio" name="status" :value="item.value">
                            <span>{{ item.label }}</span>
                        </label>
                    </fieldset>

                    <!-- Trip: existing or new -->
                    <fieldset class="field status">
                        <legend>ADD TO TRIP</legend>

                        <label v-if="trips.length" class="status__option">
                            <input v-model="tripMode" type="radio" name="tripMode" value="existing">
                            <span>EXISTING TRIP</span>
                        </label>
                        <label class="status__option">
                            <input v-model="tripMode" type="radio" name="tripMode" value="new">
                            <span>NEW TRIP</span>
                        </label>
                    </fieldset>

                    <div v-if="tripMode === 'existing'" class="field">
                        <label for="trip">YOUR TRIP</label>
                        <div class="select">
                            <select id="trip" v-model="form.trip_id">
                                <option value="" disabled>CHOOSE A TRIP</option>
                                <option v-for="trip in trips" :key="trip.id" :value="trip.id">
                                    {{ trip.name }}
                                </option>
                            </select>
                            <span class="select__arrow" aria-hidden="true">V</span>
                        </div>
                        <small v-if="errors.trip_id" class="field__error">{{ errors.trip_id[0] }}</small>
                    </div>

                    <div v-else class="trip-new">
                        <div class="field">
                            <label for="trip_name">TRIP NAME</label>
                            <input
                                id="trip_name"
                                v-model.trim="form.trip_name"
                                type="text"
                                maxlength="100"
                                placeholder="E.G. SUMMER IN NORWAY"
                            >
                            <small v-if="errors.trip_name" class="field__error">{{ errors.trip_name[0] }}</small>
                        </div>

                        <div class="field">
                            <label for="trip_description">TRIP DESCRIPTION</label>
                            <textarea
                                id="trip_description"
                                v-model.trim="form.trip_description"
                                rows="3"
                                placeholder="WHAT IS THIS TRIP ABOUT?"
                            />
                            <small v-if="errors.trip_description" class="field__error">{{ errors.trip_description[0] }}</small>
                        </div>
                    </div>

                    <!-- Visibility -->
                    <fieldset class="field status">
                        <legend>VISIBILITY</legend>
                        <label v-for="item in visibilities" :key="item.value" class="status__option">
                            <input v-model="form.visibility" type="radio" name="visibility" :value="item.value">
                            <span>{{ item.label }}</span>
                        </label>
                        <p class="hint">{{ visibilityHint }}</p>
                    </fieldset>

                    <div class="field">
                        <label for="description">DESCRIPTION</label>
                        <textarea
                            id="description"
                            v-model.trim="form.description"
                            rows="4"
                            placeholder="WHAT MAKES THIS PLACE SPECIAL?"
                        />
                        <small v-if="errors.description" class="field__error">{{ errors.description[0] }}</small>
                    </div>

                    <div class="field">
                        <label for="image">PHOTO</label>
                        <label class="drop" :class="{ 'drop--filled': preview }" for="image">
                            <img v-if="preview" :src="preview" alt="Selected photo preview">
                            <span v-else>CLICK TO CHOOSE A PHOTO (JPG, PNG, WEBP · MAX 5 MB)</span>
                        </label>
                        <input id="image" class="drop__input" type="file" accept="image/*" @change="onFile">
                        <small v-if="errors.image" class="field__error">{{ errors.image[0] }}</small>
                    </div>

                    <p v-if="message" class="message" :class="{ 'message--ok': success }" role="status">
                        {{ message }}
                    </p>

                    <button type="submit" class="submit" :disabled="loading">
                        {{ loading ? 'SAVING…' : 'ADD DESTINATION' }}
                    </button>
                </fieldset>
            </form>
        </div>
    </main>
</template>

<script>
import axios from 'axios'
import { auth } from '../../auth.js'

const emptyForm = () => ({
    title: '',
    country: '',
    city: '',
    category: '',
    status: 'not_visited',
    description: '',
    visibility: 'private',
    trip_id: '',
    trip_name: '',
    trip_description: ''
})

export default {
    data() {
        return {
            auth,

            form: emptyForm(),
            file: null,
            preview: '',

            categories: ['Daba', 'Atpūta', 'Izklaide'],
            statuses: [
                { value: 'not_visited', label: 'NEAPMEKLĒTS' },
                { value: 'visited', label: 'APMEKLĒTS' }
            ],
            visibilities: [
                { value: 'private', label: 'PRIVATE' },
                { value: 'public', label: 'PUBLIC' }
            ],

            // user's trips come from GET /api/user/trips
            trips: [],
            tripMode: 'new',

            errors: {},
            message: '',
            success: false,
            loading: false
        }
    },

    computed: {
        isLoggedIn() {
            return !!auth.user
        },

        visibilityHint() {
            return this.form.visibility === 'public'
                ? 'EVERYONE CAN FIND THIS PLACE ON THE DISCOVER PAGE.'
                : 'ONLY YOU CAN SEE THIS PLACE, INSIDE YOUR TRIP.'
        }
    },

    watch: {
        isLoggedIn: {
            immediate: true,
            handler(value) {
                if (value) {
                    this.loadTrips()
                }
            }
        }
    },

    beforeUnmount() {
        this.clearPreview()
    },

    methods: {
        async loadTrips() {
            try {
                const { data } = await axios.get('/api/user/trips', { withCredentials: true })

                this.trips = Array.isArray(data) ? data : (data.trips || [])
            } catch (error) {
                console.log(error.response)
                this.trips = []
            }

            // no trips yet -> the only option is to create a new one
            this.tripMode = this.trips.length ? 'existing' : 'new'
        },

        onFile(event) {
            const file = event.target.files[0]
            this.errors = { ...this.errors, image: undefined }
            this.clearPreview()

            if (!file) {
                this.file = null
                return
            }

            if (file.size > 5 * 1024 * 1024) {
                this.file = null
                event.target.value = ''
                this.errors = { ...this.errors, image: ['The photo must be smaller than 5 MB.'] }
                return
            }

            this.file = file
            this.preview = URL.createObjectURL(file)
        },

        clearPreview() {
            if (this.preview) {
                URL.revokeObjectURL(this.preview)
            }
            this.preview = ''
        },

        validate() {
            const errors = {}
            const required = ['title', 'country', 'city', 'category']

            required.forEach((key) => {
                if (!this.form[key]) {
                    errors[key] = ['This field is required.']
                }
            })

            if (this.tripMode === 'existing' && !this.form.trip_id) {
                errors.trip_id = ['Please choose a trip.']
            }

            if (this.tripMode === 'new' && !this.form.trip_name) {
                errors.trip_name = ['Please enter a trip name.']
            }

            this.errors = errors
            return Object.keys(errors).length === 0
        },

        async submit() {
            this.message = ''

            if (!this.isLoggedIn || !this.validate()) {
                return
            }

            this.loading = true

            try {
                // image goes with the text fields, so use FormData (multipart)
                const data = new FormData()

                ;['title', 'country', 'city', 'category', 'status', 'description'].forEach((key) => {
                    data.append(key, this.form[key])
                })

                data.append('is_public', this.form.visibility === 'public' ? '1' : '0')

                if (this.tripMode === 'existing') {
                    data.append('trip_id', this.form.trip_id)
                } else {
                    data.append('trip_name', this.form.trip_name)
                    data.append('trip_description', this.form.trip_description)
                }

                if (this.file) {
                    data.append('image', this.file)
                }

                await axios.get('/sanctum/csrf-cookie', { withCredentials: true })
                await axios.post('/api/destinations', data, { withCredentials: true })

                this.success = true
                this.message = 'Destination added!'
                this.form = emptyForm()
                this.file = null
                this.clearPreview()
                document.getElementById('image').value = ''

                // a newly created trip should now appear in the list
                await this.loadTrips()
            } catch (error) {
                console.log(error.response)

                if (error.response?.status === 401) {
                    // session expired -> fields get locked again
                    auth.user = null
                    return
                }

                this.success = false
                this.errors = error.response?.data?.errors || {}
                this.message = error.response?.data?.message || 'Could not add destination'
            } finally {
                this.loading = false
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.add {
    --muted: #555;
    --line: #444;
    --link: #5aa9e6;
    --error: #b3261e;
    --serif: 'Italiana', serif;

    min-height: calc(100vh - 4.5rem);
    padding: 3rem 1.5rem 6rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.add__inner {
    max-width: 40rem;
    margin: 0 auto;
}

.add__back {
    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 0.7rem;
    color: var(--link);
    text-decoration: none;
}

.add h1 {
    margin: 3.5rem 0 0.8rem;
    font-family: var(--serif);
    font-weight: 400;
    font-size: clamp(2.2rem, 5vw, 3.4rem);
    letter-spacing: 0.04em;
    line-height: 1.1;
}

.add__lead {
    margin: 0 0 3.5rem;
    font-size: 0.75rem;
}

/* ---------- Guest notice + lock ---------- */
.notice {
    margin: -1.5rem 0 2.5rem;
    padding: 1rem 1.5rem;
    border: 1px solid #000;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 400;
    text-align: center;
}

.notice a {
    margin-left: 0.8rem;
    color: var(--link);
    text-decoration: underline;
    text-underline-offset: 3px;
}

.lock {
    min-width: 0;
    margin: 0;
    padding: 0;
    border: 0;
}

.lock:disabled {
    opacity: 0.45;
}

.lock:disabled * {
    cursor: not-allowed !important;
}

/* ---------- Fields ---------- */
.row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.field {
    display: flex;
    flex-direction: column;
    margin: 0 0 2.4rem;
    padding: 0;
    border: 0;
    min-width: 0;
}

.field label,
.field legend {
    padding: 0;
    font-size: 0.65rem;
    color: var(--muted);
}

.field input[type='text'],
.field textarea,
.field select {
    width: 100%;
    padding: 0.9rem 0 0.4rem;
    border: 0;
    border-bottom: 1px solid var(--line);
    border-radius: 0;
    background: transparent;
    font: inherit;
    font-size: 0.95rem;
    color: #000;
    outline: none;
}

.field textarea {
    resize: vertical;
}

.field input::placeholder,
.field textarea::placeholder {
    font-size: 0.65rem;
    color: #8a8a8a;
}

.field input[type='text']:focus-visible,
.field textarea:focus-visible,
.field select:focus-visible {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.field__error {
    margin-top: 0.4rem;
    font-size: 0.7rem;
    color: var(--error);
}

/* select with a "V" arrow, like on the Discover page */
.select {
    position: relative;
}

.select select {
    appearance: none;
    padding-right: 1.8rem;
    cursor: pointer;
}

.select__arrow {
    position: absolute;
    right: 0;
    bottom: 0.45rem;
    font-family: var(--serif);
    font-size: 1.1rem;
    color: var(--muted);
    pointer-events: none;
}

/* radio groups styled as pills (status, trip mode, visibility) */
.status {
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.8rem;
}

.status legend {
    width: 100%;
    margin-bottom: 0.8rem;
}

.status__option {
    position: relative;
}

.status__option input {
    position: absolute;
    opacity: 0;
}

.status__option span {
    display: inline-block;
    padding: 0.55rem 1.4rem;
    border: 1px solid #222;
    border-radius: 999px;
    font-size: 0.75rem;
    color: #000;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}

.status__option input:checked + span {
    background: #222;
    color: #fff;
}

.status__option input:focus-visible + span {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

.hint {
    width: 100%;
    margin: 0.4rem 0 0;
    font-size: 0.65rem;
    color: var(--muted);
}

/* new trip sub-form */
.trip-new {
    margin: 0 0 2.4rem;
    padding-left: 1.2rem;
    border-left: 1px solid #bdbdbd;
}

.trip-new .field:last-child {
    margin-bottom: 0;
}

/* photo drop area */
.drop {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 9rem;
    margin-top: 0.8rem;
    border: 1px dashed #888;
    border-radius: 1rem;
    overflow: hidden;
    font-size: 0.7rem;
    color: var(--muted) !important;
    text-align: center;
    padding: 1rem;
    cursor: pointer;
}

.drop:hover {
    border-color: #000;
}

.drop--filled {
    padding: 0;
    border-style: solid;
}

.drop img {
    display: block;
    width: 100%;
    max-height: 20rem;
    object-fit: cover;
}

.drop__input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
}

.drop__input:focus-visible {
    outline: 2px solid var(--link);
}

/* ---------- Submit ---------- */
.message {
    margin: 0 0 1.2rem;
    font-size: 0.75rem;
    text-align: center;
    color: var(--error);
}

.message--ok {
    color: #2e7d32;
}

.submit {
    display: block;
    width: 100%;
    max-width: 22rem;
    margin: 3rem auto 0;
    padding: 1.1rem 1rem;
    border: 0;
    border-radius: 999px;
    background: #000;
    color: #fff;
    font: inherit;
    font-size: 0.8rem;
    font-weight: 400;
    cursor: pointer;
    transition: background 0.2s, opacity 0.2s;
}

.submit:hover:not(:disabled) {
    background: #222;
}

.submit:disabled {
    opacity: 0.6;
    cursor: progress;
}

.submit:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

@media (max-width: 600px) {
    .row {
        grid-template-columns: 1fr;
        gap: 0;
    }
}
</style>