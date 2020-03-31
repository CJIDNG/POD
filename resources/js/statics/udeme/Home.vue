<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">


        <div class="container marketing">
          <div class="row featurette mb-5">
            <div class="jumbotron">
              <h1 class="display-4">Udeme</h1>
              <p class="lead">
                ...empowering citizens with skills and resources to 
                hold the government accountable by ensuring that 
                public funds allocated and released for developmental 
                projects are well spent towards total elimination of corruption
              </p>
              <hr class="my-4">
              <p>
                By tracking and monitoring constituency, capital and ecological 
                projects across Nigeria, UDEME strengthen citizens through 
                capacity development for better service delivery.
              </p>
              <router-link class="btn btn-secondary" to="/about" role="button">
                Learn more
              </router-link>
            </div>
          </div>

          <!-- Three columns of text below the carousel -->
          <div class="row">
            <div class="col-lg-4">
              <img width="200" class="bd-placeholder-img rounded-circle" src="/images/udeme/search.png" alt="">
              <h2>Find It</h2>
              <p>
                get the latest budget documents for your community and how much has been released for implementation.
              </p>
              <p>
                <router-link class="btn btn-secondary" to="/about" role="button">
                  View details &raquo;
                </router-link>
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img width="200" class="bd-placeholder-img rounded-circle" src="/images/udeme/opinions.png" alt="">
              <h2>
                Weigh In
              </h2>
              <p>
                ensure the projects are properly executed to standard and beneficial to your community
              </p>
              <p>
                <router-link class="btn btn-secondary" to="/about" role="button">
                  View details &raquo;
                </router-link>
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img width="200" class="bd-placeholder-img rounded-circle" src="/images/udeme/surveillance.png" alt="">
              <h2>
                Watch It
              </h2>
              <p>
                be a part of the process by monitoring projects from start to finish.
              </p>
              <p>
                <router-link class="btn btn-secondary" to="/about" role="button">
                  View details &raquo;
                </router-link>
              </p>
            </div><!-- /.col-lg-4 -->
          </div><!-- /.row -->


          <!-- START THE FEATURETTES -->

          <hr class="featurette-divider">

          <div class="row featurette mb-5">
            <div class="col-md-7 my-auto">
              <h2 class="featurette-heading">
                Access to Information
              </h2>
              <p class="lead">
                Looking for projects nominated by lawmakers and government for your 
                community? You are in the right place. Get all you need 
                to know about the Freedom of Information (FOI) Act, its applicability 
                across states and states that comply with the FOIA.
              </p>
            </div>
            <div class="col-md-5">
              <img class="img-fluid" src="/images/udeme/girl_in_uniform.jpeg" alt="">
            </div>
          </div>

          <hr class="featurette-divider">

          <div class="row featurette mb-5">
            <div class="col-md-7 order-md-2 my-auto">
              <h2 class="featurette-heading">
                Participatory budget process
              </h2>
              <p class="lead">
                Become an active citizen today by advocating for inclusive 
                governance and participatory budgeting process. 
                Participatory budgeting empowers citizens to make decisions 
                about how funds allocated for their communities should 
                be used and in a transparent way.
              </p>
            </div>
            <div class="col-md-5 order-md-1">
              <img class="img-fluid" src="/images/udeme/kid_dancing.jpeg" alt="">
            </div>
          </div>

          <hr class="featurette-divider">

          <div class="row featurette mb-5">
            <div class="col-md-7  my-auto">
              <h2 class="featurette-heading">
                Citizen Engagement
              </h2>
              <p class="lead">
                Udeme is a citizen-oriented project. Explore and learn different means through which YOU can #GetInvolved
              </p>
            </div>
            <div class="col-md-5">
              <img class="img-fluid" src="/images/udeme/children_group_1.jpeg" alt="">
            </div>
          </div>

          <hr class="featurette-divider">

          <!-- /END THE FEATURETTES -->


          <div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
          <div class="row">
            <div class="col-md-6 px-0 my-auto">
              <h1 class="display-5 font-italic">U-Monitor</h1>
              <p class="lead my-3">
                With the right skills, experience, resources and motivation, you 
                could be the next person we are looking for to join our TEAM. 
                Join the largest social accountability network of young people 
                with a passion to transform their community. Become a U-Monitor 
                (UDEME Monitor) today.
              </p>

              <p class="lead my-3">
                Send your cv and cover letter to ijeoma@ptcij.org
              </p>
            </div>
            <div class="col-md-6 px-0">
              <img 
                src="/images/udeme/portfolio.png" 
                class="card-img-right flex-auto d-none d-lg-block img-fluid" 
                alt="Card image cap">
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
      trans: JSON.parse(CurrentTenant.lang),
      platform: CurrentTenant.platform
    };
  },

  mounted() {
    NProgress.done()
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
