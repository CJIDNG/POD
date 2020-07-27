import Vue from 'vue'
import Routes from './routes'
import { store } from './store'
import NProgress from 'nprogress'
import VueRouter from 'vue-router'
import moment from 'moment-timezone'
import ComponentMixin from "./mixins/ComponentMixin"
import HelperMixin from "./mixins/HelperMixin"
import RequestMixin from "./mixins/RequestMixin"
import MetaMixin from "./mixins/MetaMixin"
import VueHolder from 'vue-holderjs'
import Permission from './directives/Permission'

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

Vue.directive('permission', Permission)

// Set the default timezone
moment.tz.setDefault(CurrentTenant.timezone)

// Prevent the production tip on Vue startup
Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueHolder)
Vue.use(CKEditor)

const router = new VueRouter({
  routes: Routes,
  mode: 'history',
  base: CurrentTenant.path,
})

NProgress.configure({
  showSpinner: false,
  easing: 'ease',
  speed: 300,
})

router.beforeEach((to, from, next) => {
  NProgress.start()
  next()
})

const app = new Vue({
  el: '#app',
  router,
  store,

  data: {
    avatar: CurrentTenant.avatar
  },

  mounted () {
    this.$root.$on('updateAvatar', this.updateAvatar)
  },

  methods: {
    updateAvatar (url) {
      this.$root.avatar = url
    }
  }
})

// Give the store access to the root Vue instance
store.$app = app
