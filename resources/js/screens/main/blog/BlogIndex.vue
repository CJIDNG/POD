<template>
  <div>
    <page-header></page-header>

    <div class="py-4">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">


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

        <div class="row mb-2">
          <div v-for="(post, index) in subfeaturedPosts" :key="index" class="col-md-6">
            <div class="card flex-md-row mb-4 shadow-sm h-md-250">
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
                  {{ `${post.summary.substring(0, 100)}...` }}
                </p>
                <router-link
                  :to="`/blog/${post.slug}/show`"
                  class="text-white font-weight-bold"
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
          </div>
        </div>


        <main role="main">

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
        </main>

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

  data() {
    return {
      page: 1,
      posts: [],
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
    },

    subfeaturedPosts() {
      let subFeaturedPosts = []

      if (Array.isArray(this.posts) && this.posts.length > 1) {
        subFeaturedPosts.push(this.posts[1])
      } 

      if (Array.isArray(this.posts) && this.posts.length > 2) {
        subFeaturedPosts.push(this.posts[2])
      }

      return subFeaturedPosts
    },
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/blog", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.posts.push(...response.data.data);
            this.from = response.data.from
            this.to = response.data.to
            this.total = response.data.total

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
  }
};
</script>

<style scoped></style>
