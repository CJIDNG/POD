import agency from './agency'
import designation from './designation'
import data from './data'
import governmentProject from './governmentProject'
import healthFacility from './health-facility'
import incident from './incident'
import localGovernment from './localGovernment'
import member from './member'
import ministry from './ministry'
import partner from './partner'
import platforms from './platforms'
import posts from './posts'
import roles from './roles'
import service from './service'
import settings from './settings'
import state from './state'
import stats from './stats'
import status from  './status'
import tracker from './tracker'
import trackerItem from './trackerItem'
import type from './type'
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
  ...status,
  ...type
]

if (hasSubapp('agency')) {
  adminRoutes.push(...agency)
}

if (hasSubapp('data')) {
  adminRoutes.push(...data)
}

if (hasSubapp('governmentProject')) {
  adminRoutes.push(...governmentProject)
}

if (hasSubapp('health-facility')) {
  adminRoutes.push(...healthFacility)
}

if (hasSubapp('incident')) {
  adminRoutes.push(...incident)
}

if (hasSubapp('location')) {
  adminRoutes.push(...state, ...localGovernment)
}

if (hasSubapp('ministry')) {
  adminRoutes.push(...ministry)
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
