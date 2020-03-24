<template>
  <admin-page>
    <template slot="main">
      <page-header>
        <!-- <template slot="action">
          <router-link
            :to="{ name: 'states-create' }"
            class="btn btn-sm btn-outline-success font-weight-bold my-auto"
          >{{ trans.app.new_state }}</router-link>
        </template> -->
      </page-header>

      <main class="py-4">
        <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <div class="d-flex justify-content-between my-3">
            <h1>{{ trans.app.states }}</h1>
          </div>

          <div class="mt-2">
            <div
              v-for="(state, $index) in states"
              :key="$index"
              class="d-flex border-top py-3 align-items-center"
            >
              <div class="mr-auto">
                <p class="mb-0 py-1">
                  <router-link
                    :to="{name: 'states-edit', params: { id: state.id }}"
                    class="font-weight-bold text-lg lead text-decoration-none"
                  >{{ state.name }}</router-link>
                </p>
              </div>
              <div class="ml-auto">
                <span class="text-muted mr-3">{{ state.local_governments_count }} {{ trans.app.localGovernments }}</span>
                <span
                  class="d-none d-md-inline-block"
                >{{ trans.app.created }} {{ moment(state.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </div>
            </div>

            <infinite-loading @infinite="fetchData" spinner="spiral">
              <span slot="no-more"></span>
              <div slot="no-results" class="text-left">
                <div class="mt-5">
                  <p class="lead text-center text-muted mt-5 pt-5">{{ trans.app.you_have_no_states }}</p>
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
  name: "states-index",

  components: {
    InfiniteLoading,
    AdminPage,
    PageHeader
  },

  data() {
    return {
      page: 1,
      states: [],
      trans: JSON.parse(CurrentTenant.lang)
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "stats" });
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/states", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.states.push(...response.data.data);

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
