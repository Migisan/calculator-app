import Vue from 'vue'
// import './bootstrap'
import router from './router'
import App from './App.vue'

const createApp = async() =>{
    new Vue({
        el: '#app',
        router,
        components: { App },
        template: '<App />'
    })
}

createApp()