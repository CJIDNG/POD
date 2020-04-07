import designation from './designation'
import data from './data'
import member from './member'
import partner from './partner'
import platforms from './platforms'
import posts from './posts'
import roles from './roles'
import service from './service'
import settings from './settings'
import stats from './stats'
import tracker from './tracker'
import trackerItem from './trackerItem'
import users from './users'
import { hasSubapp } from './../../util/has-subapp'

let adminRoutes = [
  {
    path: '/admin',
    name: 'dashboard',
    component: require('../../screens/admin/dashboard/Index').default,
  },
  ...partner,
  ...platforms,
  ...roles,
  ...users,
  ...settings,
]

if (hasSubapp('data')) {
  adminRoutes.push(...data)
}

if (hasSubapp('analytics')) {
  adminRoutes.push(...stats)
} 

if (hasSubapp('blog')) {
  adminRoutes.push(...posts)
}

if (hasSubapp('members')) {
  adminRoutes.push(...designation, ...member)
}

if (hasSubapp('services')) {
  adminRoutes.push(...service)
}

if (hasSubapp('tracker')) {
  adminRoutes.push(...tracker, ...trackerItem)
}

export default adminRoutes
