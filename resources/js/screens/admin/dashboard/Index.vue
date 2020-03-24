<template>
  <admin-page>
    <template slot="main">
      <page-header></page-header>

      <main class="py-4">
        <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <h1>Dashboard</h1>
        </div>
      </main>
    </template>
  </admin-page>
</template>

<script>
import AdminPage from "../../../components/AdminPage";
import PageHeader from "../../../components/PageHeader";
import NProgress from "nprogress";

export default {
  name: "dashboard",

  components: {
    AdminPage,
    PageHeader
  },

  data() {
    return {
      page: 1,
      posts: [],
      publishedCount: 0,
      draftCount: 0,
      approvedCount: 0,
      submittedCount: 0,
      viewCount: 0,
      viewTrend: {},
      visitCount: 0,
      visitTrend: {},
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang)
    };
  },

  mounted() {
    NProgress.done()
  },

  methods: {
    
  }
};
</script>

<style lang="scss" scoped>

</style>
