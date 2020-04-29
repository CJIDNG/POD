<template>
  <div>
    <page-header></page-header>

    <main class="text-center">
      <div class="row col-xl-10 col-md-12 mx-auto">


        <div class="container">
          <div class="row" style="margin-top: 100px">
            <div class="col-md-5 order-md-1 my-auto">
              <img src="/images/bob/boblogo.png" alt="" class="img-fluid">
              <h2 class="title">
                Body of Benchers
              </h2>
            </div>
            <div class="col-md-7 order-md-2">
              <img src="/images/bob/bg1.jpg" alt="" 
                  class="img-fluid img-rounded img-responsive">
            </div>
          </div>

          <div class="row" style="margin-top: 150px">
            <div class="col-md-8 ml-auto mr-auto">
              <h2 class="title bold">Who we are</h2>
              <p class="text-muted mt-5">
                Being a body created by an enabling law, the status of the 
                Body as provided under the Legal Practitioners Act is that of an 
                agency of the Federal Government under the Judiciary.
              </p>
            </div>
          </div>

          <!-- Three columns of text below the carousel -->
          <div class="row" style="margin-top: 100px">
            <div class="col-lg-4">
              <img :src="gravitas_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Regulations</h2>
              <p class="text-muted">
                Section 3 (5) of the Legal Practitioners Act provide that 
                the Body Of Benchers shall have the power to make regulations 
                for inter alia determining...
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img :src="call_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Call To Bar</h2>
              <p class="text-muted">
                One of the vital functions of the body is the formal 
                call to bar of persons desirous to become legal practitioners.
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img :src="judge_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Discipline Of Lawyers</h2>
              <p class="text-muted">
                Another vital function of the Body of Benchers is 
                the discipline of erring lawyers in Nigeria.
              </p>
            </div><!-- /.col-lg-4 -->
          </div><!-- /.row -->


          <div class="row" style="margin-top: 50px">
            <div class="col-md-8 ml-auto mr-auto">
              <h2 class="title bold">Latest News</h2>
            </div>
          </div>

          <div class="card-deck" style="margin-top: 50px">
            <div v-for="(post, index) in posts" :key="index" class="card">
              <img :src="post.featured_image" alt="" class="img-fluid">
              <div class="card-body">
                <h5 class="card-title">
                  <router-link
                    :to="`/blog/${post.slug}/show`"
                  >
                    {{ post.title }}
                  </router-link>
                </h5>
                <p class="card-text text-muted">
                  {{ trim(post.summary) }}
                </p>
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
import SortingSVG from "../../../../public/assets/svg/undraw_sorting_thoughts_6d48.svg"
import JudgeSVG from "../../../../public/assets/svg/judge.svg"
import CallSVG from "../../../../public/assets/svg/conference_call.svg"
import GravitasSVG from "../../../../public/assets/svg/gravitas.svg"

export default {
  name: "contact-index",

  components: {
    PageHeader
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      sorting_svg: SortingSVG,
      judge_svg: JudgeSVG,
      call_svg: CallSVG,
      gravitas_svg: GravitasSVG,
      posts: []
    };
  },

  mounted() {
    NProgress.done()
  },

  created() {
    this.fetchData()
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/blog", {
          params: {
            page: 1
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.posts = response.data.data.slice(0, 3)
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
