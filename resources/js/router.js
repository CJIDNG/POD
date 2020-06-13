// router.js
import Vue from 'vue'
import Router from 'vue-router'
import Routes from './routes'
import NProgress from 'nprogress'

Vue.use(Router)

NProgress.configure({
  showSpinner: false,
  easing: 'ease',
  speed: 300,
})

export function createRouter () {
  const router = new Router({
    routes: Routes,
    mode: 'history',
    base: CurrentTenant.path,
  })

  router.beforeEach((to, from, next) => {
    NProgress.start()
    next()
  })

  return router
}
