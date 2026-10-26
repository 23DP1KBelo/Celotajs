<template>
    <main class="admin">
        <transition name="toast">
            <div v-if="toast" class="toast" role="status">{{ toast }}</div>
        </transition>

        <section class="admin__intro">
            <h1>{{ $t('admin.title') }}<br>{{ $t('admin.titleEnd') }}</h1>
            <p>{{ $t('admin.intro') }}</p>

            <div class="stats">
                <div>
                    <strong>{{ users.length }}</strong>
                    <span>{{ $t('admin.users') }}</span>
                </div>
                <div>
                    <strong>{{ adminCount }}</strong>
                    <span>{{ $t('admin.admins') }}</span>
                </div>
                <div>
                    <strong>{{ destinations.length }}</strong>
                    <span>{{ $t('admin.destinations') }}</span>
                </div>
                <div>
                    <strong>{{ recommendedCount }}</strong>
                    <span>{{ $t('admin.recommended') }}</span>
                </div>
            </div>
        </section>

        <section class="admin__main">
            <div class="admin__head">
                <div class="tabs" role="tablist">
                    <button
                        v-for="item in tabs"
                        :key="item.value"
                        type="button"
                        role="tab"
                        class="tabs__item"
                        :class="{ 'tabs__item--on': tab === item.value }"
                        :aria-selected="tab === item.value"
                        @click="tab = item.value"
                    >
                        {{ $t(item.label) }}
                    </button>
                </div>

                <label class="search">
                    <svg width="22" height="22" viewBox="0 0 30 30" aria-hidden="true">
                        <circle cx="13" cy="13" r="10" fill="none" stroke="currentColor" stroke-width="1" />
                        <path d="M20.5 20.5L28 28" stroke="currentColor" stroke-width="1" />
                    </svg>
                    <input
                        v-model.trim="search"
                        type="search"
                        :placeholder="tab === 'users' ? $t('admin.searchUsers') : $t('admin.searchDestinations')"
                        :aria-label="tab === 'users' ? $t('admin.searchUsersLabel') : $t('admin.searchDestinationsLabel')"
                    >
                </label>
            </div>

            <p v-if="loading" class="empty">{{ $t('common.loading') }}</p>

            <!-- ---------- Users ---------- -->
            <template v-else-if="tab === 'users'">
                <ul v-if="filteredUsers.length" class="rows">
                    <li v-for="user in filteredUsers" :key="user.id" class="row">
                        <div class="row__main">
                            <span class="row__title">{{ user.username }}</span>
                            <span class="row__meta">
                                {{ user.email }} · {{ $t('admin.trips', { count: user.trips_count }) }} · {{ $t('admin.since', { year: year(user.created_at) }) }}
                            </span>
                        </div>

                        <div class="row__actions">
                            <span v-if="user.id === me?.id" class="badge badge--dark">{{ $t('admin.you') }}</span>

                            <label v-else class="select">
                                <select
                                    :value="user.role"
                                    :aria-label="$t('admin.roleFor', { name: user.username })"
                                    @change="changeRole(user, $event.target.value)"
                                >
                                    <option value="user">{{ $t('admin.roleUser') }}</option>
                                    <option value="admin">{{ $t('admin.roleAdmin') }}</option>
                                </select>
                                <span class="select__arrow" aria-hidden="true">V</span>
                            </label>

                            <button
                                v-if="user.id !== me?.id"
                                type="button"
                                class="link link--danger"
                                @click="deleteUser(user)"
                            >
                                {{ $t('common.delete') }}
                            </button>
                        </div>
                    </li>
                </ul>

                <p v-else class="empty">{{ $t('admin.noUsers') }}</p>
            </template>

            <!-- ---------- Destinations ---------- -->
            <template v-else>
                <ul v-if="filteredDestinations.length" class="rows">
                    <li
                        v-for="destination in filteredDestinations"
                        :key="destination.id"
                        class="row"
                        :class="{ 'row--open': editing?.id === destination.id }"
                    >
                        <div class="row__main">
                            <span class="row__title">{{ destination.title }}</span>
                            <span class="row__meta">
                                {{ placeName(destination) }} · {{ $t('admin.trips', { count: destination.trips_count }) }}
                            </span>
                        </div>

                        <div class="row__actions">
                            <button
                                type="button"
                                class="badge"
                                :class="{ 'badge--dark': destination.recommended }"
                                :disabled="!destination.trips_count"
                                :title="destination.trips_count ? '' : $t('admin.notLinked')"
                                @click="toggleRecommended(destination)"
                            >
                                {{ destination.recommended ? $t('admin.isRecommended') : $t('admin.recommend') }}
                            </button>

                            <button type="button" class="link" @click="startEdit(destination)">
                                {{ editing?.id === destination.id ? $t('admin.close') : $t('admin.edit') }}
                            </button>

                            <button type="button" class="link link--danger" @click="deleteDestination(destination)">
                                {{ $t('common.delete') }}
                            </button>
                        </div>

                        <form
                            v-if="editing?.id === destination.id"
                            class="edit"
                            @submit.prevent="saveDestination"
                        >
                            <label class="field">
                                <span>{{ $t('admin.fieldTitle') }}</span>
                                <input v-model.trim="editing.title" type="text" required>
                                <small v-if="errors.title">{{ errors.title[0] }}</small>
                            </label>

                            <label class="field">
                                <span>{{ $t('admin.fieldPlace') }}</span>
                                <select v-model="editing.places_id">
                                    <option v-for="place in places" :key="place.id" :value="place.id">
                                        {{ place.name.toUpperCase() }}
                                    </option>
                                </select>
                                <small v-if="errors.places_id">{{ errors.places_id[0] }}</small>
                            </label>

                            <label class="field field--wide">
                                <span>{{ $t('common.description') }}</span>
                                <textarea v-model="editing.description" rows="4"></textarea>
                                <small v-if="errors.description">{{ errors.description[0] }}</small>
                            </label>

                            <div class="edit__actions">
                                <button type="submit" class="save" :disabled="saving">
                                    {{ saving ? $t('common.saving') : $t('common.saveChanges') }}
                                </button>
                                <button type="button" class="link" @click="editing = null">{{ $t('common.cancel') }}</button>
                            </div>
                        </form>
                    </li>
                </ul>

                <p v-else class="empty">{{ $t('admin.noDestinations') }}</p>
            </template>
        </section>
    </main>
