<template>
    <main class="profile">
        <transition name="toast">
            <div v-if="toast" class="toast" role="status">{{ toast }}</div>
        </transition>
        <header class="profile__hero">
            <p>{{ $t('profile.heroText') }}</p>
            <h1>{{ $t('profile.title') }}</h1>
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
                    <h2>{{ username || $t('common.yourName') }}</h2>
                    <p>{{ user?.email || 'you@example.com' }}</p>
                    <p v-if="memberSince">{{ $t('profile.memberSince', { year: memberSince }) }}</p>
                </div>
            </div>
            <div class="stats">
                <div>
                    <strong>{{ saved.length }}</strong>
                    <span>{{ $t('profile.savedPlaces') }}</span>
                </div>
                <div>
                    <strong>{{ visitedCount }}</strong>
                    <span>{{ $t('common.visited') }}</span>
                </div>
                <div>
                    <strong>{{ countriesCount }}</strong>
                    <span>{{ $t('profile.countries') }}</span>
                </div>
            </div>
        </section>
        <section class="mine">
            <div class="mine__head">
                <h2>{{ $t('profile.myTrips') }}</h2>
                <div class="mine__tools">
                    <div class="tabs" role="tablist">
                        <button v-for="tab in tabs" :key="tab.value" type="button" role="tab" class="tabs__item" :class="{ 'tabs__item--on': filter === tab.value }" :aria-selected="filter === tab.value" @click="filter = tab.value">{{ tab.label }}</button>
                    </div>
                    <button type="button" class="mine__add" @click="openModal">{{ $t('profile.addTrip') }}</button>
                </div>
            </div>
            <p v-if="loadingTrips" class="mine__empty">{{ $t('common.loading') }}</p>
            <p v-else-if="!filteredTrips.length" class="mine__empty">{{ $t('profile.noTrips') }}</p>
            <ul v-else class="grid trip-grid">
                <li v-for="trip in filteredTrips" :key="trip.id">
                    <article class="card trip-card" :style="{ backgroundImage: trip.image ? `linear-gradient(transparent 45%,rgba(0,0,0,.5)),url('${trip.image}')` : 'linear-gradient(180deg,#75816c 55%,#394638)' }" @click="$router.push(`/trips/${trip.id}`)">
                        <button type="button" class="card__badge trip-status-toggle" :class="{ 'card__badge--dark': trip.status === 'visited' }" :disabled="updatingTripId === trip.id" @click.stop="toggleTripStatus(trip)">
                            {{ updatingTripId === trip.id ? $t('common.saving') : (trip.status === 'visited' ? $t('common.visited') : $t('common.wantToVisit')) }}
                        </button>
                        <span class="card__name">{{ trip.title || trip.name }}</span>
                        <button type="button" class="trip-delete" :disabled="deletingTripId === trip.id" @click.stop="deleteTrip(trip)">
                            {{ deletingTripId === trip.id ? $t('profile.deleting') : $t('profile.deleteTrip') }}
                        </button>
                    </article>
                </li>
            </ul>
        </section>
        <section class="account">
            <div class="account__intro">
                <h2>{{ $t('profile.accountTitle') }}<br>{{ $t('profile.accountTitleEnd') }}</h2>
                <p>{{ $t('profile.accountText') }}</p>
            </div>
            <form class="account__form" @submit.prevent="saveChanges">
                <label class="field">
                    <span>{{ $t('common.username') }}</span>
                    <input :value="username" type="text" :placeholder="$t('common.yourName')" readonly>
                </label>
                <label class="field">
                    <span>{{ $t('common.email') }}</span>
                    <input v-model.trim="form.email" type="email" :placeholder="$t('common.emailPlaceholder')" autocomplete="email">
                    <small v-if="errors.email">{{ errors.email[0] }}</small>
                </label>
                <label class="field">
                    <span>{{ $t('profile.newPassword') }}</span>
                    <input v-model="form.password" type="password" placeholder="**********" autocomplete="new-password">
                    <small v-if="errors.password">{{ errors.password[0] }}</small>
                </label>
                <label v-if="form.password" class="field">
                    <span>{{ $t('profile.currentPassword') }}</span>
                    <input v-model="form.current_password" type="password" autocomplete="current-password">
                    <small v-if="errors.current_password">{{ errors.current_password[0] }}</small>
                </label>
                <div class="account__actions">
                    <button type="submit" class="account__save" :disabled="saving">
                        {{ saving ? $t('common.saving') : $t('common.saveChanges') }}
                    </button>
                    <button type="button" class="account__delete" @click="deleteAccount">{{ $t('profile.deleteAccount') }}</button>
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
                    <div class="trip-stepper" :aria-label="$t('profile.progress')">
                        <span v-for="number in 3" :key="number"
                              class="trip-stepper__item"
                              :class="{ 'trip-stepper__item--active': step === number, 'trip-stepper__item--done': step > number }">
                            0{{ number }}
                        </span>
                    </div>
                    <p class="trip-form__eyebrow">{{ $t('profile.step', { step }) }}</p>
                    <h2 id="trip-title">
                        {{ step === 1 ? $t('profile.stepDetails') : step === 2 ? $t('profile.stepDates') : $t('profile.stepReview') }}
                    </h2>
                    <div class="trip-form__content">
                    <div v-if="step === 1" class="form-step">
                        <label class="field">
                            <span>{{ $t('common.tripName') }} *</span>
                            <input
                                ref="tripName"
                                v-model.trim="tripForm.title"
                                type="text"
                                maxlength="255"
                                :placeholder="$t('common.tripNamePlaceholder')"
                                required
                            >
                            <small v-if="tripErrors.title">{{ tripErrors.title[0] }}</small>
                        </label>
                        <label class="field">
                            <span>{{ $t('common.description') }}</span>
                            <textarea
                                v-model.trim="tripForm.description"
                                rows="4"
                                :placeholder="$t('common.tripDescriptionPlaceholder')"
                            ></textarea>
                            <small v-if="tripErrors.description">{{ tripErrors.description[0] }}</small>
                        </label>
                    </div>
                    <div v-else-if="step === 2" class="form-step">
                        <div class="trip-form__row">
                            <label class="field">
                                <span>{{ $t('profile.dateFrom') }}</span>
                                <input v-model="tripForm.date_from" type="date" required>
                                <small v-if="tripErrors.date_from">{{ tripErrors.date_from[0] }}</small>
                            </label>
                            <label class="field">
                                <span>{{ $t('profile.dateTill') }}</span>
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
                            <span>{{ $t('profile.budget') }}</span>
                            <input
                                v-model="tripForm.budget"
                                type="number"
                                min="0"
                                step="0.01"
                                :placeholder="$t('profile.budgetPlaceholder')"
                            >
                            <small v-if="tripErrors.budget">{{ tripErrors.budget[0] }}</small>
                        </label>
                        <label class="field">
                            <span>{{ $t('common.status') }} *</span>
                            <select v-model="tripForm.status" required>
                                <option value="unvisited">{{ $t('common.wantToVisit') }}</option>
                                <option value="visited">{{ $t('common.visited') }}</option>
                            </select>
                            <small v-if="tripErrors.status">{{ tripErrors.status[0] }}</small>
                        </label>
                        <label class="field">
                            <span>{{ $t('common.category') }}</span>
                            <select v-model="tripForm.category">
                                <option value="">{{ $t('common.chooseCategory') }}</option>
                                <option value="nature">{{ $t('categories.nature') }}</option>
                                <option value="adventure">{{ $t('categories.adventure') }}</option>
                                <option value="rest">{{ $t('categories.rest') }}</option>
                            </select>
                            <small v-if="tripErrors.category">
                                {{ tripErrors.category[0] }}
                            </small>
                        </label>
                    </div>
                    <div v-else class="form-step">
                                                
                        <div class="trip-photo-field">
                            <span class="trip-photo-field__label">{{ $t('profile.tripPhoto') }} <small>{{ $t('profile.photoOptional') }}</small></span>
                            <input
                                id="trip-photo-upload"
                                ref="tripImageInput"
                                class="trip-photo-input"
                                type="file"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                @change="onTripImageChange"
                            >
                            <div v-if="tripImagePreview" class="trip-photo-preview">
                                <img :src="tripImagePreview" :alt="$t('profile.photoPreview')" class="trip-photo-preview__image">
                                <div class="trip-photo-preview__overlay">
                                    <span class="trip-photo-preview__caption">{{ $t('profile.tripCover') }}</span>
                                    <div class="trip-photo-preview__actions">
                                        <label for="trip-photo-upload" class="trip-photo-preview__button">{{ $t('profile.changePhoto') }}</label>
                                        <button type="button" class="trip-photo-preview__button" @click="removeTripImage">{{ $t('profile.removePhoto') }}</button>
                                    </div>
                                </div>
                            </div>
                            <label v-else for="trip-photo-upload" class="trip-photo-dropzone">
                                <span class="trip-photo-dropzone__icon" aria-hidden="true">+</span>
                                <strong>{{ $t('profile.addCover') }}</strong>
                                <span>{{ $t('profile.choosePhoto') }}</span>
                            </label>
                            <small v-if="tripErrors.image" class="trip-photo-error">{{ tripErrors.image[0] }}</small>
                        </div>

                        <div class="trip-review">
                            <p class="trip-review__label">{{ $t('common.tripName') }}</p>
                            <p class="trip-review__value">{{ tripForm.title || '—' }}</p>
                            <p class="trip-review__label">{{ $t('profile.dates') }}</p>
                            <p class="trip-review__value">
                                {{ tripForm.date_from || '—' }} — {{ tripForm.date_till || '—' }}
                            </p>
                            <p class="trip-review__label">{{ $t('profile.budgetLabel') }}</p>
                            <p class="trip-review__value">
                                {{ tripForm.budget !== '' ? `€${tripForm.budget}` : $t('common.notSpecified') }}
                            </p>
                            <p class="trip-review__label">{{ $t('common.category') }}</p>
                            <p class="trip-review__value">{{ tripForm.category ? $t(`categories.${tripForm.category}`) : $t('common.notSpecified') }}</p>
                        </div>
                        <p v-if="tripErrors.user_id" class="field__error">
                            {{ tripErrors.user_id[0] }}
                        </p>
                        <p v-if="tripErrors.general" class="field__error">
                            {{ tripErrors.general[0] }}
                        </p>
                    </div>
                    </div>
                    <div class="trip-form__navigation">
                        <button
                            v-if="step > 1"
                            type="button"
                            class="trip-form__back"
                            @click="step--"
                        >
                            {{ $t('profile.back') }}
                        </button>
                        <button
                            type="button"
                            class="trip-form__cancel"
                            @click="closeModal"
                        >
                            {{ $t('common.cancel') }}
                        </button>
                        <button
                            v-if="step < 3"
                            type="button"
                            class="account__save"
                            @click="nextTripStep"
                        >
                            {{ $t('profile.continue') }}
                        </button>
                        <button
                            v-else
                            type="submit"
                            class="account__save"
                            :disabled="creating"
                        >
                            {{ creating ? $t('common.saving') : $t('profile.confirm') }}
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
            trips: [],
            loadingTrips: true,
            updatingTripId: null,
            deletingTripId: null,
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
                category: '',
            },
            tripImage: null,
            tripImagePreview: '',
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
        tabs() {
            return [
                { value: 'all', label: this.$t('common.all') },
                { value: 'unvisited', label: this.$t('common.wantToVisit') },
                { value: 'visited', label: this.$t('common.visited') }
            ]
        },
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
        saved() {
            const unique = new Map()

            this.trips.forEach(trip => {
                const destinations =
                    trip.trip_destinations || trip.destinations || []

                destinations.forEach(item => {
                    const destination = item.destination || item
                    const id = destination.id || item.destination_id

                    if (id) {
                        unique.set(id, {
                            ...destination,
                            tripStatus: trip.status
                        })
                    }
                })
            })

            return [...unique.values()]
        },
        filteredDestinations() {
            return this.saved.filter(place => this.filter === 'all' || place.status === this.filter || (this.filter === 'unvisited' && place.status === 'not_visited'))
        },
        filteredTrips() {
            return this.trips.filter(trip => this.filter === 'all' || trip.status === this.filter || (this.filter === 'unvisited' && trip.status === 'not_visited'))
        },
       visitedCount() {
            return this.saved.filter(
                destination => destination.tripStatus === 'visited'
            ).length
        },

        countriesCount() {
            const countries = new Set()

            this.trips.forEach(trip => {
                const destinations =
                    trip.trip_destinations || trip.destinations || []

                destinations.forEach(item => {
                    const destination = item.destination || item
                    const country = destination.place?.country

                    if (country?.id) {
                        countries.add(country.id)
                    }
                })
            })

            return countries.size
        },
    },
    async mounted() {
        await fetchUser()
        this.user = auth.user
        if (!this.user) {
            await this.$router.push('/login')
            return
        }
        this.form.email = this.user.email || ''
        await this.loadTrips()
    },
    methods: {
       getAuthConfig() {
            const token = localStorage.getItem('token')
            if (!token) throw new Error('AUTH_REQUIRED')
            return {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json',
                },
            }
        },
        
        onTripImageChange(event) {
            const file = event.target.files?.[0] || null;

            delete this.tripErrors.image;

            if (!file) {
                this.removeTripImage();
                return;
            }

            const validType = ['image/jpeg', 'image/png'].includes(file.type)
                || /\.(jpe?g|png)$/i.test(file.name);

            if (!validType) {
                this.removeTripImage();
                this.tripErrors.image = [this.$t('profile.imageType')];
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                this.removeTripImage();
                this.tripErrors.image = [this.$t('profile.imageSize')];
                return;
            }

            if (this.tripImagePreview) {
                URL.revokeObjectURL(this.tripImagePreview);
            }

            this.tripImage = file;
            this.tripImagePreview = URL.createObjectURL(file);
        },

        removeTripImage() {
            if (this.tripImagePreview) {
                URL.revokeObjectURL(this.tripImagePreview);
            }

            this.tripImage = null;
            this.tripImagePreview = '';

            if (this.$refs.tripImageInput) {
                this.$refs.tripImageInput.value = '';
            }

            delete this.tripErrors.image;
        },

    
        async loadTrips() {
            this.loadingTrips = true
            try {
                const { data } = await axios.get('/api/user/trips', this.getAuthConfig())
                const list = Array.isArray(data) ? data : (Array.isArray(data.data) ? data.data : (data.trips || []))
                this.trips = list.map(trip => ({ ...trip, date_from: trip.date_from || trip.date_form || '', destinations: trip.destinations || trip.trip_destinations || [] }))
            } catch (error) {
                console.error('Failed to load trips:', error.response?.data || error.message)
                this.showToast(this.$t('profile.tripsFailed'))
            } finally {
                this.loadingTrips = false
            }
        },

        
        async toggleTripStatus(trip) {
            if (this.updatingTripId === trip.id) return;

            const newStatus =
                trip.status === 'visited' || trip.status === 'apmeklēts'
                    ? 'unvisited'
                    : 'visited';

            this.updatingTripId = trip.id;

            const payload = {
                user_id: trip.user_id,
                title: trip.title,
                description: trip.description ?? '',
                date_from: trip.date_from || trip.date_form || null,
                date_till: trip.date_till || null,
                budget: trip.budget ?? null,
                status: newStatus,
                category: trip.category || null,
            };

            try {
                const token = localStorage.getItem('token');

                await axios.put(`/api/trips/${trip.id}`, payload, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                trip.status = newStatus;
            } catch (error) {
                const errors = error.response?.data?.errors || {};

                alert(
                    Object.values(errors).flat().join('\n') ||
                    error.response?.data?.message ||
                    this.$t('profile.statusFailed')
                );
            } finally {
                this.updatingTripId = null;
            }
        },

        async deleteTrip(trip) {
            if (this.deletingTripId === trip.id) return
            if (!window.confirm(this.$t('profile.deleteTripConfirm', { name: trip.title || trip.name || this.$t('profile.thisTrip') }))) return
            this.deletingTripId = trip.id
            try {
                await axios.delete(`/api/trips/${trip.id}`, this.getAuthConfig())
                this.trips = this.trips.filter(item => String(item.id) !== String(trip.id))
                this.showToast(this.$t('profile.tripDeleted'))
            } catch (error) {
                console.error('Failed to delete trip:', error.response?.data || error.message)
                this.showToast(error.response?.data?.message || this.$t('profile.tripDeleteFailed'))
            } finally {
                this.deletingTripId = null
            }
        },

        visibleDestinations(trip) {
            const places = trip.destinations || []
            return this.filter === 'all'
                ? places
                : places.filter(place => place.status === this.filter)
        },
       openModal() {
            this.tripForm = {
                title: '',
                description: '',
                date_from: '',
                date_till: '',
                budget: '',
                status: 'unvisited',
                category: '',
            }
            this.tripImage = null
            this.step = 1
            this.tripErrors = {}
            this.modal = true
            this.$nextTick(() => this.$refs.tripName?.focus())
        },
        closeModal() {
            this.modal = false;
            this.removeTripImage();
        },
        async nextTripStep() {
            this.tripErrors = {}
            if (this.step === 1) {
                if (!this.tripForm.title.trim()) {
                    this.tripErrors.title = [this.$t('add.required')]
                    return
                }
            }
            if (this.step === 2) {
                if (!this.tripForm.date_from) {
                    this.tripErrors.date_from = [this.$t('profile.dateFromRequired')]
                    return
                }
                if (!this.tripForm.date_till) {
                    this.tripErrors.date_till = [this.$t('profile.dateTillRequired')]
                    return
                }
                if (this.tripForm.date_till <= this.tripForm.date_from) {
                    this.tripErrors.date_till = [this.$t('profile.dateOrder')]
                    return
                }
                if (this.tripForm.budget !== '' && Number(this.tripForm.budget) < 0) {
                    this.tripErrors.budget = [this.$t('profile.budgetNegative')]
                    return
                }
            }
            this.step += 1
        },
        async createTrip() {
            if (this.creating) return
            this.creating = true
            this.tripErrors = {}
            try {
                const data = new FormData()
                data.append('user_id', String(this.user.id))
                Object.entries(this.tripForm).forEach(([key, value]) => {
                    if (value !== '' && value !== null && value !== undefined) {
                        data.append(key, String(value))
                    }
                })
                if (this.tripImage) {
                    data.append('image', this.tripImage)
                }
                const response = await axios.post('/api/trips', data, {
                    ...this.getAuthConfig(),
                })
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
                    category: '',
                }
                this.tripImage = null
                await this.loadTrips()
                this.showToast(this.$t('profile.tripCreated'))
            } catch (error) {
                console.error(
                    'Failed to create trip:',
                    error.response?.data || error.message
                )
                this.tripErrors = error.response?.data?.errors || {}
                if (error.response?.status === 401) {
                    this.showToast(this.$t('common.pleaseLogInAgain'))
                } else {
                    this.tripErrors.general = [
                        error.response?.data?.message || this.$t('profile.createFailed'),
                    ]
                    this.step = 3
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
                this.showToast(this.$t('profile.changesSaved'))
            } catch (error) {
                console.error(
                    'Neizdevās saglabāt izmaiņas:',
                    error.response?.data || error.message
                )
                this.errors =
                    error.response?.data?.errors || {}
                if (error.response?.status === 401) {
                    this.showToast(this.$t('common.pleaseLogInAgain'))
                } else if (Object.keys(this.errors).length === 0) {
                    this.showToast(this.$t('profile.saveFailed'))
                }
            } finally {
                this.saving = false
            }
        },
        async deleteAccount() {
            const confirmed = window.confirm(
                this.$t('profile.deleteConfirm')
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
                this.showToast(this.$t('profile.deleteFailed'))
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
            clearTimeout(this.toastTimer);
        }

        if (this.tripImagePreview) {
            URL.revokeObjectURL(this.tripImagePreview);
        }
    }
}
</script>

