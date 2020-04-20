export default {
  // metaInfo() {
  //   let metaTitle = this.metaTitle
  //   let metaSiteName = this.metaSiteName
  //   return {
  //     // Children can override the title.
  //     title: metaTitle + ' - ' + metaSiteName,
  //     // Result: My Page Title ← My Site
  //     // If a child changes the title to "My Other Page Title",
  //     // it will become: My Other Page Title ← My Site
  //     titleTemplate: '%s',
  //     // Define meta tags here.
  //     meta: [
  //       {'http-equiv': 'Content-Type', content: 'text/html; charset=utf-8'},
  //       {name: 'viewport', content: 'width=device-width, initial-scale=1'},
  //       {name: 'description', content: this.metaDescription},
  //       // OpenGraph data (Most widely used)
  //       {property: 'og:title', content: this.metaTitle},
  //       {property: 'og:site_name', content: this.metaSiteName},
  //       // The list of types is available here: http://ogp.me/#types
  //       {property: 'og:type', content: 'website'},
  //       // Should the the same as your canonical link, see below.
  //       {property: 'og:url', content: this.metaUrl},
  //       {property: 'og:image', content: this.metaImageUrl},
  //       // Often the same as your meta description, but not always.
  //       {property: 'og:description', content: this.metaDescription},

  //       // Twitter card
  //       {name: 'twitter:card', content: this.metaDescription},
  //       {name: 'twitter:site', content: this.metaUrl},
  //       {name: 'twitter:title', content: this.metaTitle},
  //       {name: 'twitter:description', content: this.metaDescription},
  //       // Your twitter handle, if you have one.
  //       {name: 'twitter:creator', content: '@starfolksoftware'},
  //       {name: 'twitter:image:src', content: this.metaImageUrl},

  //       // Google / Schema.org markup:
  //       {itemprop: 'name', content: this.metaSiteName},
  //       {itemprop: 'description', content: this.metaDescription},
  //       {itemprop: 'image', content: this.metaImageUrl}
  //     ],
  //     link: [
  //       {rel: 'canonical', href: this.metaCanonicalLink}
  //     ]
  //   }
  // },

  data() {
    return {
      metaTitle: window.CurrentTenant.platform.name,
      metaDescription: window.CurrentTenant.platform.description,
      metaSiteName: window.CurrentTenant.platform.name,
      metaUrl: `https://${window.CurrentTenant.platform.name}${this.$route.fullPath}`,
      metaImageUrl: '',
      metaCanonicalLink: `https://${window.CurrentTenant.platform.name}${this.$route.fullPath}`
    }
  },

  methods: {
    setMetaTitle(title) {
      this.metaTitle = title
    },

    setMetaDescription(description) {
      this.metaDescription = description
    },

    setMetaSiteName(metaSiteName) {
      this.metaSiteName = metaSiteName
    },

    setMetaUrl(metaUrl) {
      this.metaUrl = metaUrl
    },

    setMetaImageUrl(metaImageUrl) {
      this.metaImageUrl = `https://${window.CurrentTenant.platform.name}${metaImageUrl}`
    },

    setMetaCanonicalLink(link) {
      this.metaCanonicalLink = link
    }
  }
}