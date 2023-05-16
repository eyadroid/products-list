import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueAxios from 'vue-axios'
import axios from './axiosInstance'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)

app.mount('#app')
