require('./bootstrap');

import { createApp } from 'vue'
import App from './components/App.vue'
import router from './routes'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

const app = createApp(App)
    .use(router)
app.mount('#app')
