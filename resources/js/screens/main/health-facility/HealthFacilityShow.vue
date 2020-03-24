<template>
  <div>
    <page-header>
      <template slot="action">
        <router-link
          :to="{ name: 'health-facilities' }"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        >{{ trans.app.health_facilities }}</router-link>
      </template>
    </page-header>

    <main class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ health_facility.name }}</h1>
        </div>


        <div class="list-group">

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.name }}</h5>
            </div>
            <p class="mb-1">{{ health_facility.name }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.unique_id }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.unique_id">{{ health_facility.unique_id }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.local_government }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.local_government">{{ health_facility.local_government.name }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.code }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.code">{{ health_facility.code }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.name }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.name">{{ health_facility.name }}</p>
            <small class="text-muted" ></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.registration_no }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.registration_no">{{ health_facility.registration_no }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.start_date }}</h5>
            </div>
            <p class="mb-1" v-if="health_facility.start_date">{{ health_facility.start_date }}</p>
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
  name: "government-project-show",

  components: {
    PageHeader,
    PageFooter
  },

  data() {
    return {
      health_facility: {},
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
        .get("/api/v1/health-facilities/" + vm.id)
        .then(response => {
          vm.health_facility = response.data

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "health-facilities" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
