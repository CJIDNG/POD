<template>
  <!-- Footer -->
  <footer class="page-footer font-small unique-color-dark mt-5">

    <div style="background-color: #eee;">
      <div class="container">

        <!-- Grid row-->
        <div class="row py-4 d-flex align-items-center">

          <!-- Grid column -->
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
            <h6 class="mb-0">{{ trans.app.get_connected_with_us }}</h6>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-6 col-lg-7 text-center text-md-right">

            <!-- Facebook -->
            <a v-if="platform.facebook_url" class="fb-ic" target="_blank" :href="platform.facebook_url">
              <i class="fab fa-facebook-f white-text mr-4"> </i>
              Facebook
            </a>
            <!-- Twitter -->
            <a v-if="platform.twitter_url" class="tw-ic" target="_blank" :href="platform.twitter_url">
              <i class="fab fa-twitter white-text mr-4"> </i>
              Twitter
            </a>
            <!--Linkedin -->
            <a v-if="platform.linkedin_url" class="li-ic" target="_blank" :href="platform.linkedin_url">
              <i class="fab fa-linkedin-in white-text mr-4"> </i>
              Linkedin
            </a>
            <!--Instagram-->
            <a v-if="platform.instagram_url" class="ins-ic" target="_blank" :href="platform.instagram_url">
              <i class="fab fa-instagram white-text"> </i>
              Instagram
            </a>

          </div>
          <!-- Grid column -->

        </div>
        <!-- Grid row-->

      </div>
    </div>

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">

      <!-- Grid row -->
      <div class="row mt-3">

        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

          <!-- Content -->
          <h6 class="text-uppercase font-weight-bold">{{ platform.name }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p v-if="platform.description">
            {{ trim(platform.description.replace(/(<([^>]+)>)/ig,""), 255) }}
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.platforms }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          
          <p v-for="(platform, index) in allPlatforms" :key="index">
            <a target="_blank" :href="`https://${platform.name}`">
              {{ platform.name }}
            </a>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.useful_links }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <router-link to="/about">
              {{ trans.app.about }}
            </router-link>
          </p>
          <p>
            <router-link to="/blog">
              {{ trans.app.blog }}
            </router-link>
          </p>
          <p>
            <router-link to="/contact">
              {{ trans.app.contact }}
            </router-link>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.contact }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <i class="fas fa-home mr-3"></i> {{ platform.physical_address }}
          </p>
          <p>
            <i class="fas fa-envelope mr-3"></i> {{ platform.email }}
          </p>
          <p>
            <i class="fas fa-phone mr-3"></i> {{ platform.phone_number }}
          </p>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a target="_blank" href="https://ptcij.org/"> {{platform.name}}</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
</template>

<script>
export default {
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      allPlatforms: CurrentTenant.allPlatforms
    };
  },
}
</script>

<style>

</style>