import blog from './blog'
import data from './data'
import member from './member'
import product from './product'
import trackerItem from './trackerItem'
import { hasSubapp } from './../../util/has-subapp'
let mainRoutes = [
  {
    path: '/',
    name: 'home',
    component: require('../../screens/main/home/HomeIndex').default,
  },
  {
    path: '/about',
    name: 'about',
    component: require('../../screens/main/about/AboutIndex').default,
  },
  {
    path: '/contact',
    name: 'contact',
    component: require('../../screens/main/contact/ContactIndex').default,
  },
  {
    path: '/login',
    name: 'login',
    redirect: '/login',
  },
  {
    path: '/register',
    name: 'register',
    redirect: '/register',
  },
  {
    path: '/password/reset',
    name: 'forgot-password',
    redirect: '/password/reset',
  },
  {
    path: '/settings',
    name: 'main-settings-show',
    component: require('../../screens/main/settings/SettingsShow').default,
  },
  {
    path: '/faac-facts',
    name: 'faac-facts',
    component: require('../../statics/narep/faac-facts/Home.vue').default,
  },
  {
    path: '*',
    name: 'catch-all',
    redirect: '/',
  },
]

if (hasSubapp('blog')) {
  mainRoutes.push(...blog)
}

if (hasSubapp('data')) {
  mainRoutes.push(...data)
}

if (hasSubapp('members')) {
  mainRoutes.push(...member)
}

if (hasSubapp('products')) {
  mainRoutes.push(...product)
}

if (hasSubapp('tracker')) {
  mainRoutes.push(...trackerItem)
}

export default mainRoutes
