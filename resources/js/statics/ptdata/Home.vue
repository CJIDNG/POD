<template>
  <div>
    <page-header></page-header>

    <main class="text-center">
      <div class="jumbotron p-3 p-md-5 bg-danger text-center w-100">
        <div class="col-md-8 mx-auto text-white">
          <h3 class="title mb-2">
            Welcome to PTData
          </h3>
          <p class="lead">
            PTData is a data service by Premium Times Centre for Investigative 
            Journalism. It does some amazing stuffs like curating data across many 
            fields. You can access highly quality data. This is just an example by the 
            way. PTData is a data service by Premium Times Centre for Investigative 
            Journalism. It does some amazing stuffs like curating data across many 
            fields. You can access highly quality data. This is just an example by the 
            way.
          </p>
          <div class="col-md-6 px-0 mx-auto my-auto">
            <input 
              class="form-control" 
              type="text" 
              placeholder="Search" 
              aria-label="Search"
              v-model="query"
            >
          </div><br>
        </div>
      </div>
      
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        
        <section class="section text-center w-100 mb-5">
          <h3 class="text-center mb-5">
            {{ trans.app.topics }}
          </h3>
          <taxonomy-grid 
            :items="topics"
          />
        </section>

        <section class="section text-center w-100 mb-5">
          <h3 class="text-center mb-5">
            {{ trans.app.licenses }}
          </h3>
          <taxonomy-grid 
            :items="licenses"
          />
        </section>

        <section v-if="datasets.length > 0" class="section text-center w-100 mb-5">
          <h3 class="text-center mb-5">
            Featured Datasets
          </h3>
          <div class="row">
            <div
              v-for="(dataset, $index) in datasets"
              :key="$index"
              class="col-1 col-md-4"
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
          </div>
        </section>

      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import TaxonomyGrid from "../../components/data/TaxonomyGrid"

export default {
  name: "home-index",

  components: {
    TaxonomyGrid
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      topics: [],
      licenses: [],
      datasets: [],
      query: '',
    };
  },

  created() {
    this.fetchDataTopics()
    this.fetchFeaturedData()
    this.fetchDataLicenses()
  },

  mounted() {
    NProgress.done()
  },

  methods: {
    fetchDataTopics() {
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
    },

    fetchDataLicenses() {
      // fetch licenses
      this.request()
        .get("/api/v1/datalicenses?all=1")
        .then(response => {
          this.licenses = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
    },

    fetchFeaturedData() {
      this.request()
        .get('/api/v1/data')
        .then(response => {
          this.datasets = response.data.data.splice(0, 3)

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    },
  }
};
</script>

<style scoped></style>
