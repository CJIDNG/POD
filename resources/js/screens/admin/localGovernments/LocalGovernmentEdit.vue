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
            @click="saveState"
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
            <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a
                href="#"
                class="dropdown-item text-danger"
                @click="showDeleteModal"
              >{{ trans.app.delete }}</a>
            </div> -->
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
                @keyup.enter="saveState"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_local_government_a_name"
                disabled
              />

              <div v-if="form.errors.name" class="invalid-feedback d-block">
                <strong>{{ form.errors.name[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="number"
                name="longitude"
                autofocus
                autocomplete="off"
                v-model="form.longitude"
                title="Email"
                @keyup.enter="saveState"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_local_government_a_longitude"
              />

              <div v-if="form.errors.longitude" class="invalid-feedback d-block">
                <strong>{{ form.errors.longitude[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="number"
                name="latitude"
                autofocus
                autocomplete="off"
                v-model="form.latitude"
                title="Email"
                @keyup.enter="saveState"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_local_government_a_latitude"
              />

              <div v-if="form.errors.latitude" class="invalid-feedback d-block">
                <strong>{{ form.errors.latitude[0] }}</strong>
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
                @keyup.enter="saveState"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_local_government_a_code"
              />

              <div v-if="form.errors.code" class="invalid-feedback d-block">
                <strong>{{ form.errors.code[0] }}</strong>
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
        @delete="deleteState"
        :header="trans.app.delete"
        :message="trans.app.deleted_local_governments_are_gone_forever"
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
  name: "local-governments-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
  },

  data() {
    return {
      local_government: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        longitude: "",
        latitude: "",
        code: "",
        state_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang)
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "stats" });
    }
  },

  mounted() {
    this.fetchData();
  },

  watch: {},

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/localGovernments/" + this.id)
        .then(response => {
          this.local_government = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.longitude = response.data.longitude;
            this.form.latitude = response.data.latitude;
            this.form.code = response.data.code;
            this.form.state_id = response.data.state_id;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "localGovernments" });
        });
    },

    saveState() {
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
        .post("/api/v1/localGovernments/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.local_government = response.data;
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

    deleteState() {
      this.request()
        .delete("/api/v1/localGovernments/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "local-governments" });
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

      if (!form.name) {
        errors.name = ["name can not be empty"];
      }

      if (!form.longitude) {
        errors.longitude = ["longitude can not be empty"];
      }

      if (!form.latitude) {
        errors.latitude = ["latitude can not be empty"];
      }

      // if (!form.code) {
      //   errors.code = [
      //     "code can not be empty"
      //   ];
      // }

      return errors;
    }
  }
};
</script>
