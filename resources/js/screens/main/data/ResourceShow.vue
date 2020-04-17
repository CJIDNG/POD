<template>
  <div>
    <page-header></page-header>

    <main class="py-4">
      <vue-element-loading :active="!isReady" :is-full-screen="true"/>
      <div class="col-xl-8 offset-xl-2 px-xl-5 col-md-12">
        <h1 class="my-3">{{ dataresource.title }}</h1>
        <div class="content-body mt-4 mb-3" v-html="dataresource.description"></div>
        <p v-if="dataresource.format" class="text-muted">
          <span class="text-success">{{ `.${dataresource.format.extension}` }}</span>
        </p>
        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="v-pills-table-tab" data-toggle="pill" href="#v-pills-table" role="tab" aria-controls="v-pills-table" aria-selected="true">
                  {{ trans.app.table }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="v-pills-chart-tab" data-toggle="pill" href="#v-pills-chart" role="tab" aria-controls="v-pills-chart" aria-selected="false">
                  {{ trans.app.chart }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="v-pills-preview-tab" data-toggle="pill" href="#v-pills-preview" role="tab" aria-controls="v-pills-preview" aria-selected="false">
                  {{ trans.app.preview }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="v-pills-map-tab" data-toggle="pill" href="#v-pills-map" role="tab" aria-controls="v-pills-map" aria-selected="false">
                  {{ trans.app.map }}
                </a>
              </li>
              <li class="ml-3">
                <form class="form-inline">
                  <div class="form-group mb-2">
                    <label for="sheets" class="sr-only mr-3">Worksheets</label>
                    <select 
                      @change="load($event.target.value)" 
                      v-model="activeSheetName" 
                      id="sheets" 
                      class="form-control">
                      <option v-for="(sheetName, index) in sheetNames" :key="index" :value="sheetName">
                        {{ sheetName }}
                      </option>
                    </select>
                  </div>
                </form>
              </li>
            </ul>
            <div class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-table" role="tabpanel" aria-labelledby="v-pills-table-tab">
                <tabular-preview 
                  v-if="isReady"
                  :data="worksheet" 
                  :resource="dataresource"
                  :activeSheetName="activeSheetName"
                />
              </div>
              <div class="tab-pane fade" id="v-pills-chart" role="tabpanel" aria-labelledby="v-pills-chart-tab">
                <chart-preview 
                  v-if="isReady"
                  :chartOptions="chartOptions" 
                  :resource="dataresource"
                  :activeSheetName="activeSheetName"
                />
              </div>
              <div class="tab-pane fade" id="v-pills-preview" role="tabpanel" aria-labelledby="v-pills-preview-tab">
                Preview
              </div>
              <div class="tab-pane fade" id="v-pills-map" role="tabpanel" aria-labelledby="v-pills-map-tab">
                Map
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
import ChartPreview from "../../../components/previews/ChartPreview"
import VueElementLoading from 'vue-element-loading'

export default {
  name: "dataresource-show",

  components: {
    PageHeader,
    PageFooter,
    TabularPreview,
    ChartPreview,
    VueElementLoading
  },

  data() {
    return {
      dataresource: {},
      worksheet: [],
      sheetNames: [],
      activeSheetName: '',
      chartOptions: {
        series: [{
          data: [1,2,3] // sample data
        }]
      },
      trans: JSON.parse(CurrentTenant.lang),
      id: this.$route.params.resourceId,
      isReady: false,
      hasSuccess: false
    };
  },

  mounted() {
    
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.load()
    });
  },

  watch: {
    
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

        })
    },

    load(sheetName = null) {
      NProgress.start()
      this.isReady = false
      let method = 'get'
      let token = this.getToken()
      let url = `/api/v1/dataresources/${this.$route.params.resourceId}?previewData=1`
      if (sheetName) url += `&&sheetName=${sheetName}`

      let updateEssentials = (response) => {
        this.dataresource = response.dataresource
        let sn = Object.keys(response.worksheet)[0]
        this.activeSheetName = sn
        this.worksheet = response.worksheet[sn]
        this.sheetNames = response.sheetNames
        this.isReady = true
        this.hasSuccess = true
      }

      if (window.Worker) {
        console.info('worker available !!! using worker')
        let queryableWorker = new this.QueryableWorker('/workers/tasks.worker.js')

        try {
          queryableWorker.addListener('success', (response) => {
            updateEssentials(response)
            NProgress.done()
            queryableWorker.terminate()
          })

          queryableWorker.addListener('error', (error) => {
            console.error(error)
            this.$router.push({ name: "data" })
            NProgress.done()
            queryableWorker.terminate()
          })

          queryableWorker.sendQuery('makeRequest', method, token, url)
        } catch (error) {
          queryableWorker.terminate()
          NProgress.done()
          console.error(error)
        }
      } else {
        console.warn('Worker not available. at a risk of window freeze')

        this.request()
          .get(url, {
            params: params
          }).then(response => {
            updateEssentials(response)
            NProgress.done()
          }).catch(error => {
            console.error(error)
            this.$router.push({ name: "data" })
            NProgress.done()
          })
      }
    }
  }
};

</script>

<style scoped></style>
