<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="container marketing">


          <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
              <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="/images/spoor/spoor1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Insights</h5>
                  <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                </div>
              </div>
              <div class="carousel-item">
                <img src="/images/spoor/spoor_logo.png" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Analysis</h5>
                  <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                </div>
              </div>
              <div class="carousel-item">
                <img src="/images/spoor/spoor2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Solutions</h5>
                  <!-- <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p> -->
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
          
          <div class="mt-5 mb-5">
            <iframe width="100%" height="600" src="//jsfiddle.net/frknasir/ckrovnpb/7/embedded/result/dark/" allowfullscreen="allowfullscreen" allowpaymentrequest frameborder="0"></iframe>
          </div>

          <div class="card-deck">
            <div 
              v-for="(post, index) in posts" 
              :key="index"
              class="card"
            >
              <router-link
                :to="`/blog/${post.slug}/show`">
                <img v-if="post.featured_image" :src="post.featured_image" class="card-img-top" :alt="post.featured_image_caption">
                <img class="img-fluid" v-else v-holder="'img=500x250?auto=yes&theme=thumb'">
              </router-link>
              <div class="card-body">
                <h5 class="card-title">
                  <router-link
                    :to="`/blog/${post.slug}/show`">
                    {{ post.title }}
                  </router-link>
                </h5>
                <p class="card-text" v-html="post.description"></p>
                <p class="card-text">
                  <small class="text-muted">
                    {{ moment(post.published_at).locale(CurrentTenant.locale).fromNow() }}
                  </small>
                </p>
              </div>
            </div>
          </div>

        </div><!-- /.container -->

      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../components/PageHeader";

export default {
  name: "contact-index",

  components: {
    PageHeader
  },

  data() {
    return {
      posts: [],
      trans: JSON.parse(CurrentTenant.lang),
      platform: CurrentTenant.platform
    };
  },

  created() {
    this.fetchLatestPosts()
  },

  mounted() {
    
  },

  methods: {
    fetchLatestPosts() {
      this.request()
        .get("/api/v1/blog", {
          params: {
            page: 1
          }
        })
        .then(response => {
          this.posts = response.data.data.splice(0, 3)
          NProgress.done()
        })
        .catch(error => {
          NProgress.done()
        });
    },
  }
};
</script>

<style scoped></style>
