<template>
  <div>
    <page-header></page-header>

    <main class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">

        <div class="row justify-content-md-center">
          <div class="col col-lg-8">


            <h1 class="pt-5 mb-4">{{ post.title }}</h1>
            <div class="media py-1">
              <img :src="avatar"
                class="mr-3 rounded-circle"
                style="width: 50px"
                :alt="post.user ? post.user.name : ''">
              <div class="media-body">
                <p class="mt-0 mb-1 font-weight-bold">{{ post.user ? post.user.name : '' }}</p>
                <span class="text-muted">{{ moment(post.published_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </div>
            </div>

            <img v-if="post.featured_image" :src="post.featured_image" class="w-100 pt-4"
              :alt="post.featured_image_caption || ''" :title="post.featured_image_caption || ''">

            <div class="content-body mt-4 pb-3" v-html="post.body"></div>

            <h5>
              <span v-for="(tag, index) in post.tags" :key="index" class="badge badge-success p-2 tag mr-2">
                {{ tag.name }}
              </span>
            </h5>

            <!-- <div class="read-more mt-5 container-fluid">
              <div class="row">

                
                <div class="col-lg">
                  <div v-if="random" class="card flex-md-row mb-4 shadow-sm h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                      <div class="d-flex flex-row mb-2 text-success">
                        <strong 
                          v-for="(tag, index) in random.tags"
                          :key="index"
                          class="d-inline-block text-success ml-2"
                        >{{ tag.name }}</strong>
                      </div>
                      <h3 class="mb-0">
                        <router-link
                          :to="`/blog/${random.slug}/show`"
                        >
                          {{ random.title }}
                        </router-link>
                      </h3>
                      <div class="mb-1 text-muted">{{ moment(random.approved_at).locale(CurrentTenant.locale).fromNow() }}</div>
                      <p class="card-text mb-auto">
                        {{ `${random.summary.substring(0, 100)}...` }}
                      </p>
                      <router-link
                        :to="`/blog/${random.slug}/show`"
                        class="text-white font-weight-bold"
                      >
                        {{ `${trans.app.continue_reading}...` }}
                      </router-link>
                    </div>
                    <img 
                      v-if="random.featured_image" :src="random.featured_image" 
                      class="card-img-right flex-auto d-none d-lg-block" 
                      alt="Card image cap"
                      width="200">
                    <img v-else v-holder="'img=200x250?auto=yes&theme=thumb'">
                  </div>
                </div>

                <div class="col-lg">
                  <div v-if="post.next" class="card flex-md-row mb-4 shadow-sm h-md-100">
                    <div class="card-body d-flex flex-column align-items-start">
                      <div class="d-flex flex-row mb-2 text-success">
                        <strong 
                          v-for="(tag, index) in next.tags"
                          :key="index"
                          class="d-inline-block text-success ml-2"
                        >{{ tag.name }}</strong>
                      </div>
                      <h3 class="mb-0">
                        <router-link
                          :to="`/blog/${random.slug}/show`"
                        >
                          {{ next.title }}
                        </router-link>
                      </h3>
                      <div class="mb-1 text-muted">{{ moment(next.approved_at).locale(CurrentTenant.locale).fromNow() }}</div>
                      <p class="card-text mb-auto">
                        {{ `${next.summary.substring(0, 100)}...` }}
                      </p>
                      <router-link
                        class="text-white font-weight-bold"
                      >
                        {{ `${trans.app.continue_reading}...` }}
                      </router-link>
                    </div>
                    <img 
                      v-if="next.featured_image" :src="next.featured_image" 
                      class="card-img-right flex-auto d-none d-lg-block" 
                      alt="Card image cap"
                      width="50">
                    <img v-else v-holder="'img=50x100?auto=yes&theme=thumb'">
                  </div>
                </div>


              </div>
            </div> -->


          </div>
        </div>




      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment"
import NProgress from "nprogress"
import PageHeader from "../../../components/PageHeader"
import {MD5} from './../../../util/md5'
import PageFooter from "../../../components/PageFooter"

export default {
  name: "blog-show",

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
      post: {},
      meta: {},
      next: {},
      random: {},
      topic: {},
      avatar: '',
      slug: this.$route.params.slug,
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  computed: {
    
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/blog/view/" + vm.slug)
        .then(response => {
          vm.post = response.data.post
          vm.meta = response.data.meta
          vm.next = response.data.next
          vm.random = response.data.random
          vm.topic = response.data.topic

          vm.setMetaTitle(vm.post.title)
          vm.setMetaDescription(vm.post.description)
          vm.setMetaImageUrl(vm.post.featured_image)
          vm.setMetaCanonicalLink(vm.post.meta.canonical_link)
          console.log(vm.$meta().refresh())

          vm.avatar = `https://secure.gravatar.com/avatar/${MD5(vm.post.user.email.toLowerCase().trim())}?s=200`

          vm.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          // vm.$router.push({ name: "blog" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
