export default [
  {
    path: '/admin/agencies',
    name: 'agencies',
      component: require('../../screens/admin/agencies/AgencyIndex').default,
  },
  {
      path: '/admin/agencies/create',
      name: 'agencies-create',
      component: require('../../screens/admin/agencies/AgencyEdit').default,
  },
  {
      path: '/admin/agencies/:id/edit',
      name: 'agencies-edit',
      component: require('../../screens/admin/agencies/AgencyEdit').default,
  },
]
