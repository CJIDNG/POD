import Vue from 'vue'
import Routes from './routes'
import { store } from './store'
import NProgress from 'nprogress'
import VueRouter from 'vue-router'
import moment from 'moment-timezone'
import HelperMixin from "./mixins/HelperMixin"
import RequestMixin from "./mixins/RequestMixin"
import VueHolder from 'vue-holderjs'

// https://ckeditor.com/blog/best-wysiwyg-editor-for-vue/
import CKEditor from '@ckeditor/ckeditor5-vue';

require('bootstrap')

window.Popper = require('popper.js').default

if (/starfolksoftware/.test(CurrentTenant.platform.name)) {
  require('../../public/assets/themes/argon/assets/css/argon-design-system.min.css?v=1.2.0')
}

Vue.mixin(HelperMixin)
Vue.mixin(RequestMixin)

// Set the default timezone
moment.tz.setDefault(CurrentTenant.timezone)

// Prevent the production tip on Vue startup
Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueHolder);
Vue.use( CKEditor );

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
