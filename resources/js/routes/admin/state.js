export default [
  {
    path: '/admin/states',
    name: 'states',
      component: require('../../screens/admin/states/StateIndex').default,
  },
  {
      path: '/admin/states/create',
      name: 'states-create',
      component: require('../../screens/admin/states/StateEdit').default,
  },
  {
      path: '/admin/states/:id/edit',
      name: 'states-edit',
      component: require('../../screens/admin/states/StateEdit').default,
  },
]
