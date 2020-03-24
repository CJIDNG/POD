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
            :class="{ disabled: form.description === '' }"
            @click="saveGovernmentProject"
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
              <textarea
                type="text"
                name="description"
                autofocus
                autocomplete="off"
                v-model="form.description"
                title="Description"
                @keyup.enter="saveGovernmentProject"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_government_project_a_description"
              ></textarea>

              <div v-if="form.errors.description" class="invalid-feedback d-block">
                <strong>{{ form.errors.description[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="number"
                name="allocation"
                autofocus
                autocomplete="off"
                v-model="form.allocation"
                title="Allocation"
                @keyup.enter="saveGovernmentProject"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_government_project_a_allocation"
              />

              <div v-if="form.errors.allocation" class="invalid-feedback d-block">
                <strong>{{ form.errors.allocation[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <select
                name="agency_id"
                v-model="form.agency_id"
                title="Role"
                @keyup.enter="saveGovernmentProject"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_government_project_agency_id"
              >
                <option value disabled>{{trans.app.give_your_government_project_agency_id}}</option>
                <option 
                  v-for="(agency, index) in agencies" 
                  :value="agency.id"
                  :key="index"
                >{{agency.name}}</option>
              </select>

              <div v-if="form.errors.agency_id" class="invalid-feedback d-block">
                <strong>{{ form.errors.agency_id[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <select
                name="ministry_id"
                v-model="form.ministry_id"
                title="Role"
                @keyup.enter="saveGovernmentProject"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_government_project_ministry_id"
              >
                <option value disabled>{{trans.app.give_your_government_project_ministry_id}}</option>
                <option 
                  v-for="(ministry, index) in ministries" 
                  :value="ministry.id"
                  :key="index"
                >{{ministry.name}}</option>
              </select>

              <div v-if="form.errors.ministry_id" class="invalid-feedback d-block">
                <strong>{{ form.errors.ministry_id[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="date"
                name="date_commissioned"
                autofocus
                autocomplete="off"
                v-model="form.date_commissioned"
                title="Date Commissioned"
                @keyup.enter="saveGovernmentProject"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_government_project_a_date_commissioned"
              />

              <div v-if="form.errors.date_commissioned" class="invalid-feedback d-block">
                <strong>{{ form.errors.date_commissioned[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  name="location_type"
                  id="state"
                  value="state"
                  v-model="form.location_type"
                  title="Location Type"
                  @keyup.enter="saveGovernmentProject"
                  class="custom-control-input"
                />
                <label class="custom-control-label" for="state">State</label>
              </div>

              <div class="custom-control custom-radio custom-control-inline">
                <input
                  type="radio"
                  id="local-government"
                  name="location_type"
                  value="localGovernment"
                  v-model="form.location_type"
                  title="Location Type"
                  @keyup.enter="saveGovernmentProject"
                  class="custom-control-input"
                />
                <label class="custom-control-label" for="local-government">Local Government</label>
              </div>

              <div v-if="form.errors.location_type" class="invalid-feedback d-block">
                <strong>{{ form.errors.location_type[0] }}</strong>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <select
              v-show="form.location_type === 'state'"
              name="state"
              v-model="state_value"
              title="Location"
              @keyup.enter="saveGovernmentProject"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_government_project_location_id"
            >
              <option value disabled>{{trans.app.give_your_government_project_location_id}}</option>
              <option 
                v-for="(state, index) in states" 
                :value="state.id"
                :key="index"
              >{{state.name}}</option>
            </select>

            <select
              v-show="form.location_type === 'localGovernment'"
              name="lg"
              v-model="local_government_value"
              title="Location"
              @keyup.enter="saveGovernmentProject"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_government_project_location_id"
            >
              <option value disabled>{{trans.app.give_your_government_project_location_id}}</option>
              <option 
                v-for="(localGovernment, index) in localGovernments" 
                :value="localGovernment.id"
                :key="index"
              >{{localGovernment.name}}</option>
            </select>

            <div v-if="form.errors.location_id" class="invalid-feedback d-block">
              <strong>{{ form.errors.location_id[0] }}</strong>
            </div>
          </div>
          <div class="col-lg-12">
            <select
              name="status_id"
              v-model="form.status_id"
              title="Status"
              @keyup.enter="saveGovernmentProject"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_government_project_status"
            >
              <option value disabled>{{trans.app.give_your_government_project_status}}</option>
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
              name="type_id"
              v-model="form.type_id"
              title="Type"
              @keyup.enter="saveGovernmentProject"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_government_project_type"
            >
              <option value disabled>{{trans.app.give_your_government_project_type}}</option>
              <option 
                v-for="(type, index) in types" 
                :value="type.id"
                :key="index"
              >{{type.name}}</option>
            </select>

            <div v-if="form.errors.status_id" class="invalid-feedback d-block">
              <strong>{{ form.errors.status_id[0] }}</strong>
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
        @delete="deleteGovernmentProject"
        :header="trans.app.delete"
        :message="trans.app.deleted_government_projects_are_gone_forever"
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
  name: "government-projects-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
  },

  data() {
    return {
      government_project: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        location_type: "",
        allocation: "",
        agency_id: "",
        ministry_id: "",
        date_commissioned: "",
        location_type: "",
        location_id: "",
        status_id: "",
        type_id: "",
        user_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang),
      agencies: [],
      ministries: [],
      states: [],
      localGovernments: [],
      statuses: [],
      types: [],
      state_value: '',
      local_government_value: '',
    };
  },

  created() {
    
  },

  mounted() {
    this.fetchData();
  },

  watch: {
    
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/governmentProjects/" + this.id)
        .then(response => {
          this.government_project = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.description = response.data.description;
            this.form.allocation = response.data.allocation;
            this.form.agency_id = response.data.agency_id;
            this.form.ministry_id = response.data.ministry_id;
            this.form.date_commissioned = response.data.date_commissioned;
            this.form.location_type = response.data.location_type;
            this.form.location_id = response.data.location_id;
            this.form.status_id = response.data.status_id;
            this.form.type_id = response.data.type_id;
            this.form.user_id = response.data.user_id;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "governmentProjects" });
        });

      // fetch agencies
      this.request()
        .get("/api/v1/agencies?all=1")
        .then(response => {
          this.agencies = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch ministries
      this.request()
        .get("/api/v1/ministries?all=1")
        .then(response => {
          this.ministries = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
      
      // fetch states
      this.request()
        .get("/api/v1/states?all=1")
        .then(response => {
          this.states = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

      // fetch localGovernments
      this.request()
        .get("/api/v1/localGovernments?all=1")
        .then(response => {
          this.localGovernments = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })

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
    },

    saveGovernmentProject() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      this.form.location_id = this.form.location_type == 'state' ? 
        this.state_value : this.local_government_value

      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }

      this.request()
        .post("/api/v1/governmentProjects/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.government_project = response.data;
        })
        .catch(error => {
          this.form.isSaving = false;
          this.form.errors = error.response.data.errors;
        });

      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },

    deleteGovernmentProject() {
      this.request()
        .delete("/api/v1/governmentProjects/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "governmentProjects" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    validate(form) {
      let errors = {};

      if (!form.description) {
        errors.description = ["description can not be empty"];
      }

      if (!form.allocation) {
        errors.allocation = ["allocation can not be empty"];
      }

      if (!form.status_id) {
        errors.status_id = ["status can not be empty"];
      }

      if (!form.type_id) {
        errors.type_id = ["type can not be empty"];
      }

      return errors;
    }
  }
};
</script>
