<template>
  <div>
    <page-header>
      <template slot="action">
        <button class="btn btn-sm btn-outline-success font-weight-bold my-auto">
          {{ trans.app.new_update }}
        </button>
      </template>
    </page-header>

    <main class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="row">
          <div class="col-6">
            <!-- <pre v-html="prettyJSON(trackerItem)"></pre> -->
            <div class="list-group">

              <a 
                v-for="(field, index) in tracker.fields" 
                :key="index" 
                class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ field.label }}</h5>
                </div>
                <p class="mb-1">{{ trackerItem.meta[field.model] }}</p>
                <small></small>
              </a>

            </div>
          </div>
          <div class="col-6" style="max-height: 650px; overflow: scroll; position: relative">
            <h1 class="bg-white" style="position: sticky; top: 0; width: 100%">
              {{trans.app.feed}}
              <hr>
            </h1>
            <div class="mt-5" v-for="(i, index) in 10" :key="index">
              <div class="media">
                <div class="media-body">
                  <h5 class="mt-0 text-bold">Faruk Nasir</h5>
                  <p>
                    Cras sit amet nibh libero, in gravida nulla. 
                    Nulla vel metus scelerisque ante sollicitudin. 
                    Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. 
                    Fusce condimentum nunc ac nisi vulputate fringilla. 
                    Donec lacinia congue felis in faucibus.
                  </p>
                  <p class="text-muted">{{moment(trackerItem.created_at).locale(CurrentTenant.locale).fromNow()}}</p>
                </div>
              </div>
              <hr>
            </div>
          </div>
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
  name: "trackerItems-show",

  components: {
    PageHeader,
    PageFooter
  },

  data() {
    return {
      trackerItem: {},
      tracker: {},
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
        .get(`/api/v1/trackerItems/${to.params.trackerId}/${vm.id}`)
        .then(response => {
          vm.trackerItem = response.data

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "trackerItems-main" });
        });

      vm.request()
        .get("/api/v1/trackers/" + to.params.trackerId)
        .then(response => {
          vm.tracker = response.data
        })
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
