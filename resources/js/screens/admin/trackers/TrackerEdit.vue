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
            @click="saveTracker"
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
                name="name"
                autofocus
                autocomplete="off"
                v-model="form.name"
                title="Name"
                @keyup.enter="saveTracker"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_tracker_a_name"
              />

              <div v-if="form.errors.name" class="invalid-feedback d-block">
                <strong>{{ form.errors.name[0] }}</strong>
              </div>
            </div>

            <div class="col-lg-12">
              <select
                name="role"
                v-model="form.has_location"
                title="Role"
                @keyup.enter="saveTracker"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_tracker_has_location"
              >
                <option value disabled>{{trans.app.give_your_tracker_has_location}}</option>
                <option 
                  value="1"
                >{{ trans.app.true }}</option>
                <option 
                  value="0"
                >{{ trans.app.false }}</option>
              </select>

              <div v-if="form.errors.has_location" class="invalid-feedback d-block">
                <strong>{{ form.errors.has_location[0] }}</strong>
              </div>
            </div>

            <div class="col-lg-12">
              <select
                name="role"
                v-model="form.has_user_reporting"
                title="Role"
                @keyup.enter="saveTracker"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_tracker_has_user_reporting"
              >
                <option value disabled>{{trans.app.give_your_tracker_has_user_reporting}}</option>
                <option 
                  value="1"
                >{{ trans.app.true }}</option>
                <option 
                  value="0"
                >{{ trans.app.false }}</option>
              </select>

              <div v-if="form.errors.has_user_reporting" class="invalid-feedback d-block">
                <strong>{{ form.errors.has_user_reporting[0] }}</strong>
              </div>
            </div>

          </div>

          <div class="form-group">
            <h1>
              {{trans.app.fields}} 
              <button
                class="btn btn-info btn-sm"
                @click="showNewFieldModal"
              >
                {{ trans.app.add_field }}
              </button>
              <small class="text-muted">{{ trans.app.create_custom_fields_to_be_collected }}</small>
              <hr>
            </h1>
            <div class="row">
              <div class="col-1 border">

              </div>
              <div class="col-1 border">
                
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
        @delete="deleteTracker"
        :header="trans.app.delete"
        :message="trans.app.deleted_types_are_gone_forever"
      ></delete-modal>

      <new-field-modal 
        v-if="isReady" ref="newFieldModal"
        :defaultImageUrl="form.user_id"
        :imageUrl="form.user_id"
        @update:imageUrl="form.user_id = $event"
      />
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import DeleteModal from "../../../components/modals/DeleteModal";
import AdminPage from '../../../components/AdminPage';
import NewFieldModal from "../../../components/modals/tracker/NewFieldModal";

export default {
  name: "trackers-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
    NewFieldModal,
  },

  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        fields: [],
        has_location: "0",
        has_user_reporting: "0",
        has_bot: "0",
        bot_name: "",
        user_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang)
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
        .get("/api/v1/trackers/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            this.form.name = response.data.name
            this.form.fields = response.data.fields
            this.form.has_location = response.data.has_location
            this.form.has_user_reporting = response.data.has_user_reporting
            this.form.has_bot = response.data.has_bot
            this.form.bot_name = response.data.bot_name
            this.form.user_id = response.data.user_id
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          // this.$router.push({ name: "trackers" });
        });
    },

    saveTracker() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }

      this.request()
        .post("/api/v1/trackers/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
          this.status = response.data;
        })
        .catch(error => {
          this.form.isSaving = false;
          console.log(error)
        });

      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },

    deleteTracker() {
      this.request()
        .delete("/api/v1/trackers/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "trackers" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    showNewFieldModal() {
      $(this.$refs.newFieldModal.$el).modal("show");
    },

    validate(form) {
      let errors = {}

      if (!form.name) {
        errors.name = ["name can not be empty"]
      }

      if (!form.fields) {
        errors.fields = ["fields can not be empty"]
      }

      if (!form.has_location) {
        errors.has_location = ["please indicate if tracker has location"]
      }

      if (!form.has_user_reporting) {
        errors.has_user_reporting = ["please indicate if tracker has user reporting"]
      }

      if (!form.has_bot) {
        errors.has_bot = ["please indicate if tracker has bot"]
      }

      return errors;
    }
  }
};
</script>
