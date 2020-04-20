<template>
  <div>
    <home></home>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageFooter from "../../../components/PageFooter"
import {
  Statics,
} from "../../../statics"

export default {
  name: "home-index",

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

  components: {
    Home: Statics.Home,
    PageFooter
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.lang)
    };
  },

  mounted() {
    
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
