import './assets/sass/main.scss'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueAxios from 'vue-axios'
import { vue3Debounce } from 'vue-debounce'
import { createHead } from '@unhead/vue'
import axios from './axiosInstance'

import App from './App.vue'
import router from './router'

import { getSize, getWeight } from './utils/utils'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)
app.use(createHead())
app.directive('debounce', vue3Debounce({ lock: true }))
app.mixin({
  methods: {
    $getSize: getSize,
    $getWeight: getWeight
  }
})

app.mount('#app')
