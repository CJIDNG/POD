<template>
  <div>
    <page-header>
      <!-- <template slot="action">
        <router-link
          :to="{ name: 'posts-create' }"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        >{{ trans.app.new_post }}</router-link>
      </template> -->
    </page-header>

    <div class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="jumbotron p-3 p-md-5 bg-transparent text-center">
          <div class="col-md-8 px-0 mx-auto my-auto">
            <input 
              class="form-control" 
              type="text" 
              placeholder="Search" 
              aria-label="Search"
              v-model="query"
            >
          </div><br>
          <div class="col-md-6 mx-auto my-auto">
            <small>showing from {{ from }} to {{ to }} of {{ total }}</small>
          </div>
        </div>


        <main>
          <div class="mt-2">
            <div 
              v-for="(health_facility, $index) in health_facilities" 
              :key="$index" 
              class="card flex-md-row mb-4 h-md-250 shadown-sm">
              <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-success">{{ health_facility.facility_level }}</strong>
                <h3 class="mb-0">
                  <router-link
                    :to="{name: 'health-facilities-show', params: { id: health_facility.id }}"
                    class="text-dark"
                  >
                    {{ health_facility.name }}
                  </router-link>
                </h3>
                <div class="mb-1 text-muted">{{moment(health_facility.created_at).locale(CurrentTenant.locale).fromNow()}}</div>
                <p class="card-text mb-auto"></p>
                <router-link :to="{name: 'government-projects-show', params: { id: health_facility.id }}">
                  {{ trans.app.view }}
                </router-link>
              </div>
              <div class="flex-auto d-none d-lg-block"></div>
            </div>

            <infinite-loading 
              :identifier="infiniteId"
              @infinite="fetchData" 
              spinner="spiral" 
              style="position: relative; top: 0">
              <span slot="no-more"></span>
              <div slot="no-results" class="text-left">
                <div class="mt-5">
                  <p class="lead text-center text-muted mt-5 pt-5">
                    <span>
                      {{trans.app.you_have_no_results}}
                    </span>
                  </p>
                </div>
              </div>
            </infinite-loading>


          </div>
        </main>

      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"

export default {
  name: "government-projects-index",

  components: {
    InfiniteLoading,
    PageHeader,
    PageFooter
  },

  data() {
    return {
      page: 1,
      health_facilities: [],
      trans: JSON.parse(CurrentTenant.lang),
      infiniteId: +new Date(),
      localGovernments: [],
      query: "",
      url: "/api/v1/health-facilities",
      from: "",
      to: "",
      total: "",
    };
  },

  created() {
    this.fetchFilters()
  },

  watch: {
    query: function (val) {
      if (val === "") {
        this.url = "/api/v1/health-facilities"
      } else {
        this.url = `/api/v1/health-facilities?query=${this.query}`
      }

      this.page = 1;
      this.health_facilities = [];
      this.infiniteId += 1;
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get(this.url, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.health_facilities.push(...response.data.data);
            this.from = response.data.from
            this.to = response.data.to
            this.total = response.data.total

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
    },
    fetchFilters() {
      // fetch localGovernments
      this.request()
        .get("/api/v1/localGovernments?all=1")
        .then(response => {
          this.localGovernments = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
    }
  }
};
</script>

<style scoped></style>
