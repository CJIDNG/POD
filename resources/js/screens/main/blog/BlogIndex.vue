<template>
  <div>
    <page-header></page-header>

    <div class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        
        <div class="nav-scroller py-1 mb-2">
          <nav class="nav d-flex justify-content-between">
            <a
              href="#"
              v-for="(topic, index) in topics"
              :key="index"
              @click.prevent="filterPosts('topic', topic.slug)"
              class="p-2 text-muted">
              {{ topic.name }}
            </a>
          </nav>
        </div>

        <div v-if="featuredPost.title" class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
          <div class="row">
            <div class="col-md-6 px-0">
              <h1 class="display-4 font-italic">{{ featuredPost.title }}</h1>
              <p class="lead my-3">
                {{ featuredPost.summary }}
              </p>
              <p class="lead mb-0">
                <router-link
                  class="text-white font-weight-bold"
                  :to="`/blog/${featuredPost.slug}/show`"
                >
                  {{ `${trans.app.continue_reading}...` }}
                </router-link>
              </p>
            </div>
            <div class="col-md-6 px-0">
              <img 
                v-if="featuredPost.featured_image" :src="featuredPost.featured_image" 
                class="card-img-right flex-auto d-none d-lg-block img-fluid" 
                alt="Card image cap">
              <img class="img-fluid" v-else v-holder="'img=200x250?auto=yes&theme=thumb'">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-md-8">
            <main>
              <div class="mt-2" >
                <div v-for="(post, $index) in posts" 
                  :key="$index"  
                  class="card flex-md-row mb-4 shadow-sm h-md-250">
                  <div class="card-body d-flex flex-column align-items-start">
                    <div class="d-flex flex-row mb-2 text-success">
                      <strong 
                        v-for="(tag, index) in post.tags"
                        :key="index"
                        class="d-inline-block text-success ml-2"
                      >{{ tag.name }}</strong>
                    </div>
                    <h3 class="mb-0">
                      <router-link
                        :to="`/blog/${post.slug}/show`"
                      >
                        {{ post.title }}
                      </router-link>
                    </h3>
                    <div class="mb-1 text-muted">{{ moment(post.approved_at).locale(CurrentTenant.locale).fromNow() }}</div>
                    <p class="card-text mb-auto">
                      {{ `${post.summary.substring(0, 174)}...` }}
                    </p>
                    <router-link
                      :to="`/blog/${featuredPost.slug}/show`"
                    >
                      {{ `${trans.app.continue_reading}...` }}
                    </router-link>
                  </div>
                  <img 
                    v-if="post.featured_image" :src="post.featured_image" 
                    class="card-img-right flex-auto d-none d-lg-block" 
                    alt="Card image cap"
                    width="200">
                  <img v-else v-holder="'img=200x250?auto=yes&theme=thumb'">
                </div>

                <infinite-loading
                  @infinite="fetchData" 
                  :identifier="infiniteId"
                  spinner="spiral" 
                  style="position: relative; top: 0">
                  <span slot="no-more"></span>
                  <div slot="no-results" class="text-left">
                    <div class="mt-5">
                      <p class="lead text-center text-muted mt-5 pt-5">
                        <span>
                          {{trans.app.you_have_no_results}}
                        </span>
                      </p>
                    </div>
                  </div>
                </infinite-loading>
              </div>
            </main>
          </div>
          <div class="col-12 col-md-4">
            <aside>
              <div class="p-4">
                <h4 class="font-italic">{{ trans.app.tags }}</h4>
                <ol class="list-unstyled mb-0">
                  <li
                    v-for="(tag, index) in tags"
                    :key="index"
                  >
                    <a 
                      href="#"
                      @click.prevent="filterPosts('tag', tag.slug)"
                      >
                      {{ tag.name }}
                    </a>
                  </li>
                </ol>
              </div>
            </aside>
          </div>
        </div>

      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"

export default {
  name: "blog-index",

  components: {
    InfiniteLoading,
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
      page: 1,
      infiniteId: +new Date(),
      posts: [],
      tags: [],
      topics: [],
      filterBy: '',
      filter: '',
      trans: JSON.parse(CurrentTenant.lang),
      from: "",
      to: "",
      total: "",
    };
  },

  computed: {
    featuredPost() {
      let post = {}

      if (Array.isArray(this.posts) && this.posts.length > 0) {
        post = this.posts[0]
      }

      return post
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/blog", {
          params: {
            page: this.page,
            filterBy: this.filterBy || null,
            filter: this.filter || null
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            console.log(this.$meta().refresh())
            this.posts.push(...response.data.data);
            this.from = response.data.from
            this.to = response.data.to
            this.total = response.data.total
            this.tags = response.data.tags
            this.topics = response.data.topics

            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    },

    filterPosts (filterBy, filter) {
      this.filterBy = filterBy
      this.filter = filter
      this.page = 1
      this.posts = []
      this.infiniteId += 1
    }
  }
};
</script>

<style scoped></style>
