export default [
  {
    path: "/data",
    name: "data",
    component: require("../../screens/main/data/DataIndex").default
  },
  {
    path: "/data/:id",
    name: "data-show",
    component: require("../../screens/main/data/DataShow").default
  }
];
