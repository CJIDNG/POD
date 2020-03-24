export default [
  {
    path: '/admin/governmentProjects',
    name: 'governmentProjects',
      component: require('../../screens/admin/governmentProjects/GovernmentProjectIndex').default,
  },
  {
      path: '/admin/governmentProjects/create',
      name: 'governmentProjects-create',
      component: require('../../screens/admin/governmentProjects/GovernmentProjectEdit').default,
  },
  {
      path: '/admin/governmentProjects/:id/edit',
      name: 'governmentProjects-edit',
      component: require('../../screens/admin/governmentProjects/GovernmentProjectEdit').default,
  },
]
