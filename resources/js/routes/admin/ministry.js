export default [
  {
    path: '/admin/ministries',
    name: 'ministries',
      component: require('../../screens/admin/ministries/MinistryIndex').default,
  },
  {
      path: '/admin/ministries/create',
      name: 'ministries-create',
      component: require('../../screens/admin/ministries/MinistryEdit').default,
  },
  {
      path: '/admin/ministries/:id/edit',
      name: 'ministries-edit',
      component: require('../../screens/admin/ministries/MinistryEdit').default,
  },
]
