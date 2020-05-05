<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">


        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4">{{ trans.app.about }} <span class="text-capitalize">{{ platform.name }}</span></h1>
          <p class="lead text-left" v-html="platform.description"></p>
        </div>


      </div>

      <div class="container">
        <!-- <div class="card-deck mb-3 text-center">
          <div class="card mb-4 shadow-sm">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Find It</h4>
            </div>
            <div class="card-body">
              
            </div>
          </div>
          <div class="card mb-4 shadow-sm">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Watch It</h4>
            </div>
            <div class="card-body">
              
            </div>
          </div>
          <div class="card mb-4 shadow-sm">
            <div class="card-header">
              <h4 class="my-0 font-weight-normal">Weigh In</h4>
            </div>
            <div class="card-body">
              
            </div>
          </div>
        </div> -->
      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";

export default {
  name: "contact-index",

  components: {
    
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
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
