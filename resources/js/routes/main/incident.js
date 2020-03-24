export default [
  {
    path: '/incidents',
    name: 'incidents-main',
    component: require('../../screens/main/incident/IncidentIndex').default,
  },
  {
    path: '/incidents/:id/show',
    name: 'incidents-show',
    component: require('../../screens/main/incident/IncidentShow').default
  },
  {
    path: '/incidents/create',
    name: 'incidents-submit',
    component: require('../../screens/main/incident/IncidentSubmit').default
  },
]
