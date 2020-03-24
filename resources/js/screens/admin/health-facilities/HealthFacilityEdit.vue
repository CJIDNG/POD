<template>
  <admin-page>
    <template slot="main">
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
            :class="{ disabled: form.name === '' }"
            @click="saveHealthFacility"
            :aria-label="trans.app.save"
          >{{ trans.app.save }}</a>
        </template>

        <template slot="menu">
          <div class="dropdown" v-if="id !== 'create'">
            <a
              id="navbarDropdown"
              class="nav-link pr-0"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="25"
                class="icon-dots-horizontal"
              >
                <path
                  class="primary"
                  fill-rule="evenodd"
                  d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
                />
              </svg>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a
                href="#"
                class="dropdown-item text-danger"
                @click="showDeleteModal"
              >{{ trans.app.delete }}</a>
            </div>
          </div>
        </template>
      </page-header>

      <main v-if="isReady" class="py-4" v-cloak>
        <div class="col-xl-8 offset-xl-2 px-xl-5 col-md-12 mt-5">
          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="unique_id"
                autofocus
                autocomplete="off"
                v-model="form.unique_id"
                title="Unique Identifier"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_unique_id"
              />

              <div v-if="form.errors.unique_id" class="invalid-feedback d-block">
                <strong>{{ form.errors.unique_id[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <select
                name="lg"
                v-model="form.local_government_id"
                title="Local Government"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_local_goverment"
              >
                <option value disabled>{{trans.app.give_your_facility_a_local_goverment}}</option>
                <option 
                  v-for="(local_government, index) in local_governments" 
                  :value="local_government.id"
                  :key="index"
                >{{local_government.name}}</option>
              </select>

              <div v-if="form.errors.location_id" class="invalid-feedback d-block">
                <strong>{{ form.errors.location_id[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="ward"
                autofocus
                autocomplete="off"
                v-model="form.ward"
                title="Ward"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_ward"
              />

              <div v-if="form.errors.ward" class="invalid-feedback d-block">
                <strong>{{ form.errors.ward[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="code"
                autofocus
                autocomplete="off"
                v-model="form.code"
                title="Code"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_code"
              />

              <div v-if="form.errors.code" class="invalid-feedback d-block">
                <strong>{{ form.errors.code[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="name"
                autofocus
                autocomplete="off"
                v-model="form.name"
                title="Name"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_name"
              />

              <div v-if="form.errors.name" class="invalid-feedback d-block">
                <strong>{{ form.errors.name[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="registration_no"
                autofocus
                autocomplete="off"
                v-model="form.registration_no"
                title="Registration No"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_registration_no"
              />

              <div v-if="form.errors.registration_no" class="invalid-feedback d-block">
                <strong>{{ form.errors.registration_no[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="date"
                name="start_date"
                autofocus
                autocomplete="off"
                v-model="form.start_date"
                title="Start Date"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_start_date"
              />

              <div v-if="form.errors.start_date" class="invalid-feedback d-block">
                <strong>{{ form.errors.start_date[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="ownership"
                autofocus
                autocomplete="off"
                v-model="form.ownership"
                title="Ownership"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_ownership"
              />

              <div v-if="form.errors.ownership" class="invalid-feedback d-block">
                <strong>{{ form.errors.ownership[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="facility_level"
                autofocus
                autocomplete="off"
                v-model="form.facility_level"
                title="Facility Level"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_facility_level"
              />

              <div v-if="form.errors.facility_level" class="invalid-feedback d-block">
                <strong>{{ form.errors.facility_level[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="latitude"
                autofocus
                autocomplete="off"
                v-model="form.latitude"
                title="Latitude"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_latitude"
              />

              <div v-if="form.errors.latitude" class="invalid-feedback d-block">
                <strong>{{ form.errors.latitude[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="longitude"
                autofocus
                autocomplete="off"
                v-model="form.longitude"
                title="Latitude"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_longitude"
              />

              <div v-if="form.errors.longitude" class="invalid-feedback d-block">
                <strong>{{ form.errors.longitude[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="operation_status"
                autofocus
                autocomplete="off"
                v-model="form.operation_status"
                title="Latitude"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_operation_status"
              />

              <div v-if="form.errors.operation_status" class="invalid-feedback d-block">
                <strong>{{ form.errors.operation_status[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="registration_status"
                autofocus
                autocomplete="off"
                v-model="form.registration_status"
                title="Latitude"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_registration_status"
              />

              <div v-if="form.errors.registration_status" class="invalid-feedback d-block">
                <strong>{{ form.errors.registration_status[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="license_status"
                autofocus
                autocomplete="off"
                v-model="form.license_status"
                title="Latitude"
                @keyup.enter="saveHealthFacility"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_facility_a_license_status"
              />

              <div v-if="form.errors.license_status" class="invalid-feedback d-block">
                <strong>{{ form.errors.license_status[0] }}</strong>
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
      </main>

      <delete-modal
        ref="deleteModal"
        @delete="deleteType"
        :header="trans.app.delete"
        :message="trans.app.deleted_types_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import DeleteModal from "../../../components/modals/DeleteModal";
import AdminPage from '../../../components/AdminPage';

export default {
  name: "health-facilities-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
  },

  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        unique_id: "",
        local_government_id: "",
        ward: "",
        code: "",
        name: "",
        registration_no: "",
        start_date: "",
        ownership: "",
        facility_level: "",
        latitude: "",
        longitude: "",
        operation_status: "",
        registration_status: "",
        license_status: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang),
      local_governments: []
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "dashboard" });
    }
  },

  mounted() {
    this.fetchData();
  },

  watch: {},

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/health-facilities/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            this.form.unique_id = response.data.unique_id
            this.form.local_government_id = response.data.local_government_id
            this.form.ward = response.data.ward
            this.form.code = response.data.code
            this.form.name = response.data.name
            this.form.registration_no = response.data.registration_no
            this.form.start_date = response.data.start_date
            this.form.ownership = response.data.ownership
            this.form.facility_level = response.data.facility_level
            this.form.latitude = response.data.latitude
            this.form.longitude = response.data.longitude
            this.form.operation_status = response.data.operation_status
            this.form.registration_status = response.data.registration_status
            this.form.license_status = response.data.license_status
          }

          this.isReady = true

          NProgress.done()
        })
        .catch(error => {
          this.$router.push({ name: "health-facilities" })
        });

      this.request()
        .get("/api/v1/localGovernments?all=1")
        .then(response => {
          this.local_governments = response.data
          NProgress.done()
        })
        .catch(() => {
          NProgress.done()
        })
    },

    saveHealthFacility() {
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
        .post("/api/v1/health-facilities/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false
          this.form.hasSuccess = true
          this.id = response.data.id
          this.status = response.data
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
        .delete("/api/v1/health-facilities/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide")

          this.$router.push({ name: "health-facilities" })
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

      if (!form.unique_id) {
        errors.unique_id = ["unique identifier can not be empty"]
      }

      if (!form.local_government_id) {
        errors.local_government_id = ["local government can not be empty"]
      }

      if (!form.name) {
        errors.name = ["name can not be empty"]
      }

      return errors
    }
  }
};
</script>
