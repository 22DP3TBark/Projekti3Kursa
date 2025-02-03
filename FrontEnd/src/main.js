
import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import api from './Plugins/VUEapi.js'


import 'primeicons/primeicons.css'

import App from './App.vue'
import router from './router'

const app = createApp(App)
app.config.globalProperties.$api = api;
app.use(createPinia())
app.use(router)

app.mount('#app')
