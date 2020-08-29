import analytics from './analytics'
import data from './data'
import platforms from './platforms'
import posts from './posts'
import roles from './roles'
import settings from './settings'
import tracker from './tracker'
import trackerItem from './trackerItem'
import users from './users'
import location from './location'
import { hasSubapp } from './../../util/has-subapp'

let adminRoutes = [
  {
    path: '/admin',
    name: 'dashboard',
    redirect: '/admin/stats',
  },
  ...platforms,
  ...roles,
  ...users,
  ...settings,
  ...analytics,
  ...location,
]

if (hasSubapp('data')) {
  adminRoutes.push(...data)
}

if (hasSubapp('blog')) {
  adminRoutes.push(...posts)
}

if (hasSubapp('tracker')) {
  adminRoutes.push(...tracker, ...trackerItem)
}

export default adminRoutes
