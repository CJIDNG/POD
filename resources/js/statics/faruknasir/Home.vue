<template>
  <div class="font-serif">
    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">


        <div class="container">
          
          <div class="row">
            <div class="col-md-4 my-auto">
              <img src="/images/faruknasir/faruk.jpg" class="img-fluid rounded" alt="...">
            </div>
            <div class="col-md-8">
              <div class="jumbotron jumbotron-fluid bg-transparent">
                <div class="container">
                  <h1 class="display-1 font-serif font-weight-bolder">Faruk Nasir</h1>
                  <h3 class="display-5">
                    <i class="text-lowercase">
                      Full Stack Developer <br>
                      <small class="text-capitalize">Abuja, Nigeria</small>
                    </i>
                  </h3>
                </div>
              </div>

              <div>
                <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
                  <h1 class="display-4 font-serif text-capitalize">Get in touch!</h1>
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
                            <a target="_blank" href="https://twitter.com/frknasir" class="btn">
                              <i class="fab fa-twitter"></i>
                              Twitter
                            </a>
                          </li>
                          <li class="list-inline-item">
                            <a target="_blank" href="https://www.linkedin.com/in/frknasir/" class="btn">
                              <i class="fab fa-linkedin"></i>
                              LinkedIn
                            </a>
                          </li>
                          <li class="list-inline-item">
                            <a target="_blank" href="https://github.com/frknasir" class="btn">
                              <i class="fab fa-github"></i>
                              Github
                            </a>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
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
