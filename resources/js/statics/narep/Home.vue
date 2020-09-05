<template>
  <div>
    <page-header></page-header>

    <main class="text-center">
      <header class="masthead">
        <div class="container h-100">
          <div class="row h-100">
            <div class="col-lg-7 my-auto">
              <div class="header-content mx-auto">
                <h1>
                  N A R E P
                  <br />
                  <small>
                    An initiative for the transparency and
                    accountability of the Nigerian extractive
                    sector.
                  </small>
                </h1>
              </div>
            </div>
            <div class="col-lg-5 my-auto">
              <div class="device-container">
                <div class="device-mockup iphone6_plus portrait white">
                  <div class="device">
                    <div class="screen">
                      <img src="/images/narep/woman_and_child.jpeg" class="img-fluid" alt />
                      <img src="/images/narep/children.jpg" class="img-fluid" alt />
                      <img src="/images/narep/woman_and_child2.jpeg" class="img-fluid" alt />
                    </div>
                    <div class="button"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <section class="features" id="features">
        <div class="container">
          <div class="section-heading text-center">
            <h2>In a nut shell</h2>
            <p class="text-muted">An initiative of PTCIJ</p>
            <hr />
          </div>
          <div class="row">
            <div class="col-lg-4 my-auto">
              <div class="device-container">
                <div class="device-mockup iphone6_plus portrait white">
                  <div class="device">
                    <div class="screen">
                      <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                      <img src="/images/narep/woman_and_child2.jpeg" class="img-fluid" alt />
                      <img src="/images/narep/woman_and_child.jpeg" class="img-fluid" alt />
                      <img src="/images/narep/children.jpg" class="img-fluid" alt />
                    </div>
                    <div class="button">
                      <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 my-auto">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="feature-item">
                      <i class="icon-book-open text-primary"></i>
                      <h3>Stories</h3>
                      <p class="text-muted">
                        Insights, patterns and trends gleaned from
                        collected data
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="feature-item">
                      <i class="icon-docs text-primary"></i>
                      <h3>Policy Briefs</h3>
                      <p class="text-muted">
                        Concise summary of issues, options to deal with and
                        recommendations on the best option.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="feature-item">
                      <i class="icon-graph text-primary"></i>
                      <h3>FAAC Facts</h3>
                      <p class="text-muted">Facts from Nigerian extractive industries initiative.</p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="feature-item">
                      <i class="icon-chart text-primary"></i>
                      <h3>Data</h3>
                      <p class="text-muted">
                        Collection, indexing and subsequent presentation of information
                        in machine downloadable formats
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <header>
        <iframe
          src="https://www.google.com/maps/d/embed?mid=16k4tL1oeUA8wE-B-WHNv4c1bP4w"
          width="100%"
          height="680"
        ></iframe>
      </header>

      <section class="cta text-white">
        <div class="cta-content">
          <div class="container">
            <label style="font-size: 2rem" class="mr-5">Transparency.</label>
            <label style="font-size: 2rem" class="mr-5">Accountability.</label>
            <label style="font-size: 2rem" class="mr-5">Effective Utilisation.</label>
          </div>
        </div>
        <div class="overlay"></div>
      </section>
      <section>
        <div class="container">
          <div class="card-deck">
            <div v-for="(post, index) in posts" :key="index" class="card">
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
              <div class="card-body">
                <h5 class="card-title">
                  <router-link
                    :to="{ name: 'blog-post', params: { identifier: publicIdentifier(post), slug: post.slug } }"
                  >{{ post.title }}</router-link>
                </h5>
                <p class="card-text" v-html="post.description"></p>
                <p class="card-text">
                  <small
                    class="text-muted"
                  >{{ moment(post.published_at).locale(CurrentTenant.locale).fromNow() }}</small>
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "contact-index",
  data () {
    return {
      posts: [],
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform
    };
  },

  created () {
    this.fetchLatestPosts()
  },

  mounted () {
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
          this.posts = response.data.posts.splice(0, 3)
          NProgress.done()
        })
        .catch(error => {
          NProgress.done()
        });
    },
  }
};
</script>

<style scoped>
@import url("/device-mockups/device-mockups.min.css");
@import url("/css/simple-line-icons.css");
header.masthead {
  position: relative;
  width: 100%;
  padding-top: 150px;
  padding-bottom: 100px;
  color: white;
  background: url("/images/narep/bg-pattern.png"), #c94b4b;
  background: url("/images/narep/bg-pattern.png"),
    linear-gradient(to left, #c94b4b, #4b134f);
}

header.masthead .header-content {
  max-width: 500px;
  margin-bottom: 100px;
  text-align: center;
}

header.masthead .header-content h1 {
  font-size: 30px;
}

header.masthead .device-container {
  max-width: 325px;
  margin-right: auto;
  margin-left: auto;
}

header.masthead .device-container .screen img {
  border-radius: 3px;
}

@media (min-width: 992px) {
  header.masthead {
    height: 100vh;
    min-height: 775px;
    padding-top: 0;
    padding-bottom: 0;
  }
  header.masthead .header-content {
    margin-bottom: 0;
    text-align: left;
  }
  header.masthead .header-content h1 {
    font-size: 50px;
    color: white;
  }
  header.masthead .device-container {
    max-width: 325px;
  }
}

section {
  padding: 100px 0;
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
  background-image: url("/images/narep/bg1.jpg");
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
</style>
