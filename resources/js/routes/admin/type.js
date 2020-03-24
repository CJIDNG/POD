export default [
  {
    path: '/admin/types',
    name: 'types',
      component: require('../../screens/admin/types/TypeIndex').default,
  },
  {
      path: '/admin/types/create',
      name: 'types-create',
      component: require('../../screens/admin/types/TypeEdit').default,
  },
  {
      path: '/admin/types/:id/edit',
      name: 'types-edit',
      component: require('../../screens/admin/types/TypeEdit').default,
  },
]
