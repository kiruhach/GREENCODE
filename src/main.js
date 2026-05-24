import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './router'
import fadeIn from './directives/fadeIn'

const app = createApp(App)
app.directive('fade-in', fadeIn)
app.use(router)
app.mount('#app')