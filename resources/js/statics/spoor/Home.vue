<template>
  <div>
    <page-header></page-header>
    <div v-for="(post, index) in featuredPost" :key="index">
      <router-link
        :to="{ name: 'blog-post', params: { identifier: publicIdentifier(post), slug: post.slug } }"
      >
        <div class="banner-image-container">
          <div
            class="banner-image"
            :style="{ height:'500px', background:
            post.featured_image ? `url(${post.featured_image})` : 'grey', backgroundRepeat:'no-repeat', backgroundSize:'cover'}"
          >
            <span class="banner-desc">
              <h3>{{ post.title }}</h3>
              <small>
                <b-icon-clock></b-icon-clock>
                {{ moment(post.published_at).format('LL')}}
              </small>
            </span>
          </div>
        </div>
      </router-link>
    </div>
    <div class="row">
      <section class="col-sm-9 col-xs-6">
        <div class="featured-posts">
          <h4 class="text-uppercase font-weight-bold">Featured Research</h4>
          <div class="row">
            <div v-for="(post, index) in posts" :key="index" class="col-sm-4 col-xs-2">
              <div class="featured-post mb-4">
                <router-link
                  :to="{ name: 'blog-post', params: { identifier: publicIdentifier(post), slug: post.slug } }"
                >
                  <img
                    v-if="post.featured_image"
                    :src="post.featured_image"
                    class="card-img-top"
                    :alt="post.featured_image_caption"
                  />
                  <img class="img-fluid" v-else v-holder="'img=500x250?auto=yes&theme=thumb'" />
                </router-link>

                <h5 class="mt-2 mb-0">
                  <router-link
                    :to="{ name: 'blog-post', params: { identifier: publicIdentifier(post), slug: post.slug } }"
                  >{{ post.title }}</router-link>
                </h5>
                <span class="post-time">
                  <b-icon-clock></b-icon-clock>
                  {{ moment(post.published_at).format('LL')}}
                </span>
                <p
                  class="mb-1"
                  v-if="post.summary ||post.meta.description"
                >{{ trim(post.summary || post.meta.description, 50) }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="featured-topics">
          <div class="row">
            <div
              v-for="(data, index) in topicPosts"
              :key="index"
              class="col-sm-4 col-xs-3 topics-list mt-3 mb-3"
            >
              <h5 class="title">{{data.topic.name}}</h5>
              <div v-for="(data, index) in data.posts" :key="index">
                <router-link
                  class="topics-link"
                  :to="{ name: 'blog-post', params: { identifier: publicIdentifier(data), slug: data.slug } }"
                >{{data.title}}</router-link>
              </div>
              <router-link
                class="text-capitalize mt-4"
                :to="{name: 'blog-topic-posts', params: { slug: data.topic.slug }}"
              >All {{data.topic.name}}</router-link>
            </div>
          </div>
        </div>
      </section>
      <section class="col-sm-3 col-xs-2">
        <div class="featured-resources">
          <h4 class="text-uppercase font-weight-bold mb-3">Featured Resources</h4>
          <div v-for="(dataset, index) in datasets" :key="index">
            <h5 class="font-weight-bold mb-2">{{dataset.title}}</h5>
            <div v-for="(data, index) in dataset.resources" :key="index">
              <p>
                <router-link :to="{name: 'data-show', params: { id: data.id }}">{{ data.title }}</router-link>
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "contact-index",

  components: {

  },

  data () {
    return {
      featuredPost: [],
      datasets: [],
      topics: [],
      posts: [],
      topicPosts: [],
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
    };
  },

  created () {
    this.fetchLatestPosts()
    this.fetchTopicPosts()
    this.fetchDatasets()
  },

  mounted () {
    this.fetchAllTopics()
    NProgress.done()
  },
  methods: {
    fetchLatestPosts () {
      this.request()
        .get("/api/v1/blog/posts", {
          params: {
            page: 1
          }
        })
        .then(response => {
          this.featuredPost = response.data.posts.slice(0, 1)
          this.posts = response.data.posts.slice(1, 5)
          NProgress.done()
        })
        .catch(error => {
          NProgress.done()
        });
    },
    async fetchAllTopics () {
      await this.request()
        .get("/api/v1/blog/topics/")
        .then(response => {
          this.topics = response.data
          NProgress.done()
        })
        .catch(error => {
          NProgress.done()
        });
    },
    async fetchTopicPosts () {
      await this.fetchAllTopics()
      const topics = JSON.parse(JSON.stringify(this.topics))
      const topicPostsArray = []
      topics.map((items) => {
        this.request()
          .get("/api/v1/blog/topics/" + items.slug)
          .then(response => {
            topicPostsArray.push(response.data)
            NProgress.done()
          })
          .catch(error => {
            NProgress.done()
          });
      })
      this.topicPosts = topicPostsArray;
    },
    async fetchDatasets () {
      await this.request()
        .get("/api/v1/data")
        .then(response => {
          this.datasets = response.data.data.slice(0, 9)
          NProgress.done()
        })
        .catch(error => {
          NProgress.done()
        });
    }
  }

};
</script>

