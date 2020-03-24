export default [
  {
    path: '/admin/health-facilities',
    name: 'health-facilities',
      component: require('../../screens/admin/health-facilities/HealthFacilityIndex').default,
  },
  {
      path: '/admin/health-facilities/create',
      name: 'health-facilities-create',
      component: require('../../screens/admin/health-facilities/HealthFacilityEdit').default,
  },
  {
      path: '/admin/health-facilities/:id/edit',
      name: 'health-facilities-edit',
      component: require('../../screens/admin/health-facilities/HealthFacilityEdit').default,
  },
]