<style scoped>

@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

/* ---------- Base ---------- */
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

.profile,
.profile *,
.profile *::before,
.profile *::after {
    box-sizing: border-box;
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
.profile textarea:focus-visible,
.profile select:focus-visible {
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
    max-width: 21rem;
    margin: 0;
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
    flex: none;
    align-items: center;
    justify-content: center;
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
    color: var(--muted);
    font-size: 0.8rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

/* ---------- Stats ---------- */
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
    font-family: var(--serif);
    font-size: 3.3rem;
    font-weight: 400;
    line-height: 1;
}

.stats span {
    color: var(--muted);
    font-size: 0.75rem;
    letter-spacing: 0.06em;
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
    color: var(--muted);
    font-size: 0.8rem;
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
    color: var(--muted);
    font-family: var(--serif);
    font-size: 0.85rem;
    letter-spacing: 0.04em;
    cursor: pointer;
}

.tabs__item--on {
    border-bottom-color: #000;
    color: #000;
}

/* ---------- Trip grids ---------- */
.grid,
.trip-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin: 1.5rem 0 0;
    padding: 0;
    list-style: none;
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
    color: var(--muted);
    font-size: 0.7rem;
    letter-spacing: 0.06em;
}

.trip__desc {
    max-width: 40rem;
    margin: 1rem 0 1.5rem;
    font-size: 0.85rem;
    line-height: 1.45;
    text-transform: uppercase;
}

