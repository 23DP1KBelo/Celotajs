import { createApp } from 'vue'
import App from './components/app.vue'
import vuetify from './plugins/vuetify'
import router from './router'

createApp(App)
    .use(router)
    .use(vuetify)
    .mount('#app')