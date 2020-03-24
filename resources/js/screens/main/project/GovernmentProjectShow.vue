<template>
  <div>
    <page-header>
      <template slot="action">
        <router-link
          :to="{ name: 'government-projects' }"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        >{{ trans.app.governmentProjects }}</router-link>
      </template>
    </page-header>

    <main class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ governmentProject.description }}</h1>
        </div>


        <div class="list-group">

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.allocation }}</h5>
            </div>
            <p class="mb-1">{{ governmentProject.allocation }}</p>
            <small>*Naira</small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.agency }}</h5>
            </div>
            <p class="mb-1" v-if="governmentProject.agency">{{ governmentProject.agency.name || '' }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.ministry }}</h5>
            </div>
            <p class="mb-1" v-if="governmentProject.ministry">{{ governmentProject.ministry.name || '' }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.date_commissioned }}</h5>
            </div>
            <p class="mb-1" v-if="governmentProject.date_commissioned">{{ governmentProject.date_commissioned || '' }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.location }}</h5>
            </div>
            <p class="mb-1" v-if="governmentProject.location">{{ governmentProject.location.name || '' }}</p>
            <small class="text-muted" v-if="governmentProject.location">
              {{ 
                governmentProject.location_type === 'state' ? 
                trans.app.state : trans.app.local_government
              }}.
            </small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.type }}</h5>
            </div>
            <p class="mb-1">{{ governmentProject.type.name || '' }}</p>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.status }}</h5>
            </div>
            <p class="mb-1">{{ governmentProject.status.name || '' }}</p>
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
      governmentProject: {},
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
        .get("/api/v1/governmentProjects/" + vm.id)
        .then(response => {
          vm.governmentProject = response.data

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "government-projects" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
