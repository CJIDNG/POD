<template>
  <div>
    <page-header></page-header>

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
                    <option value="license">{{ trans.app.licenses }}</option>
                    <option value="topics">{{ trans.app.topics }}</option>
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
              v-for="(dataset, $index) in datasets"
              :key="$index"
              class="d-flex border-top py-3 align-items-center"
            >
              <div class="mr-auto py-1">
                <p class="mb-1">
                  <router-link
                    :to="{name: 'data-show', params: { id: dataset.id }}"
                    class="font-weight-bold text-lg lead text-decoration-none"
                  >{{ dataset.title }}</router-link>
                </p>
                <p class="mb-1" v-if="dataset.description">{{ trim(dataset.description, 200) }}</p>
                <p class="text-muted mb-0">
                  <span>{{ trans.app.author }} {{ dataset.user.name }} |</span> 
                  <span>{{ dataset.resources.length }} {{ trans.app.resources }}</span>
                </p>
                <p class="text-muted mb-0">
                  ― {{ trans.app.updated }} {{ moment(dataset.updated_at).locale(CurrentTenant.locale).fromNow() }}
                </p>
              </div>
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
  name: "datasets-index",

  components: {
    InfiniteLoading,
    PageHeader,
    PageFooter
  },

  metaInfo() {
    let metaTitle = this.metaTitle
    let metaSiteName = this.metaSiteName
    return {
      // Children can override the title.
      title: metaTitle + ' - ' + metaSiteName,
      // Result: My Page Title ← My Site
      // If a child changes the title to "My Other Page Title",
      // it will become: My Other Page Title ← My Site
      titleTemplate: '%s',
      // Define meta tags here.
      meta: [
        {vid: 'http-equiv', 'http-equiv': 'Content-Type', content: 'text/html; charset=utf-8'},
        {vid: 'viewport', name: 'viewport', content: 'width=device-width, initial-scale=1'},
        {vid: 'description', name: 'description', content: this.metaDescription},
        // OpenGraph data (Most widely used)
        {vid: 'og:title', property: 'og:title', content: this.metaTitle},
        {vid: 'og:site_name', property: 'og:site_name', content: this.metaSiteName},
        // The list of types is available here: http://ogp.me/#types
        {vid: 'og:type', property: 'og:type', content: 'website'},
        // Should the the same as your canonical link, see below.
        {vid: 'og:url', property: 'og:url', content: this.metaUrl},
        {vid: 'og:image', property: 'og:image', content: this.metaImageUrl},
        // Often the same as your meta description, but not always.
        {vid: 'og:description', property: 'og:description', content: this.metaDescription},

        // Twitter card
        {vid: 'twitter:card', name: 'twitter:card', content: this.metaDescription},
        {vid: 'twitter:site', name: 'twitter:site', content: this.metaUrl},
        {vid: 'twitter:title', name: 'twitter:title', content: this.metaTitle},
        {vid: 'twitter:description', name: 'twitter:description', content: this.metaDescription},
        // Your twitter handle, if you have one.
        {vid: 'twitter:creator', name: 'twitter:creator', content: '@starfolksoftware'},
        {vid: 'twitter:image:src', name: 'twitter:image:src', content: this.metaImageUrl},

        // Google / Schema.org markup:
        {vid: 'ipname', itemprop: 'name', content: this.metaSiteName},
        {vid: 'ipdescription', itemprop: 'description', content: this.metaDescription},
        {vid: 'ipimage', itemprop: 'image', content: this.metaImageUrl}
      ],
      link: [
        {vid: 'canonical', rel: 'canonical', href: this.metaCanonicalLink}
      ]
    }
  },

  data() {
    return {
      page: 1,
      datasets: [],
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
      licenses: [],
      topics: [],
      currentFilters: [],
      filter: "",
      filterId: "",
      query: "",
      url: "/api/v1/data",
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
        case "license":
          this.currentFilters = this.licenses
          break;
        case "topics":
          this.currentFilters = this.topics
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
        this.url = "/api/v1/data"
      } else {
        this.url = `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}`
      }

      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    },

    query: function (val) {
      if (val === "") {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}` :
          "/api/v1/data"
      } else {
        this.url = this.filterId ? 
          `/api/v1/data?filter=${this.filter}&&filterId=${this.filterId}&&query=${this.query}` :
          `/api/v1/data?query=${this.query}`
      }

      this.page = 1;
      this.datasets = [];
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
            this.datasets.push(...response.data.data);
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
        .get("/api/v1/datalicenses?all=1")
        .then(response => {
          this.licenses = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch topics
      this.request()
        .get("/api/v1/datatopics?all=1")
        .then(response => {
          this.topics = response.data;
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
