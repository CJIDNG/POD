<template>
  <admin-page>
    <template slot="main">
      <page-header>
        <template slot="action">
          <router-link
            :to="{ name: 'ministries-create' }"
            class="btn btn-sm btn-outline-success font-weight-bold my-auto"
          >{{ trans.app.new_ministry }}</router-link>
        </template>
      </page-header>

      <main class="py-4">
        <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <div class="d-flex justify-content-between my-3">
            <h1>{{ trans.app.ministries }}</h1>
          </div>

          <div class="mt-2">
            <div
              v-for="(ministry, $index) in ministries"
              :key="$index"
              class="d-flex border-top py-3 align-items-center"
            >
              <div class="mr-auto">
                <p class="mb-0 py-1">
                  <router-link
                    :to="{name: 'ministries-edit', params: { id: ministry.id }}"
                    class="font-weight-bold text-lg lead text-decoration-none"
                  >{{ ministry.name }}</router-link>
                </p>
              </div>
              <div class="ml-auto">
                <span class="text-muted mr-3">{{ ministry.government_projects_count }} {{ trans.app.governmentProjects }}</span>
                <span
                  class="d-none d-md-inline-block"
                >{{ trans.app.created }} {{ moment(ministry.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </div>
            </div>

            <infinite-loading @infinite="fetchData" spinner="spiral">
              <span slot="no-more"></span>
              <div slot="no-results" class="text-left">
                <div class="mt-5">
                  <p class="lead text-center text-muted mt-5 pt-5">{{ trans.app.you_have_no_lgs }}</p>
                </div>
              </div>
            </infinite-loading>
          </div>
        </div>
      </main>
    </template>
  </admin-page>
</template>

<script>
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";
import AdminPage from '../../../components/AdminPage';
import PageHeader from "../../../components/PageHeader";

export default {
  name: "ministries-index",

  components: {
    InfiniteLoading,
    AdminPage,
    PageHeader
  },

  data() {
    return {
      page: 1,
      ministries: [],
      trans: JSON.parse(CurrentTenant.lang)
    };
  },

  created() {
    
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/ministries", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.ministries.push(...response.data.data);

            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    }
  }
};
</script>
