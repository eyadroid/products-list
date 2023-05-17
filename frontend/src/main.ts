import './assets/sass/main.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueAxios from 'vue-axios'
import { vue3Debounce } from 'vue-debounce'
import axios from './axiosInstance'

import App from './App.vue'
import router from './router'

import {getSize} from './utils/utils'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)
app.directive('debounce', vue3Debounce({ lock: true }))
app.mixin({
    methods: {
        $getSize: getSize
    }
})

app.mount('#app')
