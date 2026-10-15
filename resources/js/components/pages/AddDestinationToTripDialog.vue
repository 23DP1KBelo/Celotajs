```vue
<template>
    <div
        v-if="modelValue"
        class="trip-dialog__overlay"
        @click.self="close"
        @keydown.esc="close"
    >
        <section
            class="trip-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="trip-dialog-title"
        >
            <button
                type="button"
                class="trip-dialog__close"
                aria-label="Close dialog"
                @click="close"
            >
                &times;
            </button>

            <!-- 1. Lietotāja ceļojumu saraksts -->
            <template v-if="step === 'list'">
                <p class="trip-dialog__eyebrow">MY TRAVEL PLANS</p>

                <h2 id="trip-dialog-title">
                    Choose your trip
                </h2>

                <p class="trip-dialog__description">
                    Select a trip to add this destination to.
                </p>

                <p v-if="loading" class="trip-dialog__message">
                    Loading your trips...
                </p>

                <p v-else-if="error" class="trip-dialog__error">
                    {{ error }}
                </p>

                <template v-else>
                    <div
                        v-if="trips.length"
                        class="trip-dialog__list"
                    >
                        <button
                            v-for="trip in trips"
                            :key="trip.id"
                            type="button"
                            class="trip-dialog__trip"
                            :class="{
                                'trip-dialog__trip--selected':
                                    selectedTripId === trip.id
                            }"
                            @click="selectedTripId = trip.id"
                        >
                            <span class="trip-dialog__trip-info">
                                <strong>
                                    {{ trip.title || trip.name || 'Untitled trip' }}
                                </strong>

                                <small v-if="trip.description">
                                    {{ trip.description }}
                                </small>

                                <small v-if="trip.destinations">
                                    {{ trip.destinations.length }}
                                    destinations
                                </small>
                            </span>

                            <span class="trip-dialog__radio">
                                <span
                                    v-if="selectedTripId === trip.id"
                                ></span>
                            </span>
                        </button>
                    </div>

                    <p v-else class="trip-dialog__empty">
                        You haven't created any trips yet.
                    </p>

                    <button
                        type="button"
                        class="trip-dialog__secondary"
                        @click="openCreateForm"
                    >
                        + Create new trip
                    </button>
                </template>

                <div class="trip-dialog__actions">
                    <button
                        type="button"
                        class="trip-dialog__text-button"
                        @click="close"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="trip-dialog__primary"
                        :disabled="!selectedTripId || loading"
                        @click="goToRecommendation"
                    >
                        Continue
                    </button>
                </div>
            </template>

            <!-- 2. Jauna ceļojuma izveide -->
            <template v-else-if="step === 'create'">
                <p class="trip-dialog__eyebrow">NEW TRAVEL PLAN</p>

                <h2 id="trip-dialog-title">
                    Create a new trip
                </h2>

                <p class="trip-dialog__description">
                    Give your next adventure a name.
                </p>

                <form
                    class="trip-dialog__form"
                    @submit.prevent="createTrip"
                >
                    <label for="trip-title">Trip name</label>

                    <input
                        id="trip-title"
                        v-model.trim="form.title"
                        type="text"
                        placeholder="e.g. Summer in Italy"
                        maxlength="150"
                        required
                    >

                    <label for="trip-description">
                        Description (optional)
                    </label>

                    <textarea
                        id="trip-description"
                        v-model.trim="form.description"
                        placeholder="What is this trip about?"
                        rows="3"
                    ></textarea>

                    <label for="trip-category">
                        Category (optional)
                    </label>

                    <input
                        id="trip-category"
                        v-model.trim="form.category"
                        type="text"
                        placeholder="e.g. Adventure"
                    >

                    <p v-if="error" class="trip-dialog__error">
                        {{ error }}
                    </p>

                    <div class="trip-dialog__actions">
                        <button
                            type="button"
                            class="trip-dialog__text-button"
                            @click="step = 'list'; error = ''"
                        >
                            Back
                        </button>

                        <button
                            type="submit"
                            class="trip-dialog__primary"
                            :disabled="saving || !form.title"
                        >
                            {{ saving ? 'Creating...' : 'Create trip' }}
                        </button>
                    </div>
                </form>
            </template>

            <!-- 3. Vai galamērķi pievienot kā rekomendāciju -->
            <template v-else-if="step === 'recommendation'">
                <p class="trip-dialog__eyebrow">ALMOST THERE</p>

                <h2 id="trip-dialog-title">
                    Save your destination
                </h2>

                <p class="trip-dialog__description">
                    Would you like this destination to be marked as a
                    recommendation for your selected trip?
                </p>

                <div class="trip-dialog__selected">
                    <span>SELECTED TRIP</span>

                    <strong>{{ selectedTripName }}</strong>
                </div>

                <div class="trip-dialog__choices">
                    <button
                        type="button"
                        class="trip-dialog__choice"
                        :class="{
                            'trip-dialog__choice--selected':
                                isRecommendation === true
                        }"
                        @click="isRecommendation = true"
                    >
                        <span class="trip-dialog__choice-title">
                            Yes, make it a recommendation
                        </span>

                        <span class="trip-dialog__choice-description">
                            Save this destination as a recommended place.
                        </span>
                    </button>

                    <button
                        type="button"
                        class="trip-dialog__choice"
                        :class="{
                            'trip-dialog__choice--selected':
                                isRecommendation === false
                        }"
                        @click="isRecommendation = false"
                    >
                        <span class="trip-dialog__choice-title">
                            No, just add to my trip
                        </span>

                        <span class="trip-dialog__choice-description">
                            Include the destination without recommending it.
                        </span>
                    </button>
                </div>

                <p v-if="error" class="trip-dialog__error">
                    {{ error }}
                </p>

                <div class="trip-dialog__actions">
                    <button
                        type="button"
                        class="trip-dialog__text-button"
                        @click="step = 'list'; error = ''"
                    >
                        Back
                    </button>

                    <button
                        type="button"
                        class="trip-dialog__primary"
                        :disabled="isRecommendation === null || saving"
                        @click="saveDestination"
                    >
                        {{ saving ? 'Saving...' : 'Save' }}
                    </button>
                </div>
            </template>
        </section>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'AddDestinationToTripDialog',

    props: {
        modelValue: {
            type: Boolean,
            default: false
        },

        destinationId: {
            type: [Number, String],
            required: true
        }
    },

    emits: ['update:modelValue', 'saved'],

    data() {
        return {
            step: 'list',
            trips: [],
            selectedTripId: null,
            isRecommendation: null,

            loading: false,
            saving: false,
            error: '',

            form: {
                title: '',
                description: '',
                category: ''
            }
        }
    },

    computed: {
        selectedTripName() {
            const trip = this.trips.find(
                item => String(item.id) === String(this.selectedTripId)
            )

            return trip?.title || trip?.name || 'Selected trip'
        }
    },

    watch: {
        modelValue(open) {
            if (open) {
                this.resetDialog()
                this.fetchTrips()
            }
        }
    },

    methods: {
        getHeaders() {
            const token = localStorage.getItem('token')

            return {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        },

        close() {
            if (this.saving) return

            this.$emit('update:modelValue', false)
        },

        resetDialog() {
            this.step = 'list'
            this.selectedTripId = null
            this.isRecommendation = null
            this.error = ''

            this.form = {
                title: '',
                description: '',
                category: ''
            }
        },

        async fetchTrips() {
            this.loading = true
            this.error = ''

            try {
                const response = await axios.get(
                    '/api/user/trips',
                    { headers: this.getHeaders() }
                )

                const data = response.data

                this.trips = Array.isArray(data)
                    ? data
                    : data.trips || data.data || []

                // Ja API atgriež arī pagājušā galamērķa datus,
                // šeit atlasām tikai ceļojumus ar ID.
                this.trips = this.trips.filter(trip => trip.id != null)
            } catch (error) {
                console.error(
                    'Failed to load trips:',
                    error.response?.data || error.message
                )

                this.error =
                    error.response?.data?.message ||
                    'Could not load your trips. Please try again.'
            } finally {
                this.loading = false
            }
        },

        openCreateForm() {
            this.form = {
                title: '',
                description: '',
                category: ''
            }

            this.error = ''
            this.step = 'create'
        },

        async createTrip() {
            if (!this.form.title || this.saving) return

            this.saving = true
            this.error = ''

            try {
                const payload = {
                    title: this.form.title,
                    description: this.form.description || null,
                    category: this.form.category || null
                }

                const response = await axios.post(
                    '/api/trips',
                    payload,
                    { headers: this.getHeaders() }
                )

                const data = response.data
                const newTrip = data.trip || data.data || data

                // Pēc izveides iegūstam pilnu sarakstu no servera.
                await this.fetchTrips()

                const createdTrip = this.trips.find(
                    trip => String(trip.id) === String(newTrip.id)
                )

                if (createdTrip) {
                    this.selectedTripId = createdTrip.id
                } else if (newTrip.id != null) {
                    this.trips.unshift(newTrip)
                    this.selectedTripId = newTrip.id
                } else {
                    this.error =
                        'Trip was created, but its ID was not returned.'
                    this.step = 'list'
                    return
                }

                // Atgriežamies pie tā paša ceļojumu saraksta,
                // lai lietotājs var izvēlēties vajadzīgo ceļojumu.
                this.step = 'list'
            } catch (error) {
                console.error(
                    'Failed to create trip:',
                    error.response?.data || error.message
                )

                this.error =
                    error.response?.data?.message ||
                    'Could not create the trip. Please check the form.'
            } finally {
                this.saving = false
            }
        },

        goToRecommendation() {
            if (!this.selectedTripId) return

            this.isRecommendation = null
            this.error = ''
            this.step = 'recommendation'
        },

        async saveDestination() {
            if (
                !this.selectedTripId ||
                this.isRecommendation === null ||
                this.saving
            ) {
                return
            }

            this.saving = true
            this.error = ''

            try {
                await axios.post(
                    '/api/trip-destinations',
                    {
                        trip_id: this.selectedTripId,
                        destination_id: this.destinationId,
                        recommendations: this.isRecommendation
                    },
                    {
                        headers: this.getHeaders()
                    }
                )

                this.$emit('saved', {
                    tripId: this.selectedTripId,
                    destinationId: this.destinationId,
                    recommendations: this.isRecommendation
                })

                this.$emit('update:modelValue', false)
            } catch (error) {
                console.error(
                    'Failed to save trip destination:',
                    error.response?.data || error.message
                )

                this.error =
                    error.response?.data?.message ||
                    Object.values(error.response?.data?.errors || {})
                        .flat()
                        .join(' ') ||
                    'Could not save this destination. Please try again.'
            } finally {
                this.saving = false
            }
        }
    }
}
</script>

<style scoped>
.trip-dialog__overlay {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(4px);
}

.trip-dialog {
    position: relative;
    width: min(100%, 35rem);
    max-height: min(90vh, 52rem);
    overflow-y: auto;
    padding: 3rem;
    background: #fff;
    color: #000;
    box-shadow: 0 20px 70px rgba(0, 0, 0, 0.2);
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.trip-dialog__close {
    position: absolute;
    top: 1rem;
    right: 1.3rem;
    border: 0;
    background: transparent;
    font-size: 2rem;
    line-height: 1;
    cursor: pointer;
}

.trip-dialog__eyebrow {
    margin: 0 0 1rem;
    color: #5aa9e6;
    font-size: 0.7rem;
    letter-spacing: 0.14em;
}

.trip-dialog h2 {
    margin: 0;
    font-family: 'Italiana', Georgia, serif;
    font-size: clamp(2rem, 5vw, 2.7rem);
    font-weight: 400;
    line-height: 1.1;
}

.trip-dialog__description {
    margin: 1rem 0 1.8rem;
    color: #555;
    font-size: 0.9rem;
    line-height: 1.6;
}

.trip-dialog__list {
    display: grid;
    gap: 0.65rem;
    max-height: 18rem;
    overflow-y: auto;
}

.trip-dialog__trip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    width: 100%;
    padding: 1rem;
    border: 1px solid #ddd;
    background: #fff;
    color: #000;
    text-align: left;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}

.trip-dialog__trip:hover,
.trip-dialog__trip--selected {
    border-color: #000;
    background: #f8f8f6;
}

.trip-dialog__trip-info {
    display: grid;
    gap: 0.4rem;
    min-width: 0;
}

.trip-dialog__trip-info strong {
    font-size: 0.9rem;
    font-weight: 400;
}

.trip-dialog__trip-info small {
    color: #666;
    font-size: 0.75rem;
    overflow-wrap: anywhere;
}

.trip-dialog__radio {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 1.1rem;
    height: 1.1rem;
    border: 1px solid #999;
    border-radius: 50%;
}

.trip-dialog__trip--selected .trip-dialog__radio {
    border-color: #000;
}

.trip-dialog__radio span {
    width: 0.55rem;
    height: 0.55rem;
    border-radius: 50%;
    background: #000;
}

.trip-dialog__empty,
.trip-dialog__message {
    padding: 1.3rem 0;
    color: #555;
    font-size: 0.85rem;
}

.trip-dialog__secondary {
    width: 100%;
    margin-top: 1rem;
    padding: 1rem;
    border: 1px dashed #999;
    background: #fff;
    font: inherit;
    font-size: 0.85rem;
    cursor: pointer;
}

.trip-dialog__secondary:hover {
    border-color: #000;
}

.trip-dialog__actions {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-top: 2rem;
}

.trip-dialog__primary,
.trip-dialog__text-button {
    padding: 0.9rem 1.5rem;
    border: 1px solid #000;
    border-radius: 999px;
    font: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}

.trip-dialog__primary {
    background: #000;
    color: #fff;
}

.trip-dialog__primary:hover:not(:disabled) {
    background: #333;
}

.trip-dialog__primary:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.trip-dialog__text-button {
    background: #fff;
    color: #000;
}

.trip-dialog__form {
    display: grid;
    gap: 0.7rem;
    margin-top: 1.5rem;
}

.trip-dialog__form label {
    margin-top: 0.6rem;
    font-size: 0.8rem;
}

.trip-dialog__form input,
.trip-dialog__form textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 0.9rem 1rem;
    border: 1px solid #ccc;
    border-radius: 0;
    background: #fff;
    color: #000;
    font: inherit;
    font-size: 0.9rem;
    text-transform: none;
}

.trip-dialog__form input:focus,
.trip-dialog__form textarea:focus {
    outline: 1px solid #000;
    border-color: #000;
}

.trip-dialog__form textarea {
    resize: vertical;
}

.trip-dialog__selected {
    display: grid;
    gap: 0.4rem;
    margin: 1.5rem 0;
    padding: 1rem;
    background: #f6f6f4;
}

.trip-dialog__selected span {
    color: #666;
    font-size: 0.65rem;
    letter-spacing: 0.12em;
}

.trip-dialog__selected strong {
    font-size: 0.9rem;
    font-weight: 400;
}

.trip-dialog__choices {
    display: grid;
    gap: 0.7rem;
}

.trip-dialog__choice {
    display: grid;
    gap: 0.45rem;
    padding: 1rem;
    border: 1px solid #ddd;
    background: #fff;
    color: #000;
    text-align: left;
    cursor: pointer;
}

.trip-dialog__choice--selected {
    border-color: #000;
    background: #f8f8f6;
}

.trip-dialog__choice-title {
    font-size: 0.85rem;
    font-weight: 400;
}

.trip-dialog__choice-description {
    color: #666;
    font-size: 0.75rem;
    line-height: 1.5;
}

.trip-dialog__error {
    margin: 1rem 0 0;
    color: #b42318;
    font-size: 0.8rem;
    line-height: 1.5;
}

@media (max-width: 500px) {
    .trip-dialog {
        padding: 2.5rem 1.25rem 1.5rem;
    }

    .trip-dialog__actions {
        gap: 0.6rem;
    }

    .trip-dialog__primary,
    .trip-dialog__text-button {
        padding: 0.8rem 1.1rem;
    }
}
</style>