<style scoped>
@import url("/device-mockups/device-mockups.min.css");
@import url("/css/simple-line-icons.css");
.featured-posts,
.featured-topics,
.featured-resources {
  padding: 0 3rem;
}
.featured-posts h3 {
  font-weight: bold;
  padding-bottom: 1.5rem;
}
.featured-posts .card-img-top {
  height: 150px;
  border-radius: 0;
}
.featured-posts .post-time {
  font-size: 0.8rem;
  color: gray;
}

.banner-image-container {
  position: relative;
}
.banner-desc {
  background: rgba(255, 255, 255, 0.6);
  position: absolute;
  top: 60%;
  padding: 10px 15px;
}
.topics-list .title {
  text-transform: uppercase;
}
.topics-list .topics-link {
  font-weight: bolder;
}
.topics-list .topics-link:hover {
  color: #2c7a0d;
  text-decoration: none;
  font-weight: bolder;
}
section {
  padding: 50px 0;
}

section h2 {
  font-size: 50px;
}

section.download {
  position: relative;
  padding: 150px 0;
}

section.download h2 {
  font-size: 50px;
  margin-top: 0;
}

section.download .badges .badge-link {
  display: block;
  margin-bottom: 25px;
}

section.download .badges .badge-link:last-child {
  margin-bottom: 0;
}

section.download .badges .badge-link img {
  height: 60px;
}
@media (min-width: 768px) {
  section.download .badges .badge-link {
    display: inline-block;
    margin-bottom: 0;
  }
}

@media (min-width: 768px) {
  section.download h2 {
    font-size: 70px;
  }
}

section.features .section-heading {
  margin-bottom: 100px;
}

section.features .section-heading h2 {
  margin-top: 0;
}

section.features .section-heading p {
  margin-bottom: 0;
}

section.features .device-container,
section.features .feature-item {
  max-width: 325px;
  margin: 0 auto;
}

section.features .device-container {
  margin-bottom: 100px;
}

@media (min-width: 992px) {
  section.features .device-container {
    margin-bottom: 0;
  }
}

section.features .feature-item {
  padding-top: 50px;
  padding-bottom: 50px;
  text-align: center;
}

section.features .feature-item h3 {
  font-size: 30px;
}

section.features .feature-item i {
  font-size: 80px;
  display: block;
  margin-bottom: 15px;
  background: linear-gradient(to left, #7b4397, #dc2430);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

section.cta {
  position: relative;
  padding: 250px 0;
  background-image: url("/images/spoor/bg1.jpg");
  background-position: center;
  background-size: cover;
}

section.cta .cta-content {
  position: relative;
  z-index: 1;
}

section.cta .cta-content h2 {
  font-size: 50px;
  max-width: 450px;
  margin-top: 0;
  margin-bottom: 25px;
  color: white;
}

@media (min-width: 768px) {
  section.cta .cta-content h2 {
    font-size: 80px;
  }
}

section.cta .overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

section.contact {
  text-align: center;
}

section.contact h2 {
  margin-top: 0;
  margin-bottom: 25px;
}

section.contact h2 i {
  color: #dd4b39;
}

section.contact ul.list-social {
  margin-bottom: 0;
}

section.contact ul.list-social li a {
  font-size: 40px;
  line-height: 80px;
  display: block;
  width: 80px;
  height: 80px;
  color: white;
  border-radius: 100%;
}

section.contact ul.list-social li.social-twitter a {
  background-color: #1da1f2;
}

section.contact ul.list-social li.social-twitter a:hover {
  background-color: #0d95e8;
}

section.contact ul.list-social li.social-facebook a {
  background-color: #3b5998;
}

section.contact ul.list-social li.social-facebook a:hover {
  background-color: #344e86;
}

section.contact ul.list-social li.social-google-plus a {
  background-color: #dd4b39;
}

section.contact ul.list-social li.social-google-plus a:hover {
  background-color: #d73925;
}
#carousel-1.carousel-inner.carousel-item {
  display: none;
}
</style>
