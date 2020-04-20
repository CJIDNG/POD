<template>
  <div>
    <page-header></page-header>

    <main class="py-4">
      {{member}}
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"

export default {
  name: "member-show",

  components: {
    PageHeader,
    PageFooter
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
      member: {},
      trans: JSON.parse(CurrentTenant.lang),
      id: this.$route.params.id
    };
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/members/" + vm.id)
        .then(response => {
          vm.member = response.data

          NProgress.done();
        })
        .catch(error => {
          vm.$router.push({ name: "members-main" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
