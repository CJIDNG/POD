<template>
  <admin-page>
    <template slot="main">
      <page-header></page-header>

      <main class="py-4">
        <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
          <div class="d-flex justify-content-between my-3">
            <div class="my-3">
              <h1>{{ trans.app.stats }}</h1>
              <p v-if="isReady && items.length">{{ trans.app.click_to_see_insights }}</p>
            </div>

            <select
              name
              id
              v-model="className"
              @change="changeModel"
              class="my-auto ml-auto w-auto bg-transparent custom-select border-0"
            >
              <option 
                v-for="(model, index) in Object.keys(models)"
                :key="index"
                :value="models[model]['class']">{{ model }}</option>
            </select>
          </div>

          <div v-if="isReady" v-cloak>
            <div v-if="items.length">
              <div class="card-deck mt-4">
                <div class="card shadow bg-transparent">
                  <div
                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                  >
                    <p
                      class="font-weight-bold text-muted small text-uppercase"
                    >{{ trans.app.views }}</p>
                    <p>
                      <span
                        class="badge badge-pill badge-success p-2 font-weight-bold"
                      >{{ trans.app.last_thirty_days }}</span>
                    </p>
                  </div>
                  <div class="card-body pt-0 pb-2">
                    <p class="card-text display-4">{{ suffixedNumber(viewCount) }}</p>
                  </div>
                </div>
                <div class="card shadow bg-transparent">
                  <div
                    class="card-header pb-0 bg-transparent d-flex justify-content-between align-middle border-0"
                  >
                    <p
                      class="font-weight-bold text-muted small text-uppercase"
                    >{{ trans.app.visitors }}</p>
                    <p>
                      <span
                        class="badge badge-pill badge-primary p-2 font-weight-bold"
                      >{{ trans.app.last_thirty_days }}</span>
                    </p>
                  </div>
                  <div class="card-body pt-0 pb-2">
                    <p class="card-text display-4">{{ suffixedNumber(visitCount) }}</p>
                  </div>
                </div>
                <div class="card shadow bg-transparent">
                  <div class="card-header pb-0 bg-transparent border-0">
                    <p
                      class="font-weight-bold text-muted small text-uppercase"
                    >{{ trans.app.metrics }}</p>
                  </div>
                  <div class="card-body pt-0 pb-2">
                    <ul>
                      <li>{{ publishedCount }} {{ trans.app.items_found }}</li>
                    </ul>
                  </div>
                </div>
              </div>

              <line-chart
                :views="JSON.parse(viewTrend)"
                :visits="JSON.parse(visitTrend)"
                class="mt-5"
              />

              <div class="mt-5">
                <div
                  v-for="(item, $index) in items"
                  :key="$index"
                  class="d-flex border-top py-3 align-items-center"
                >
                  <div class="mr-auto">
                    <p class="mb-1 mt-2">
                      <router-link
                        :to="{name: 'stats-show', params: { id: item.id, className: className }}"
                        class="font-weight-bold text-lg lead text-decoration-none"
                      >{{ item.title || item.name || item.description }}</router-link>
                    </p>
                    <p class="text-muted mb-2">
                      <router-link
                        :to="{name: 'stats-show', params: { id: item.id, className: className }}"
                        class="text-decoration-none text-muted"
                      >{{ trans.app.view_stats }}</router-link>
                    </p>
                  </div>
                  <div class="ml-auto d-none d-lg-block">
                    <span
                      class="text-muted mr-3"
                    >{{ suffixedNumber(item.views_count) }} {{ trans.app.views }}</span>
                    {{ trans.app.created }} {{ moment(item.created_at).locale(CurrentTenant.locale).fromNow() }}
                  </div>
                </div>
              </div>

              <infinite-loading @infinite="fetchModels" spinner="spiral">
                <span slot="no-more"></span>
                <div slot="no-results"></div>
              </infinite-loading>
            </div>
            <div v-else class="mt-5">
              <p
                class="lead text-center text-muted mt-5 pt-5"
              >{{ trans.app.you_have_no_results }}</p>
              <p class="lead text-center text-muted mt-1">{{ trans.app.stats_are_made_available }}</p>
            </div>
          </div>
        </div>
      </main>
    </template>
  </admin-page>
</template>

<script>
import _ from "lodash"
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";
import LineChart from "../../../components/analytics/LineChart";

export default {
  name: "stats-index",

  components: {
    LineChart,
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      items: [],
      publishedCount: 0,
      viewCount: 0,
      viewTrend: {},
      visitCount: 0,
      visitTrend: {},
      models: {
        'Post': {
          'class': 'App\\Model\\Blog\\Post'
        },
        'Dataset': {
          'class': 'App\\Model\\Data\\Dataset'
        },
        'Dataresource': {
          'class': 'App\\Model\\Data\\Dataresource'
        }
      },
      className: 'App\\Model\\Blog\\Post',
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
    };
  },

  computed: {
    modelFetchUrl() {
      let url = ''

      switch (this.className) {
        case 'App\\Model\\Blog\\Post':
          url = "/api/v1/posts"
          break;

        case 'App\\Model\\Data\\Dataset':
          url = "/api/v1/datasets"
          break;

        case 'App\\Model\\Data\\Dataresource':
          url = "/api/v1/dataresources"
          break;
      
        default:
          url = "";
          break;
      }

      return url
    }
  },

  mounted() {
    this.fetchStats();
    this.fetchModels();
  },

  methods: {
    fetchStats() {
      this.request()
        .get("/api/v1/stats", {
          params: {
            className: this.className
          }
        })
        .then(response => {
          this.viewCount = response.data.view_count;
          this.viewTrend = response.data.view_trend;
          this.visitCount = response.data.visit_count;
          this.visitTrend = response.data.visit_trend;
          this.publishedCount = response.data.published_count;

          this.isReady = true;
          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    },

    fetchModels($state) {
      this.request()
        .get(this.modelFetchUrl, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          /**
           * check if there arent more items 
           * to load
           */
          let isItemsArrayEmpty = this.isItemsArrayEmpty(response)

          if (!_.isEmpty(response.data) && !isItemsArrayEmpty) {
            this.page += 1;
            switch (this.className) {
              case 'App\\Model\\Blog\\Post':
                this.items.push(...response.data.posts.data);
                break;

              case 'App\\Model\\Data\\Dataset':
                this.items.push(...response.data.datasets.data);
                break;

              case 'App\\Model\\Data\\Dataresource':
                this.items.push(...response.data.dataresources.data);
                break;
            
              default:
                break;
            }
            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch(error => NProgress.done());
    },

    changeModel() {
      this.page = 1
      this.items = []
      this.fetchStats()
      this.fetchModels()
    },

    isItemsArrayEmpty(response) {
      let isEmpty

      switch (this.className) {
        case 'App\\Model\\Blog\\Post':
          isEmpty = _.isEmpty(response.data.posts.data)
          break;

        case 'App\\Model\\Data\\Dataset':
          isEmpty = _.isEmpty(response.data.datasets.data)
          break;

        case 'App\\Model\\Data\\Dataresource':
          isEmpty = _.isEmpty(response.data.dataresources.data)
          break;
      
        default:
          isEmpty = true;
          break;
      }

      return isEmpty
    }
  }
};
</script>

<style lang="scss" scoped>
@import "../../../../../resources/sass/variables";

.badge-success {
  background-color: $green-500;
  color: darken($green, 20%);
}

.badge-primary {
  background-color: $blue-500;
  color: darken($blue, 35%);
}
</style>
