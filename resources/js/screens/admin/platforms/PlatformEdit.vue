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
            @click="savePlatform"
            :aria-label="trans.app.save"
          >{{ trans.app.save }}</a>
        </template>

        <template slot="menu">
          <!-- <div class="dropdown" v-if="id !== 'create'">
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
          </div> -->
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
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_name"
                disabled
              />

              <div v-if="form.errors.name" class="invalid-feedback d-block">
                <strong>{{ form.errors.name[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="display_name"
                autofocus
                autocomplete="off"
                v-model="form.display_name"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_display_name"
              />

              <div v-if="form.errors.display_name" class="invalid-feedback d-block">
                <strong>{{ form.errors.display_name[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <label class="text-muted">{{ trans.app.give_your_platform_a_description }}</label>
              <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
              <div v-if="form.errors.description" class="invalid-feedback d-block">
                <strong>{{ form.errors.description[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="tag_line"
                autofocus
                autocomplete="off"
                v-model="form.tag_line"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_tag_line"
              />

              <div v-if="form.errors.tag_line" class="invalid-feedback d-block">
                <strong>{{ form.errors.tag_line[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <textarea
                type="text"
                name="physical_address"
                autofocus
                autocomplete="off"
                v-model="form.physical_address"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_physical_address"
              ></textarea>

              <div v-if="form.errors.physical_address" class="invalid-feedback d-block">
                <strong>{{ form.errors.physical_address[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="email"
                autofocus
                autocomplete="off"
                v-model="form.email"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_an_email"
              />

              <div v-if="form.errors.email" class="invalid-feedback d-block">
                <strong>{{ form.errors.email[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="phone_number"
                autofocus
                autocomplete="off"
                v-model="form.phone_number"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_phone_number"
              />

              <div v-if="form.errors.phone_number" class="invalid-feedback d-block">
                <strong>{{ form.errors.phone_number[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="twitter_url"
                autofocus
                autocomplete="off"
                v-model="form.twitter_url"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_twitter_url"
              />

              <div v-if="form.errors.twitter_url" class="invalid-feedback d-block">
                <strong>{{ form.errors.twitter_url[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="facebook_url"
                autofocus
                autocomplete="off"
                v-model="form.facebook_url"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_facebook_url"
              />

              <div v-if="form.errors.facebook_url" class="invalid-feedback d-block">
                <strong>{{ form.errors.facebook_url[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="instagram_url"
                autofocus
                autocomplete="off"
                v-model="form.instagram_url"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_instagram_url"
              />

              <div v-if="form.errors.instagram_url" class="invalid-feedback d-block">
                <strong>{{ form.errors.instagram_url[0] }}</strong>
              </div>
            </div>
          </div>

          <div class="form-group mb-5">
            <div class="col-lg-12">
              <input
                type="text"
                name="linkedin_url"
                autofocus
                autocomplete="off"
                v-model="form.linkedin_url"
                title="Name"
                @keyup.enter="savePlatform"
                class="form-control-lg form-control border-0 px-0 bg-transparent"
                :placeholder="trans.app.give_your_platform_a_linkedin_url"
              />

              <div v-if="form.errors.linkedin_url" class="invalid-feedback d-block">
                <strong>{{ form.errors.linkedin_url[0] }}</strong>
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
        @delete="deletePlatform"
        :header="trans.app.delete"
        :message="trans.app.deleted_platforms_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery"
import NProgress from "nprogress"
import AdminPage from '../../../components/AdminPage'
import PageHeader from "../../../components/PageHeader"
import DeleteModal from "../../../components/modals/DeleteModal"
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
  name: "platforms-edit",

  components: {
    AdminPage,
    PageHeader,
    DeleteModal
  },

  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {},
      platform: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        website_id: "",
        display_name: "",
        description: "",
        tag_line: "",
        physical_address: "",
        email: "",
        phone_number: "",
        twitter_url: "",
        facebook_url: "",
        instagram_url: "",
        linkedin_url: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations)
    }
  },

  created() {
    
  },

  mounted() {
    this.fetchData()
  },

  watch: {
    
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/platforms/" + this.id)
        .then(response => {
          this.platform = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            this.form.name = response.data.name
            this.form.website_id = response.data.website_id
            this.form.display_name = response.data.display_name
            this.form.description = response.data.description
            this.form.tag_line = response.data.tag_line
            this.form.physical_address = response.data.physical_address
            this.form.email = response.data.email
            this.form.phone_number = response.data.phone_number
            this.form.twitter_url = response.data.twitter_url
            this.form.facebook_url = response.data.facebook_url
            this.form.instagram_url = response.data.instagram_url
            this.form.linkedin_url = response.data.linkedin_url
          }

          this.isReady = true

          NProgress.done()
        })
        .catch(error => {
          this.$router.push({ name: "platforms" })
        })
    },

    savePlatform() {
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
        .post("/api/v1/platforms/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false
          this.form.hasSuccess = true
          this.id = response.data.id
          this.platform = response.data
        })
        .catch(error => {
          this.form.isSaving = false
          this.form.errors = error.response.data.errors
        })

      setTimeout(() => {
        this.form.hasSuccess = false
        this.form.isSaving = false
      }, 3000)
    },

    deletePlatform() {
      this.request()
        .delete("/api/v1/platforms/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide")

          this.$router.push({ name: "platforms" })
        })
        .catch(error => {
          // Add any error debugging...
        })
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show")
    },

    validate(form) {
      let errors = {}

      if (!form.name) {
        errors.name = ["name can not be empty"]
      }

      if (!form.website_id) {
        errors.website_id = ["website id can not be empty"]
      }

      return errors
    }
  }
}
</script>
