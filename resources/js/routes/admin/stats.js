export default [
  {
    path: '/admin/stats',
    name: 'stats',
    component: require('../../screens/admin/stats/StatsIndex').default,
  },
  {
    path: '/admin/stats/:id',
    name: 'stats-show',
    component: require('../../screens/admin/stats/StatsShow').default,
  },
]
