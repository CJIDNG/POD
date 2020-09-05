export default [

  {
    path: '/faac-facts',
    name: 'faac-facts',
    component: require('../../screens/main/faac-facts/Index.vue').default,
    children: [
      {
        path: '',
        name: 'faac-facts-home',
        component: require('../../screens/main/faac-facts/Home.vue').default,
      },
      {
        path: '13-percent-derivation',
        name: 'faac-facts-derivation',
        component: require('../../screens/main/faac-facts/Derivation.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2007',
        name: 'faac-facts-2007',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2007.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2008',
        name: 'faac-facts-2008',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2008.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2009',
        name: 'faac-facts-2009',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2009.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2010',
        name: 'faac-facts-2010',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2010.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2011',
        name: 'faac-facts-2011',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2011.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2012',
        name: 'faac-facts-2012',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2012.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2013',
        name: 'faac-facts-2013',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2013.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2014',
        name: 'faac-facts-2014',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2014.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2015',
        name: 'faac-facts-2015',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2015.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2016',
        name: 'faac-facts-2016',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2016.vue').default,
      }, {
        path: '/faac-facts/yearly-disbursement/2017',
        name: 'faac-facts-2017',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2017.vue').default,
      },
      {
        path: '/faac-facts/yearly-disbursement/2018',
        name: 'faac-facts-2018',
        component: require('../../screens/main/faac-facts/yearly-disbursement/2018.vue').default,
      },
    ]
  },

]