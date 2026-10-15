import { reactive } from 'vue'
import en from './lang/en.js'
import lv from './lang/lv.js'

const messages = { en, lv }

function savedLocale() {
    try {
        const locale = localStorage.getItem('locale')
        return messages[locale] ? locale : 'en'
    } catch {
        return 'en'
    }
}

export const i18n = reactive({
    locale: savedLocale()
})

function lookup(locale, key) {
    return key.split('.').reduce((value, part) => value?.[part], messages[locale])
}

// Iztulko atslēgu, piem. t('nav.home') vai t('admin.since', { year: 2026 })
export function t(key, params = {}) {
    const text = lookup(i18n.locale, key) ?? lookup('en', key) ?? key

    return String(text).replace(/\{(\w+)\}/g, (match, name) => params[name] ?? match)
}

// Nomaina valodu un atceras to nākamajai reizei
export function setLocale(locale) {
    if (!messages[locale]) return

    i18n.locale = locale
    document.documentElement.lang = locale

    try {
        localStorage.setItem('locale', locale)
    } catch {
        // localStorage var nebūt pieejams (piem. privātais režīms)
    }
}

export default {
    install(app) {
        document.documentElement.lang = i18n.locale
        app.config.globalProperties.$t = t
    }
}
