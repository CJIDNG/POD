export default [
  {
    path: '/admin/localGovernments',
    name: 'localGovernments',
      component: require('../../screens/admin/localGovernments/LocalGovernmentIndex').default,
  },
  {
      path: '/admin/localGovernments/create',
      name: 'localGovernments-create',
      component: require('../../screens/admin/localGovernments/LocalGovernmentEdit').default,
  },
  {
      path: '/admin/localGovernments/:id/edit',
      name: 'localGovernments-edit',
      component: require('../../screens/admin/localGovernments/LocalGovernmentEdit').default,
  },
]
