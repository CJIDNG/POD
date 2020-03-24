<template>
  <div>
    <page-header>
      <template slot="action">
        <router-link
          :to="{ name: 'incidents-main' }"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        >{{ trans.app.incidents }}</router-link>
      </template>
    </page-header>

    <main class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ incident.title }}</h1>
        </div>


        <div class="list-group">

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.title }}</h5>
            </div>
            <p class="mb-1">{{ incident.title }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.description }}</h5>
            </div>
            <p class="mb-1">{{ incident.description }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.date_started }}</h5>
            </div>
            <p class="mb-1">{{ incident.date }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.type }}</h5>
            </div>
            <p class="mb-1">{{ incident.type.name }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.status }}</h5>
            </div>
            <p class="mb-1">{{ incident.status.name }}</p>
            <small class="text-muted" ></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.health_facility }}</h5>
            </div>
            <p class="mb-1" v-if="incident.health_facility">{{ incident.health_facility.name }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.address }}</h5>
            </div>
            <p class="mb-1">{{ incident.address }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.news_source_link }}</h5>
            </div>
            <p class="mb-1" v-if="incident.news_source_link">{{ incident.news_source_link }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.external_video_link }}</h5>
            </div>
            <p class="mb-1" v-if="incident.external_video_link">{{ incident.external_video_link }}</p>
          </a>

        </div>
      </div>
    </main>

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"

export default {
  name: "incidents-show",

  components: {
    PageHeader,
    PageFooter
  },

  data() {
    return {
      incident: {},
      trans: JSON.parse(CurrentTenant.lang),
      id: this.$route.params.id
    };
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/incidents/" + vm.id)
        .then(response => {
          vm.incident = response.data

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "incidents-main" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
