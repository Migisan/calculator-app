import Vue from 'vue'
import VueRouter from 'vue-router'

import Calculator from './pages/Calculator.vue'
import Log from './pages/Log.vue'
import NotFound from './pages/NotFound.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: Calculator,
  },
  {
    path: '/log',
    component: Log,
  },
  {
    path: '*',
    component: NotFound
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router