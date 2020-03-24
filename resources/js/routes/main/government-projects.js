export default [
  {
    path: '/projects',
    name: 'government-projects',
    component: require('../../screens/main/project/GovernmentProjectIndex').default,
  },
  {
    path: '/projects/:id/show',
    name: 'government-projects-show',
    component: require('../../screens/main/project/GovernmentProjectShow').default
  },
]
