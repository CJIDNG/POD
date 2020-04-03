export default [
  {
    path: '/admin/trackerItems',
    name: 'trackerItems',
    component: require('../../screens/admin/trackerItems/TrackerItemIndex').default,
  },
  {
    path: '/admin/trackerItems/create',
    name: 'trackerItems-create',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  },
  {
    path: '/admin/trackerItems/:id/edit',
    name: 'trackerItems-edit',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  },
]
