import agency from './agency'
import data from './data'
import governmentProject from './governmentProject'
import healthFacility from './health-facility'
import incident from './incident'
import localGovernment from './localGovernment'
import ministry from './ministry'
import platforms from './platforms'
import posts from './posts'
import roles from './roles'
import settings from './settings'
import state from './state'
import stats from './stats'
import status from  './status'
import type from './type'
import users from './users'
import { hasSubapp } from './../../util/has-subapp'

let adminRoutes = [
  {
    path: '/admin',
    name: 'dashboard',
    component: require('../../screens/admin/dashboard/Index').default,
  },
  ...roles,
  ...users,
  ...settings,
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

if (hasSubapp('status')) {
  adminRoutes.push(...status)
}

if (hasSubapp('type')) {
  adminRoutes.push(...type)
}

if (hasSubapp('platform')) {
  adminRoutes.push(...platforms)
}

if (hasSubapp('analytics')) {
  adminRoutes.push(...stats)
} 

if (hasSubapp('blog')) {
  adminRoutes.push(...posts)
}

export default adminRoutes
