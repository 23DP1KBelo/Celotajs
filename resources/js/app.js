import { createApp } from 'vue'
import App from './components/app.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import i18n from './i18n'

createApp(App)
    .use(router)
    .use(vuetify)
    .use(i18n)
    .mount('#app')