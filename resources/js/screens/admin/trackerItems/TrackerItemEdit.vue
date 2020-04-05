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
            @click="saveTrackedItem"
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
          <div class="form-group">
            <div class="col-lg-12">
              <div v-for="(error, index) in form.errors" :key="index" class="invalid-feedback d-block">
                <strong>{{ error[0] }}</strong>
              </div>
            </div>
          </div>
          <vue-form-generator :schema="schema" :model="form" :options="formOptions"></vue-form-generator>
        </div>
      </main>

      <delete-modal
        ref="deleteModal"
        @delete="deleteTrackerItem"
        :header="trans.app.delete"
        :message="trans.app.deleted_tracked_items_are_gone_forever"
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
import VueFormGenerator from 'vue-form-generator/dist/vfg-core.js'
// import 'vue-form-generator/dist/vfg-core.css'

export default {
  name: "trackerItems-edit",

  components: {
    PageHeader,
    DeleteModal,
    AdminPage,
    VueFormGenerator: VueFormGenerator.component
  },

  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: '',
        user_id: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      tracker: {},
      isReady: false,
      trans: JSON.parse(CurrentTenant.lang),
      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true
      }
    };
  },

  computed: {
    schema() {
      return {
        fields: this.tracker.fields
      }
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/trackers/" + vm.$route.params.trackerId)
        .then(response => {
          vm.tracker = response.data

          vm.tracker.fields.forEach((field) => {
            vm.form[field.model] = field.default || ''
          });

          vm.fetchData()
        })
    })
  },

  created() {
    
  },

  mounted() {
    
  },

  watch: {
    
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/trackerItems/" + this.$route.params.trackerId + "/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            Object.assign(this.form, response.data.meta)
            this.form.user_id = response.data.user_id
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          console.log(error)
          // this.$router.push({ name: "designations" });
        });
    },

    saveTrackedItem() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }

      let meta = {}

      this.tracker.fields.forEach((field) => {
        meta[field.model] = this.form[field.model]
      });

      let formData = {
        id: this.form.id,
        tracker_id: this.$route.params.trackerId,
        confirmed: '1',
        meta,
        user_id: this.form.user_id,
      }

      this.request()
        .post(`/api/v1/trackerItems/${this.$route.params.trackerId}/${this.id}`, formData)
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

    deleteTrackerItem() {
      this.request()
        .delete("/api/v1/trackerItems/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "trackerItems", params: { trackerItem: this.$route.params.trackerId } });
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

      let formKeyArr = Object.keys(form)

      formKeyArr.forEach(formKey => {
        if(!form[formKey] && 
          formKey !== 'isSaving' && 
          formKey !== 'hasSuccess' && 
          formKey !== 'id' && 
          formKey !== 'user_id') {
          errors[formKey] = [`${formKey} can not be empty`]
        }
      });

      return errors;
    }
  }
};
</script>
