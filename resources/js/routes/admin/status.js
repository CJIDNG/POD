export default [
  {
    path: '/admin/statuses',
    name: 'statuses',
      component: require('../../screens/admin/statuses/StatusIndex').default,
  },
  {
      path: '/admin/statuses/create',
      name: 'statuses-create',
      component: require('../../screens/admin/statuses/StatusEdit').default,
  },
  {
      path: '/admin/statuses/:id/edit',
      name: 'statuses-edit',
      component: require('../../screens/admin/statuses/StatusEdit').default,
  },
]
