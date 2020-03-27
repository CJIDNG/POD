<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
          <h1 class="display-4">{{ trans.app.contact_us }}</h1>
          <div class="lead">
            <ul class="list-unstyled">
              <li class="">
                {{ platform.email }}
              </li>
              <li class="">
                {{ platform.phone_number }}
              </li>
              <li class="">
                {{ platform.physical_address }}
              </li>
              <li class="mt-5">
                <ul class="list-inline">
                  <li class="list-inline-item">
                    <a target="_blank" :href="platform.twitter_url" class="btn">
                      Twitter
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a target="_blank" :href="platform.facebook_url" class="btn">
                      Facebook
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a target="_blank" :href="platform.instagram_url" class="btn">
                      Instagram
                    </a>
                  </li>
                  <li class="list-inline-item">
                    <a target="_blank" :href="platform.linkedin_url" class="btn">
                      LinkedIn
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
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
