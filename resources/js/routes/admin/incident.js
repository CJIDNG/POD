export default [
  {
    path: '/admin/incidents',
    name: 'incidents',
    component: require('../../screens/admin/incidents/IncidentIndex').default,
  },
  {
    path: '/admin/incidents/create',
    name: 'incidents-create',
    component: require('../../screens/admin/incidents/IncidentEdit').default,
  },
  {
    path: '/admin/incidents/:id/edit',
    name: 'incidents-edit',
    component: require('../../screens/admin/incidents/IncidentEdit').default,
  },
]