.trip-card {
    height: 15rem;
    padding: 0.75rem;
    border-radius: 1rem;
    background-position: center;
    background-size: cover;
    cursor: pointer;
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
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: linear-gradient(transparent 50%, rgba(0, 0, 0, 0.45));
    content: '';
}

.card__name {
    position: relative;
    z-index: 1;
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

.card--add {
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    border: 1px solid #111;
    background: #fff;
    color: #111;
    text-align: center;
    font-family: var(--serif);
    font-size: 0.9rem;
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

.trip-status-toggle {
    z-index: 2;
    border: 0;
    font: inherit;
    cursor: pointer;
}

.trip-status-toggle:disabled {
    opacity: 0.7;
    cursor: wait;
}

.trip-delete {
    position: absolute;
    right: 0.75rem;
    bottom: 0.75rem;
    z-index: 2;
    padding: 0.35rem 0.65rem;
    border: 1px solid rgba(255, 255, 255, 0.8);
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.35);
    color: #fff;
    font: inherit;
    font-size: 0.65rem;
    cursor: pointer;
}

.trip-delete:disabled {
    opacity: 0.6;
    cursor: wait;
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
    max-width: 15rem;
    margin: 0;
    font-size: 0.8rem;
    line-height: 1.4;
}

.account__form {
    display: flex;
    flex: 1 1 22rem;
    flex-direction: column;
    gap: 2rem;
    max-width: 39rem;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.field span {
    color: var(--muted);
    font-size: 0.7rem;
    letter-spacing: 0.06em;
}

.field input,
.field textarea,
.field select {
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

.field textarea {
    resize: vertical;
}

.field input::placeholder,
.field textarea::placeholder {
    color: #767676;
}

.field input:focus,
.field textarea:focus,
.field select:focus {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.field input[readonly] {
    color: var(--muted);
}

.field small,
.field__error {
    margin-top: 0.35rem;
    color: #c0392b;
    font-size: 0.72rem;
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
    opacity: 0.6;
    cursor: default;
}

.account__delete {
    padding: 0.85rem 0;
    border: 0;
    border-bottom: 1px solid #000;
    background: none;
    color: #000;
    font: inherit;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    cursor: pointer;
}

/* ---------- Modal: scroll fix ---------- */
.modal {
    position: fixed;
    inset: 0;
    z-index: 20;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 1rem;
    overflow-x: hidden;
    overflow-y: auto;
    overscroll-behavior: contain;
    background: rgba(0, 0, 0, 0.45);
    -webkit-overflow-scrolling: touch;
}

.modal__box {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    width: 100%;
    max-width: 30rem;
    max-height: calc(100vh - 2rem);
    height: min(740px, calc(100dvh - 2rem));
    min-height: 0;
    margin: auto 0;
    padding: 2rem 2rem;
    overflow-x: hidden;
    overflow-y: hidden;
    overscroll-behavior: contain;
    border-radius: 1.2rem;
    background: #fff;
    box-sizing: border-box;
    -webkit-overflow-scrolling: touch;
}

.modal__box h2 {
    font-size: 2rem;
    letter-spacing: 0.04em;
}

/* Scroll only the form body. Header and actions stay in place. */
.trip-form__content {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 0.35rem;
    overscroll-behavior: contain;
    scrollbar-gutter: stable;
}

.modal__box > .trip-stepper,
.modal__box > .trip-form__eyebrow,
.modal__box > h2,
.modal__box > .trip-form__navigation {
    flex-shrink: 0;
}

/* ---------- Trip form ---------- */
.trip-stepper {
    display: flex;
    gap: 0.55rem;
    margin-bottom: 0.25rem;
}

.trip-stepper__item {
    display: grid;
    flex: none;
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
    min-width: 0;
    min-height: 0;
    animation: trip-step-in 0.25s ease;
}

.trip-form__row {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.5rem;
}

.modal__box .field {
    min-width: 0;
    margin: 0 0 1.5rem;
}

.modal__box .field input,
.modal__box .field textarea,
.modal__box .field select {
    box-sizing: border-box;
}

.modal__box .field input[type='file'] {
    max-width: 100%;
    font-size: 0.8rem;
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
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #e7e7e7;
    background: #fff;
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

/* ---------- Polished trip photo upload ---------- */
.trip-photo-field {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    min-width: 0;
    margin-bottom: 1.4rem;
}
.trip-photo-field__label {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 0.35rem;
    color: #555;
    font-size: 0.7rem;
    letter-spacing: 0.06em;
}
.trip-photo-field__label small {
    font-size: 0.62rem;
    color: #888;
}
.trip-photo-input {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    overflow: hidden;
    clip-path: inset(50%);
}
.trip-photo-input:focus-visible + .trip-photo-preview,
.trip-photo-input:focus-visible + .trip-photo-dropzone {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}
.trip-photo-dropzone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    min-height: 150px;
    padding: 1.5rem 1rem;
    border: 1px dashed #aaa;
    border-radius: 0.85rem;
    background: #fafafa;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.trip-photo-dropzone:hover { border-color: #111; background: #f3f3f3; }
.trip-photo-dropzone__icon {
    display: grid;
    place-items: center;
    width: 2.3rem;
    height: 2.3rem;
    border: 1px solid #222;
    border-radius: 50%;
    font-size: 1.55rem;
    line-height: 1;
}
.trip-photo-dropzone strong { font-size: 0.75rem; font-weight: 400; letter-spacing: .07em; }
.trip-photo-dropzone > span:last-child { font-size: .65rem; color: #777; }
.trip-photo-preview {
    position: relative;
    width: 100%;
    height: 185px;
    overflow: hidden;
    border-radius: .85rem;
    background: #e8e8e8;
}
.trip-photo-preview__image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
.trip-photo-preview__overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: .85rem;
    background: linear-gradient(180deg, rgba(0,0,0,.45), transparent 45%, rgba(0,0,0,.65));
    color: white;
}
.trip-photo-preview__caption { font-size: .65rem; letter-spacing: .12em; }
.trip-photo-preview__actions { display: flex; flex-wrap: wrap; gap: .55rem; }
.trip-photo-preview__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 2rem;
    padding: .4rem .85rem;
    border: 1px solid rgba(255,255,255,.85);
    border-radius: 999px;
    background: rgba(0,0,0,.38);
    color: white;
    font: inherit;
    font-size: .65rem;
    letter-spacing: .04em;
    cursor: pointer;
}
.trip-photo-preview__button:hover { background: #111; }
.trip-photo-error { color: #c0392b; font-size: .72rem; }

/* ---------- Toast ---------- */
.toast {
    position: fixed;
    top: 1.5rem;
    left: 50%;
    z-index: 30;
    padding: 1rem 1.8rem;
    transform: translateX(-50%);
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
    transform: translate(-50%, -1rem);
    opacity: 0;
}

/* ---------- Animations ---------- */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
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

/* ---------- Responsive ---------- */
@media (max-width: 900px) {
    .grid,
    .trip-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

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
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }

    .account {
        padding-top: 3.5rem;
    }
}

@media (max-width: 600px) {
    .grid,
    .trip-grid {
        grid-template-columns: 1fr;
    }

    .trip-form__row {
        grid-template-columns: minmax(0, 1fr);
        gap: 0;
    }

    .modal {
        padding: 0.5rem;
    }

    .modal__box {
        gap: 1rem;
        max-height: calc(100vh - 1rem);
        height: calc(100dvh - 1rem);
        padding: 1.25rem 1rem;
        border-radius: 1rem;
    }

    .modal__box h2 {
        font-size: 1.7rem;
    }

    .form-step {
        min-height: 0;
    }

    .trip-photo-preview { height: 160px; }
    .trip-photo-dropzone { min-height: 135px; }

    .trip-review {
        padding: 1rem;
    }

    .trip-form__navigation {
        gap: 0.5rem;
    }

    .trip-form__navigation .account__save {
        min-height: 2.75rem;
        padding: 0 1.1rem;
    }

    .profile__hero h1 {
        left: 1rem;
        font-size: clamp(3rem, 12vw, 5rem);
    }
}

@media (prefers-reduced-motion: reduce) {
    .form-step {
        animation: none;
    }

    .card {
        transition: none;
    }
}

</style>