</template>

<script>
import axios from 'axios'
import { auth, fetchUser } from '../../auth.js'

export default {
    data() {
        return {
            tab: 'users',
            tabs: [
                { value: 'users', label: 'admin.users' },
                { value: 'destinations', label: 'admin.destinations' }
            ],
            search: '',
            users: [],
            destinations: [],
            places: [],
            loading: true,
            editing: null,
            errors: {},
            saving: false,
            toast: '',
            toastTimer: null
        }
    },

    computed: {
        me() {
            return auth.user
        },

        adminCount() {
            return this.users.filter(user => user.role === 'admin').length
        },

        recommendedCount() {
            return this.destinations.filter(destination => destination.recommended).length
        },

        filteredUsers() {
            const query = this.search.toLowerCase()

            return this.users.filter(user =>
                !query ||
                user.username?.toLowerCase().includes(query) ||
                user.email?.toLowerCase().includes(query)
            )
        },

        filteredDestinations() {
            const query = this.search.toLowerCase()

            return this.destinations.filter(destination =>
                !query ||
                destination.title?.toLowerCase().includes(query) ||
                this.placeName(destination).toLowerCase().includes(query)
            )
        }
    },

    watch: {
        tab() {
            this.search = ''
            this.editing = null
        }
    },

    async mounted() {
        await fetchUser()

        if (auth.user?.role !== 'admin') {
            await this.$router.push('/')
            return
        }

        await this.loadAll()
    },

    beforeUnmount() {
        clearTimeout(this.toastTimer)
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

        async loadAll() {
            this.loading = true

            try {
                const config = this.getAuthConfig()

                const [users, destinations, places] = await Promise.all([
                    axios.get('/api/admin/users', config),
                    axios.get('/api/admin/destinations', config),
                    axios.get('/api/places', config)
                ])

                this.users = users.data.data
                this.destinations = destinations.data.data
                this.places = places.data.data
            } catch (error) {
                console.error('Failed to load admin data:', error.response?.data || error.message)
                this.showToast(this.$t('admin.loadFailed'))
            } finally {
                this.loading = false
            }
        },

        async changeRole(user, role) {
            const previous = user.role
            user.role = role

            try {
                await axios.put(`/api/admin/users/${user.id}/role`, { role }, this.getAuthConfig())
                this.showToast(this.$t('admin.roleChanged', {
                    name: user.username.toUpperCase(),
                    role: this.$t(role === 'admin' ? 'admin.roleAdmin' : 'admin.roleUser')
                }))
            } catch (error) {
                user.role = previous
                this.showError(error)
            }
        },

        async deleteUser(user) {
            const confirmed = window.confirm(
                this.$t('admin.confirmDeleteUser', { name: user.username })
            )

            if (!confirmed) return

            try {
                await axios.delete(`/api/admin/users/${user.id}`, this.getAuthConfig())
                this.users = this.users.filter(item => item.id !== user.id)
                this.showToast(this.$t('admin.userDeleted'))
            } catch (error) {
                this.showError(error)
            }
        },

        startEdit(destination) {
            this.errors = {}

            this.editing = this.editing?.id === destination.id
                ? null
                : {
                    id: destination.id,
                    title: destination.title,
                    description: destination.description || '',
                    places_id: destination.places_id
                }
        },

        async saveDestination() {
            this.errors = {}
            this.saving = true

            try {
                const { id, ...payload } = this.editing
                const { data } = await axios.put(`/api/admin/destinations/${id}`, payload, this.getAuthConfig())

                const index = this.destinations.findIndex(item => item.id === id)
                this.destinations[index] = { ...this.destinations[index], ...data.data }

                this.editing = null
                this.showToast(this.$t('admin.destinationSaved'))
            } catch (error) {
                this.errors = error.response?.data?.errors || {}
                if (!Object.keys(this.errors).length) this.showError(error)
            } finally {
                this.saving = false
            }
        },

        async toggleRecommended(destination) {
            const recommended = !destination.recommended

            try {
                await axios.put(
                    `/api/admin/destinations/${destination.id}/recommend`,
                    { recommended },
                    this.getAuthConfig()
                )
                destination.recommended = recommended
                this.showToast(this.$t(recommended ? 'admin.shownOnDiscover' : 'admin.removedFromDiscover'))
            } catch (error) {
                this.showError(error)
            }
        },

        async deleteDestination(destination) {
            const confirmed = window.confirm(
                this.$t('admin.confirmDeleteDestination', { name: destination.title })
            )

            if (!confirmed) return

            try {
                await axios.delete(`/api/admin/destinations/${destination.id}`, this.getAuthConfig())
                this.destinations = this.destinations.filter(item => item.id !== destination.id)
                this.showToast(this.$t('admin.destinationDeleted'))
            } catch (error) {
                this.showError(error)
            }
        },

        placeName(destination) {
            const place = destination.place
            if (!place) return ''

            return place.country?.name
                ? `${place.name} | ${place.country.name}`.toUpperCase()
                : place.name.toUpperCase()
        },

        year(date) {
            const parsed = new Date(date)
            return Number.isNaN(parsed.getTime()) ? '' : parsed.getFullYear()
        },

        showError(error) {
            console.error(error.response?.data || error.message)

            if (error.message === 'AUTH_REQUIRED' || error.response?.status === 401) {
                this.showToast(this.$t('common.pleaseLogInAgain'))
            } else {
                this.showToast(error.response?.data?.message?.toUpperCase() || this.$t('admin.somethingWrong'))
            }
        },

        showToast(message) {
            clearTimeout(this.toastTimer)
            this.toast = message
            this.toastTimer = setTimeout(() => (this.toast = ''), 2500)
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Italiana&family=Jost:wght@300;400&display=swap');

.admin {
    --muted: #555;
    --link: #5aa9e6;
    --danger: #c0392b;
    --serif: 'Italiana', serif;

    display: grid;
    grid-template-columns: minmax(0, 0.7fr) minmax(0, 1.5fr);
    gap: 3rem;
    align-items: start;
    min-height: calc(100vh - 4.5rem);
    padding: 3rem 2rem 6rem 1.5rem;
    background: #fff;
    color: #000;
    font-family: 'Jost', system-ui, sans-serif;
    font-weight: 300;
    letter-spacing: 0.02em;
}

.admin button:focus-visible,
.admin input:focus-visible,
.admin select:focus-visible,
.admin textarea:focus-visible {
    outline: 2px solid var(--link);
    outline-offset: 3px;
}

/* ---------- Intro ---------- */
.admin__intro {
    position: sticky;
    top: 2rem;
}

.admin__intro h1 {
    margin: 0 0 2rem;
    font-family: var(--serif);
    font-weight: 400;
    font-size: clamp(2.6rem, 5.2vw, 4.5rem);
    line-height: 1.1;
    letter-spacing: 0.03em;
    overflow-wrap: break-word;
}

.admin__intro p {
    margin: 0;
    max-width: 21rem;
    font-size: 1.05rem;
    line-height: 1.35;
    font-weight: 400;
}

.stats {
    display: grid;
    grid-template-columns: repeat(2, max-content);
    gap: 1.8rem 3rem;
    margin-top: 3rem;
}

.stats div {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.stats strong {
    font-family: var(--serif);
    font-weight: 400;
    font-size: 3rem;
    line-height: 1;
}

.stats span {
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

/* ---------- Tabs + search ---------- */
.admin__head {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem 2rem;
    margin-bottom: 1.5rem;
}

.tabs {
    display: flex;
    gap: 2rem;
}

.tabs__item {
    padding: 0.5rem 0;
    border: 0;
    border-bottom: 1px solid transparent;
    background: none;
    font-family: var(--serif);
    font-size: 1.3rem;
    letter-spacing: 0.04em;
    color: var(--muted);
    cursor: pointer;
}

.tabs__item--on {
    border-bottom-color: #000;
    color: #000;
}

.search {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex: 0 1 18rem;
    padding-bottom: 0.4rem;
    border-bottom: 1px solid #555;
    color: var(--muted);
}

.search input {
    flex: 1;
    min-width: 0;
    border: 0;
    background: transparent;
    font-family: var(--serif);
    font-size: 1rem;
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

/* ---------- Rows ---------- */
.rows {
    margin: 0;
    padding: 0;
    list-style: none;
    border-top: 1px solid #777;
}

.row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 0.8rem 1.5rem;
    padding: 1.3rem 0.5rem;
    border-bottom: 1px solid #aaa;
}

.row--open {
    background: #fafafa;
}

.row__main {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    min-width: 0;
}

.row__title {
    font-family: var(--serif);
    font-size: 1.25rem;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.row__meta {
    font-size: 0.75rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: var(--muted);
    overflow-wrap: anywhere;
}

.row__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.8rem 1.5rem;
}

.badge {
    padding: 0.35rem 0.9rem;
    border: 1px solid #000;
    border-radius: 999px;
    background: #fff;
    color: #000;
    font: inherit;
    font-size: 0.7rem;
    font-weight: 400;
    letter-spacing: 0.06em;
    cursor: pointer;
}

.badge--dark {
    background: #000;
    color: #fff;
}

.badge:disabled {
    border-color: #bbb;
    color: #999;
    cursor: not-allowed;
}

span.badge {
    cursor: default;
}

.link {
    padding: 0.3rem 0;
    border: 0;
    border-bottom: 1px solid #000;
    background: none;
    font: inherit;
    font-size: 0.72rem;
    letter-spacing: 0.06em;
    color: #000;
    cursor: pointer;
}

.link--danger {
    border-bottom-color: var(--danger);
    color: var(--danger);
}

.select {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.select select {
    padding: 0.2rem 1.4rem 0.2rem 0;
    border: 0;
    background: transparent;
    font-family: var(--serif);
    font-size: 0.95rem;
    letter-spacing: 0.04em;
    color: #000;
    appearance: none;
    cursor: pointer;
}

.select__arrow {
    position: absolute;
    right: 0;
    font-family: var(--serif);
    font-size: 0.9rem;
    color: var(--muted);
    pointer-events: none;
}

/* ---------- Edit form ---------- */
.edit {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1.5rem 2rem;
    flex-basis: 100%;
    padding-top: 1rem;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.field--wide {
    grid-column: 1 / -1;
}

.field span {
    font-size: 0.7rem;
    letter-spacing: 0.06em;
    color: var(--muted);
}

.field input,
.field select,
.field textarea {
    padding: 0.6rem 0;
    border: 0;
    border-bottom: 1px solid #767676;
    border-radius: 0;
    background: transparent;
    font: inherit;
    font-size: 0.9rem;
    color: #000;
    outline: none;
    resize: vertical;
}

.field input:focus,
.field select:focus,
.field textarea:focus {
    border-bottom-color: #000;
    box-shadow: 0 1px 0 #000;
}

.field small {
    font-size: 0.7rem;
    color: var(--danger);
}

.edit__actions {
    grid-column: 1 / -1;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem 1.75rem;
}

.save {
    min-height: 3rem;
    padding: 0 2.8rem;
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

.save:hover {
    background: #222;
}

.save:disabled {
    cursor: default;
    opacity: 0.6;
}

.empty {
    margin: 2rem 0;
    font-size: 0.85rem;
    color: var(--muted);
}

/* ---------- Toast ---------- */
.toast {
    position: fixed;
    top: 1.5rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
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

/* ---------- Mobile / tablet ---------- */
@media (max-width: 960px) {
    .admin {
        grid-template-columns: 1fr;
        gap: 2.5rem;
        padding: 2rem 1rem 4rem;
    }

    .admin__intro {
        position: static;
    }

    .stats {
        grid-template-columns: repeat(4, max-content);
        gap: 1.5rem 2rem;
    }
}

@media (max-width: 560px) {
    .stats {
        grid-template-columns: repeat(2, max-content);
    }

    .stats strong {
        font-size: 2.4rem;
    }

    .search {
        flex-basis: 100%;
    }

    .edit {
        grid-template-columns: 1fr;
    }
}
</style>
