import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'

import BalmUI from 'balm-ui'; // Official Google Material Components
import BalmUIPlus from 'balm-ui/dist/balm-ui-plus'; // BalmJS Team Material Components
import 'balm-ui/components/icon/icon.css';
import './assets/main.css'
import 'balm-ui-css';

const app = createApp(App)

const pinia = createPinia()

app.use(router)
app.use(BalmUI)
app.use(BalmUIPlus)
app.use(pinia)

app.mount('#app')