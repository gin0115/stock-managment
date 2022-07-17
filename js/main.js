import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import BalmUI from 'balm-ui'; // Official Google Material Components
import BalmUIPlus from 'balm-ui/dist/balm-ui-plus'; // BalmJS Team Material Components

import './assets/main.css'
import 'balm-ui-css';

const app = createApp(App)

app.use(router)
app.use(BalmUI); // Mandatory
app.use(BalmUIPlus); // Optional

app.mount('#app')