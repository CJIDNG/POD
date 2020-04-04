<template>
  <admin-page>
    <template slot="main">
      <page-header>
        <template v-if="trackerId !== 'select'" slot="action">
          <router-link
            :to="{ name: 'trackerItems-create', params: { trackerId: trackerId } }"
            class="btn btn-sm btn-outline-success font-weight-bold my-auto"
          >{{ trans.app.new_tracker_item }}</router-link>
        </template>
      </page-header>

      <main v-if="isReady" class="py-4">
        <div v-if="trackerId === 'select'" class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <div class="d-flex justify-content-between my-3">
            <h1>{{ trans.app.select_trackers }}</h1>
          </div>
          <div
            v-for="(tracker, $index) in trackers"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'trackerItems', params: { trackerId: tracker.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ tracker.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span
                class="d-none d-md-inline-block"
              >
                {{ trans.app.created }} {{ moment(tracker.created_at).locale(CurrentTenant.locale).fromNow() }}
              </span>
            </div>
          </div>
        </div>
        <div v-else class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <div class="d-flex justify-content-between my-3">
            <h1>
              {{ trans.app.tracker_items }}
            </h1>
          </div>

          <div class="mt-2">
            <div
              v-for="(member, $index) in trackerItems"
              :key="$index"
              class="d-flex border-top py-3 align-items-center"
            >
              <div class="mr-auto">
                <p class="mb-0 py-1">
                  <router-link
                    :to="{name: 'trackerItems-edit', params: { id: member.id }}"
                    class="font-weight-bold text-lg lead text-decoration-none"
                  >{{ member.name }}</router-link>
                </p>
              </div>
              <div class="ml-auto">
                <span
                  class="d-none d-md-inline-block"
                >
                  {{ trans.app.created }} {{ moment(member.created_at).locale(CurrentTenant.locale).fromNow() }}
                </span>
              </div>
            </div>

            <infinite-loading @infinite="fetchData" spinner="spiral">
              <span slot="no-more"></span>
              <div slot="no-results" class="text-left">
                <div class="mt-5">
                  <p class="lead text-center text-muted mt-5 pt-5">{{ trans.app.you_have_no_results }}</p>
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
  name: "trackerItems-index",

  components: {
    InfiniteLoading,
    AdminPage,
    PageHeader
  },

  data() {
    return {
      trackerId: this.$route.params.trackerId || "select",
      trackers: [],
      page: 1,
      trackerItems: [],
      trans: JSON.parse(CurrentTenant.lang),
      isReady: false,
    };
  },

  watch: {
    $route(to, from) {
      // react to route changes...
      if (!this.$route.params.id) {
        this.request()
          .get("/api/v1/trackers?all=1")
          .then(response => {
            this.trackers = response.data
            this.isReady = true
            NProgress.done();
          })
      }

      this.trackerId = this.$route.params.trackerId || "select"
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      if (!vm.$route.params.id) {
        vm.request()
          .get("/api/v1/trackers?all=1")
          .then(response => {
            vm.trackers = response.data
            vm.isReady = true
            NProgress.done();
          })
      }
    })
  },

  created() {
    
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/trackerItems/" + this.trackerId, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.trackerItems.push(...response.data.data);

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
