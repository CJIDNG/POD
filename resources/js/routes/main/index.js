import blog from './blog'
import data from './data'
import governmentProjects from './government-projects'
import incident from './incident'
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

if (hasSubapp('governmentProject')) {
  mainRoutes.push(...governmentProjects)
}

if (hasSubapp('incident')) {
  mainRoutes.push(...incident)
}

export default mainRoutes
