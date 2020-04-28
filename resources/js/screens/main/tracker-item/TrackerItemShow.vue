<template>
  <div>
    <page-header>
      <template slot="action">
        <a
          v-if="canComment"
          href="#"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
          @click="showNewCommentModal"
        >
          <span class="d-block d-lg-none">{{ trans.app.new_update }}</span>
          <span class="d-none d-lg-block">{{ trans.app.new_update }}</span>
        </a>
      </template>
    </page-header>

    <main v-if="isReady" class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="row">
          <div class="col-md-6">
            <!-- <pre v-html="prettyJSON(trackerItem)"></pre> -->
            <div class="list-group">

              <a 
                v-for="(field, index) in tracker.fields" 
                :key="index" 
                class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ field.label }}</h5>
                </div>
                <p class="mb-1">
                  {{
                    (field.type == 'input' && field.inputType == 'date') ? 
                      moment(trackerItem.meta[field.model]).format('DD-MM-YYYY') : trackerItem.meta[field.model] 
                  }}
                </p>
                <small></small>
              </a>

            </div>
          </div>
          <div class="col-md-6" style="max-height: 650px; overflow: scroll; position: relative">
            <h1 class="bg-white" style="position: sticky; top: 0; width: 100%">
              {{trans.app.feed}}
              <hr>
            </h1>
            <div class="mt-5" v-for="(comment, index) in trackerItem.comments" :key="index">
              <div class="media">
                <div class="media-body">
                  <h5 class="mt-0 text-bold">
                    {{ comment.commentator.name }}
                    <small v-if="comment.is_approved == 1" class="badge badge-info">
                      {{ trans.app.verified }}
                    </small>
                    <small v-else class="badge badge-danger">
                      {{ trans.app.not_verified }}
                    </small>
                  </h5>
                  <p v-html="comment.comment"></p>
                  <p class="text-muted">{{moment(comment.created_at).locale(CurrentTenant.locale).fromNow()}}</p>
                </div>
              </div>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </main>

    <new-comment-modal 
      v-if="isReady" 
      ref="newCommentModal" 
      :trackerId="tracker.id" 
      :trackerItemId="trackerItem.id"
    />

    <page-footer></page-footer>
  </div>
</template>

<script>
import $ from "jquery";
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"
import NewCommentModal from "../../../components/modals/tracker/NewCommentModal"

export default {
  name: "trackerItems-show",

  components: {
    PageHeader,
    PageFooter,
    NewCommentModal
  },

  metaInfo() {
    let metaTitle = this.metaTitle
    let metaSiteName = this.metaSiteName
    return {
      // Children can override the title.
      title: metaTitle + ' - ' + metaSiteName,
      // Result: My Page Title ← My Site
      // If a child changes the title to "My Other Page Title",
      // it will become: My Other Page Title ← My Site
      titleTemplate: '%s',
      // Define meta tags here.
      meta: [
        {vid: 'http-equiv', 'http-equiv': 'Content-Type', content: 'text/html; charset=utf-8'},
        {vid: 'viewport', name: 'viewport', content: 'width=device-width, initial-scale=1'},
        {vid: 'description', name: 'description', content: this.metaDescription},
        // OpenGraph data (Most widely used)
        {vid: 'og:title', property: 'og:title', content: this.metaTitle},
        {vid: 'og:site_name', property: 'og:site_name', content: this.metaSiteName},
        // The list of types is available here: http://ogp.me/#types
        {vid: 'og:type', property: 'og:type', content: 'website'},
        // Should the the same as your canonical link, see below.
        {vid: 'og:url', property: 'og:url', content: this.metaUrl},
        {vid: 'og:image', property: 'og:image', content: this.metaImageUrl},
        // Often the same as your meta description, but not always.
        {vid: 'og:description', property: 'og:description', content: this.metaDescription},

        // Twitter card
        {vid: 'twitter:card', name: 'twitter:card', content: this.metaDescription},
        {vid: 'twitter:site', name: 'twitter:site', content: this.metaUrl},
        {vid: 'twitter:title', name: 'twitter:title', content: this.metaTitle},
        {vid: 'twitter:description', name: 'twitter:description', content: this.metaDescription},
        // Your twitter handle, if you have one.
        {vid: 'twitter:creator', name: 'twitter:creator', content: '@starfolksoftware'},
        {vid: 'twitter:image:src', name: 'twitter:image:src', content: this.metaImageUrl},

        // Google / Schema.org markup:
        {vid: 'ipname', itemprop: 'name', content: this.metaSiteName},
        {vid: 'ipdescription', itemprop: 'description', content: this.metaDescription},
        {vid: 'ipimage', itemprop: 'image', content: this.metaImageUrl}
      ],
      link: [
        {vid: 'canonical', rel: 'canonical', href: this.metaCanonicalLink}
      ]
    }
  },

  data() {
    return {
      isReady: false,
      trackerItem: {},
      tracker: {},
      trans: JSON.parse(CurrentTenant.translations),
      id: this.$route.params.id
    };
  },

  computed: {
    canComment() {
      return this.isLoggedIn && (this.hasPermission('create_tracker_items') || 
        this.hasPermission('update_tracker_items'))
    }
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      Promise.all([
        vm.request()
          .get(`/api/v1/trackerItems/${to.params.trackerId}/${vm.id}`),
        vm.request()
          .get("/api/v1/trackers/" + to.params.trackerId)
      ]).then(([trackerItemResponse, trackerResponse]) => {
        vm.trackerItem = trackerItemResponse.data
        vm.tracker = trackerResponse.data
        NProgress.done()
        vm.isReady = true
      })
    });
  },

  methods: {
    showNewCommentModal() {
      $(this.$refs.newCommentModal.$el).modal("show")
    },
  }
};
</script>

<style scoped></style>
