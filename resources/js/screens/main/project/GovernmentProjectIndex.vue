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
          <div class="col-md-6 px-0 mx-auto my-auto mt-5">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <select class="form-control" id="filter" v-model="filter">
                    <option value="">{{ trans.app.filter_by }}</option>
                    <option value="agency">{{ trans.app.agency }}</option>
                    <option value="ministry">{{ trans.app.ministry }}</option>
                    <option value="state">{{ trans.app.state }}</option>
                    <option value="localGovernment">{{ trans.app.local_government }}</option>
                    <option value="status">{{ trans.app.status }}</option>
                    <option value="type">{{ trans.app.type }}</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <select class="form-control" id="filter-id" v-model="filterId">
                    <option value="">{{ trans.app.select_a_filter }}</option>
                    <option 
                      v-for="(filter, index) in currentFilters" 
                      :key="index"
                      :value="filter.id"
                    >{{filter.name}}</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 mx-auto my-auto">
            <small>showing from {{ from }} to {{ to }} of {{ total }}</small>
          </div>
        </div>


        <main>
          <div class="mt-2">
            <div 
              v-for="(governmentProject, $index) in governmentProjects" 
              :key="$index" 
              class="card flex-md-row mb-4 h-md-250 shadown-sm">
              <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-success">{{ governmentProject.type.name }}</strong>
                <h3 class="mb-0">
                  <router-link
                    :to="{name: 'government-projects-show', params: { id: governmentProject.id }}"
                    class="text-dark"
                  >
                    {{ governmentProject.description }}
                  </router-link>
                </h3>
                <div class="mb-1 text-muted">{{moment(governmentProject.created_at).locale(CurrentTenant.locale).fromNow()}}</div>
                <p class="card-text mb-auto">
                  {{ governmentProject.description }}
                </p>
                <router-link :to="{name: 'government-projects-show', params: { id: governmentProject.id }}">
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
      governmentProjects: [],
      trans: JSON.parse(CurrentTenant.lang),
      infiniteId: +new Date(),
      agencies: [],
      ministries: [],
      states: [],
      localGovernments: [],
      statuses: [],
      types: [],
      currentFilters: [],
      filter: "",
      filterId: "",
      query: "",
      url: "/api/v1/governmentProjects",
      from: "",
      to: "",
      total: "",
    };
  },

  created() {
    this.fetchFilters()
  },

  watch: {
    filter: function (val) {
      this.filterId = ""
      switch (val) {
        case "agency":
          this.currentFilters = this.agencies
          break;
        case "ministry":
          this.currentFilters = this.ministries
          break;
        case "state":
          this.currentFilters = this.states
          break;
        case "localGovernment":
          this.currentFilters = this.localGovernments
          break;
        case "status":
          this.currentFilters = this.statuses
          break;
        case "type":
          this.currentFilters = this.types
          break;
        case "":
          this.currentFilters = []
          break;
        default:
          break;
      }
    },

    filterId: function (val) {
      if (val === "") {
        this.url = "/api/v1/governmentProjects"
      } else {
        this.url = `/api/v1/governmentProjects?filter=${this.filter}&&filterId=${this.filterId}`
      }

      this.page = 1;
      this.governmentProjects = [];
      this.infiniteId += 1;
    },

    query: function (val) {
      if (val === "") {
        this.url = this.filterId ? 
          `/api/v1/governmentProjects?filter=${this.filter}&&filterId=${this.filterId}` :
          "/api/v1/governmentProjects"
      } else {
        this.url = this.filterId ? 
          `/api/v1/governmentProjects?filter=${this.filter}&&filterId=${this.filterId}&&query=${this.query}` :
          `/api/v1/governmentProjects?query=${this.query}`
      }

      this.page = 1;
      this.governmentProjects = [];
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
            this.governmentProjects.push(...response.data.data);
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
      // fetch agencies
      this.request()
        .get("/api/v1/agencies?all=1")
        .then(response => {
          this.agencies = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch ministries
      this.request()
        .get("/api/v1/ministries?all=1")
        .then(response => {
          this.ministries = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
      
      // fetch states
      this.request()
        .get("/api/v1/states?all=1")
        .then(response => {
          this.states = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

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

      // fetch statuses
      this.request()
        .get("/api/v1/statuses?all=1")
        .then(response => {
          this.statuses = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch types
      this.request()
        .get("/api/v1/types?all=1")
        .then(response => {
          this.types = response.data;
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
