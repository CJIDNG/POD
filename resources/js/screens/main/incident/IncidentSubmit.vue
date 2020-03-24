<template>
  <div>
    <page-header>
      <template slot="status">
        <ul class="navbar-nav mr-auto flex-row float-right">
          <li class="text-muted font-weight-bold">
            <span v-if="form.isSaving">{{ trans.app.saving }}</span>
            <span v-if="form.hasSuccess" class="text-success">{{ trans.app.saved }}</span>
          </li>
        </ul>
      </template>

      <template slot="action">
        <a
          href="#"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
          :class="{ disabled: form.title === '' }"
          @click="saveIncident"
          :aria-label="trans.app.save"
        >{{ trans.app.save }}</a>
      </template>
    </page-header>

    <main v-if="isReady" class="py-4" v-cloak>
      <div class="col-md-10 my-auto mx-auto">
        <div class="row mt-5">
          <div class="col-md-6 my-auto text-center">
            <h4 class="display-4 mb-5">{{ trans.app.report_an_incident }}</h4>
            <img width="300" :src="publish_article" alt="" class="img-fluid">
            <p class="mt-5">
              have you or someone you know....blah blah blah blah
              have you or someone you know....blah blah blah blah
              have you or someone you know....blah blah blah blah
            </p>
          </div>
          <div class="col-md-6 border rounded">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="title"
                  autofocus
                  autocomplete="off"
                  v-model="form.title"
                  title="Title"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_title"
                />

                <div v-if="form.errors.title" class="invalid-feedback d-block">
                  <strong>{{ form.errors.title[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <textarea
                  name="lg"
                  v-model="form.description"
                  title="Description"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_description"
                ></textarea>

                <div v-if="form.errors.description" class="invalid-feedback d-block">
                  <strong>{{ form.errors.description[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <input
                  type="date"
                  name="date"
                  autofocus
                  autocomplete="off"
                  v-model="form.date"
                  title="Date"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_date"
                />

                <div v-if="form.errors.date" class="invalid-feedback d-block">
                  <strong>{{ form.errors.date[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <select
                  name="type_id"
                  v-model="form.type_id"
                  title="Status"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_type"
                >
                  <option value disabled>{{trans.app.give_your_incident_a_type}}</option>
                  <option 
                    v-for="(type, index) in types" 
                    :value="type.id"
                    :key="index"
                  >{{type.name}}</option>
                </select>

                <div v-if="form.errors.type_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.type_id[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <select
                  name="status_id"
                  v-model="form.status_id"
                  title="Status"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_status"
                  disabled
                >
                  <option value disabled>{{trans.app.give_your_incident_a_status}}</option>
                  <option 
                    v-for="(status, index) in statuses" 
                    :value="status.id"
                    :key="index"
                  >{{status.name}}</option>
                </select>

                <div v-if="form.errors.status_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.status_id[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <select
                  name="health_facility_id"
                  v-model="form.health_facility_id"
                  title="Type"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_facility"
                >
                  <option value disabled>{{trans.app.give_your_incident_a_facility}}</option>
                  <option 
                    v-for="(health_facility, index) in health_facilities" 
                    :value="health_facility.id"
                    :key="index"
                  >{{health_facility.name}}</option>
                </select>

                <div v-if="form.errors.health_facility_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.health_facility_id[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <textarea
                  name="lg"
                  v-model="form.address"
                  title="Address"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_an_address"
                ></textarea>

                <div v-if="form.errors.address" class="invalid-feedback d-block">
                  <strong>{{ form.errors.address[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <input
                  type="text"
                  name="news_source_link"
                  autofocus
                  autocomplete="off"
                  v-model="form.news_source_link"
                  title="Code"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_news_source_link"
                />

                <div v-if="form.errors.news_source_link" class="invalid-feedback d-block">
                  <strong>{{ form.errors.news_source_link[0] }}</strong>
                </div>
              </div>
              <div class="col-lg-12">
                <input
                  type="text"
                  name="external_video_link"
                  autofocus
                  autocomplete="off"
                  v-model="form.external_video_link"
                  title="Latitude"
                  @keyup.enter="saveIncident"
                  class="form-control-lg form-control border-0 px-0 bg-transparent"
                  :placeholder="trans.app.give_your_incident_a_external_video_link"
                />

                <div v-if="form.errors.external_video_link" class="invalid-feedback d-block">
                  <strong>{{ form.errors.external_video_link[0] }}</strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-12">
                <div v-if="form.errors.server" class="invalid-feedback d-block">
                  <strong>{{ form.errors.server[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import publisharticle from "../../../../../public/assets/svg/undraw_publish_article_icso.svg"

export default {
  name: "incident-submit",

  components: {
    PageHeader
  },

  data() {
    return {
      status: null,
      id: "create",
      form: {
        id: "",
        title: "",
        description: "",
        date: "",
        type_id: "",
        status_id: "",
        health_facility_id: "",
        address: "",
        news_source_link: "",
        external_video_link: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang),
      local_governments: [],
      health_facilities: [],
      statuses: [],
      types: [],
      publish_article: publisharticle,
    };
  },

  created() {
    if (!this.isLoggedIn) {
      window.location.href('/login')
    }
  },

  mounted() {
    this.fetchData();
  },

  watch: {},

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/incidents/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id
          this.form.status_id = response.data.status_id

          this.isReady = true

          NProgress.done()
        })
        .catch(error => {
          this.$router.push({ name: "incidents-main" })
        });

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

      // fetch agencies
      this.request()
        .get("/api/v1/health-facilities?all=1")
        .then(response => {
          this.health_facilities = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
    },

    saveIncident() {
      this.form.errors = []
      this.form.isSaving = true
      this.form.hasSuccess = false

      let vErrors = this.validate(this.form)

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors
        this.form.isSaving = false
        return false
      }

      this.request()
        .post("/api/v1/incidents/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false
          this.form.hasSuccess = true
          this.id = response.data.id
          this.status = response.data

          this.$router.push({ name: "incidents-main" })
        })
        .catch(error => {
          this.form.isSaving = false
          this.form.errors = error.response.data.errors
        });

      setTimeout(() => {
        this.form.hasSuccess = false
        this.form.isSaving = false
      }, 3000);
    },

    deleteType() {
      this.request()
        .delete("/api/v1/incidents/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide")

          this.$router.push({ name: "incidents" })
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show")
    },

    validate(form) {
      let errors = {}

      if (!form.title) {
        errors.title = ["title can not be empty"]
      }

      if (!form.description) {
        errors.description = ['description can not be empty']
      }

      if (!form.date) {
        errors.date = ['date can not be empty']
      }

      if (!form.type_id) {
        errors.type_id = ['type can not be empty']
      }

      if (!form.status_id) {
        errors.status_id = ['status can not be empty']
      }

      if (!form.health_facility_id) {
        errors.health_facility_id = ['health facility can not be empty']
      }

      if (!form.address) {
        errors.address = ['address can not be empyt']
      }

      return errors
    }
  }
};
</script>
