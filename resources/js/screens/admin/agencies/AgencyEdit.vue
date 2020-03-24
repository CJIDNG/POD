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
            @click="saveAgency"
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
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_name"
              />

              <div v-if="form.errors.name" class="invalid-feedback d-block">
                <strong>{{ form.errors.name[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="hq"
                autofocus
                autocomplete="off"
                v-model="form.hq"
                title="HQ"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_hq"
              />

              <div v-if="form.errors.hq" class="invalid-feedback d-block">
                <strong>{{ form.errors.hq[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="head"
                autofocus
                autocomplete="off"
                v-model="form.head"
                title="Head"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_head"
              />

              <div v-if="form.errors.head" class="invalid-feedback d-block">
                <strong>{{ form.errors.head[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="email"
                autofocus
                autocomplete="off"
                v-model="form.email"
                title="Email"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_email"
              />

              <div v-if="form.errors.email" class="invalid-feedback d-block">
                <strong>{{ form.errors.email[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="phone"
                autofocus
                autocomplete="off"
                v-model="form.phone"
                title="Phone"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_phone"
              />

              <div v-if="form.errors.phone" class="invalid-feedback d-block">
                <strong>{{ form.errors.phone[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <input
                type="text"
                name="website"
                autofocus
                autocomplete="off"
                v-model="form.website"
                title="Website"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_website"
              />

              <div v-if="form.errors.website" class="invalid-feedback d-block">
                <strong>{{ form.errors.website[0] }}</strong>
              </div>
            </div>
            <div class="col-lg-12">
              <textarea
                type="text"
                name="description"
                autofocus
                autocomplete="off"
                v-model="form.description"
                title="Description"
                @keyup.enter="saveAgency"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_agency_a_description"
              ></textarea>

              <div v-if="form.errors.description" class="invalid-feedback d-block">
                <strong>{{ form.errors.description[0] }}</strong>
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
        @delete="deleteAgency"
        :header="trans.app.delete"
        :message="trans.app.deleted_agencies_are_gone_forever"
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
  name: "agencies-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
  },

  data() {
    return {
      agency: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        hq: "",
        head: "",
        email: "",
        phone: "",
        website: "",
        description: "",
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

  watch: {},

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/agencies/" + this.id)
        .then(response => {
          this.agency = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.hq = response.data.hq;
            this.form.head = response.data.head;
            this.form.email = response.data.email;
            this.form.phone = response.data.phone;
            this.form.website = response.data.website;
            this.form.description = response.data.description;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "agencies" });
        });
    },

    saveAgency() {
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
        .post("/api/v1/agencies/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.agency = response.data;
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

    deleteAgency() {
      this.request()
        .delete("/api/v1/agencies/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "agencies" });
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

      return errors;
    }
  }
};
</script>
