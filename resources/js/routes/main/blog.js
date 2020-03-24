export default [
  {
    path: '/blog',
    name: 'blog',
    component: require('../../screens/main/blog/BlogIndex').default,
  },
  {
    path: '/blog/:slug/show',
    name: 'blog-show',
    component: require('../../screens/main/blog/BlogShow').default,
  },
]
