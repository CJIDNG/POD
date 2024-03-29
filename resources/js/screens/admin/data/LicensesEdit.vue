<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>

    <template slot="action">
      <a
        href="#"
        v-permission="['update_datalicenses']"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveLicense"
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
            v-permission="['delete_datalicenses']"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ trans.app.licenses }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="form-group mb-5">
          <div class="col-lg-12">
            <input
              type="text"
              name="name"
              autofocus
              autocomplete="off"
              v-model="form.name"
              title="Name"
              @keyup.enter="saveLicense"
              class="form-control"
              :placeholder="trans.app.give_your_license_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>
          <div class="col-lg-12">
            <input
              type="text"
              name="link"
              autofocus
              autocomplete="off"
              v-model="form.link"
              title="Link"
              @keyup.enter="saveLicense"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_license_a_link"
            />

            <div v-if="form.errors.link" class="invalid-feedback d-block">
              <strong>{{ form.errors.link[0] }}</strong>
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

      <delete-modal
        ref="deleteModal"
        @delete="deleteLicense"
        :header="trans.app.delete"
        :message="trans.app.deleted_topics_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";

export default {
  name: "licenses-edit",

  components: {
    DeleteModal
  },

  data() {
    return {
      license: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        link: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Licenses',
          url: '/admin/data/licenses',
        },
        {
          title: 'License',
          url: '#',
        }
      ]
    };
  },

  mounted() {
    this.fetchData();
  },

  watch: {
    
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/datalicenses/" + this.id)
        .then(response => {
          this.format = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.link = response.data.link;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "licenses" });
        });
    },

    saveLicense() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      this.request()
        .post("/api/v1/datalicenses/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.license = response.data;
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

    deleteLicense() {
      this.request()
        .delete("/api/v1/datalicenses/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "formats" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    }
  }
};
</script>
