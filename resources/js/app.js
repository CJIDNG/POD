import Vue from 'vue'
import VueRouter from 'vue-router'
import moment from 'moment-timezone'
import ComponentMixin from "./mixins/ComponentMixin"
import HelperMixin from "./mixins/HelperMixin"
import RequestMixin from "./mixins/RequestMixin"
import MetaMixin from "./mixins/MetaMixin"
import VueHolder from 'vue-holderjs'
import { createRouter } from './router'
import { createStore } from './store'
import { sync } from 'vuex-router-sync'

// https://ckeditor.com/blog/best-wysiwyg-editor-for-vue/
import CKEditor from '@ckeditor/ckeditor5-vue';

// import VueFormGenerator from 'vue-form-generator'
// import 'vue-form-generator/dist/vfg.css'

// Vue.use(VueFormGenerator)

require('bootstrap')

window.Popper = require('popper.js').default

Vue.mixin(ComponentMixin)
Vue.mixin(HelperMixin)
Vue.mixin(RequestMixin)
Vue.mixin(MetaMixin)

// Set the default timezone
moment.tz.setDefault(CurrentTenant.timezone)

// Prevent the production tip on Vue startup
Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueHolder)
Vue.use(CKEditor)

// const router = new VueRouter({
//   routes: Routes,
//   mode: 'history',
//   base: CurrentTenant.path,
// })

// NProgress.configure({
//   showSpinner: false,
//   easing: 'ease',
//   speed: 300,
// })

// router.beforeEach((to, from, next) => {
//   NProgress.start()
//   next()
// })

export function createApp() {
  // create router instance
  const router = createRouter()
  const store = createStore()

  // sync so that route state is available as part of the store
  sync(store, router)

  const app = new Vue({
    el: '#app',
    router,
    store,
  
    data: {
      avatar: CurrentTenant.avatar
    },
  
    mounted() {
      this.$root.$on('updateAvatar', this.updateAvatar)
    },
  
    methods: {
      updateAvatar(url) {
        this.$root.avatar = url
      }
    }
  })
  
  // Give the store access to the root Vue instance
  store.$app = app

  return { app, router, store }
}
