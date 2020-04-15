<template>
  <div>
    <page-header></page-header>

    <main class="py-4">
      <div v-if="isReady" class="col-xl-8 offset-xl-2 px-xl-5 col-md-12">
        <h1 class="my-3">{{ dataresource.title }}</h1>
        <div class="content-body mt-4 pb-3" v-html="dataresource.description"></div>
        <div class="row">
          <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-table-tab" data-toggle="pill" href="#v-pills-table" role="tab" aria-controls="v-pills-table" aria-selected="true">
                {{ trans.app.table }}
              </a>
              <a class="nav-link" id="v-pills-chart-tab" data-toggle="pill" href="#v-pills-chart" role="tab" aria-controls="v-pills-chart" aria-selected="false">
                {{ trans.app.chart }}
              </a>
              <a class="nav-link" id="v-pills-preview-tab" data-toggle="pill" href="#v-pills-preview" role="tab" aria-controls="v-pills-preview" aria-selected="false">
                {{ trans.app.preview }}
              </a>
            </div>
          </div>
          <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-table" role="tabpanel" aria-labelledby="v-pills-table-tab">
                <tabular-preview :data="worksheet" />
              </div>
              <div class="tab-pane fade" id="v-pills-chart" role="tabpanel" aria-labelledby="v-pills-chart-tab">
                Chart
              </div>
              <div class="tab-pane fade" id="v-pills-preview" role="tabpanel" aria-labelledby="v-pills-preview-tab">
                Preview
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment"
import NProgress from "nprogress"
import PageHeader from "../../../components/PageHeader"
import PageFooter from "../../../components/PageFooter"
import TabularPreview from "../../../components/previews/TabularPreview"

export default {
  name: "dataresource-show",

  components: {
    PageHeader,
    PageFooter,
    TabularPreview
  },

  data() {
    return {
      dataresource: {},
      worksheet: [],
      sheetNames: [],
      trans: JSON.parse(CurrentTenant.lang),
      id: this.$route.params.resourceId,
      isReady: false
    };
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get(`/api/v1/dataresources/${vm.$route.params.resourceId}`, {
          params: {
            previewData: 1
          }
        }).then(response => {
          vm.dataresource = response.data.dataresource
          let sn = Object.keys(response.data.worksheet)[0]
          vm.worksheet = response.data.worksheet[sn]
          vm.sheetNames = response.data.sheetNames
          vm.isReady = true

          NProgress.done();
        }).catch(error => {
          vm.$router.push({ name: "data" });
        });
    });
  },

  methods: {
    downloadResource(id) {
      if (!id) return
      
      this.request()
        .get("/api/v1/dataresources/download/" + id)
        .then(response => {
          NProgress.done()
        })
        .catch(error => {

        });
    },

    load(sheetName) {
      this.request()
        .get(`/api/v1/dataresources/${this.$route.params.resourceId}`, {
          params: {
            previewData: 1,
            sheetName: sheetName
          }
        }).then(response => {
          this.dataresource = response.data.dataresource
          let sn = Object.keys(response.data.worksheet)[0]
          vm.worksheet = response.data.worksheet[sn]

          NProgress.done();
        }).catch(error => {
          
        });
    }
  }
};
</script>

<style scoped></style>
