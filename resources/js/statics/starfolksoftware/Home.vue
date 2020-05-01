<style scoped>
  /* fonts */
  @import "https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800";

  /* icons */
  @import "/assets/themes/argon/assets/vendor/nucleo/css/nucleo-icons.css";
  @import "https://use.fontawesome.com/releases/v5.0.6/css/all.css";
</style>

<template>
  <div>
    <!-- Navbar -->
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
      <div class="container">
        <a class="navbar-brand mr-lg-5" href="">
          StarfolkSoftware
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbar_global">
          <div class="navbar-collapse-header">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="#">
                  StarfolkSoftware
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <!-- <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
            <li class="nav-item dropdown">
              <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                <i class="ni ni-ui-04 d-lg-none"></i>
                <span class="nav-link-inner--text">Components</span>
              </a>
              <div class="dropdown-menu dropdown-menu-xl">
                <div class="dropdown-menu-inner">
                  <a href="https://demos.creative-tim.com/argon-design-system/docs/getting-started/overview.html" class="media d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                      <i class="ni ni-spaceship"></i>
                    </div>
                    <div class="media-body ml-3">
                      <h6 class="heading text-primary mb-md-1">Getting started</h6>
                      <p class="description d-none d-md-inline-block mb-0">Learn how to use compiling Scss, change brand colors and more.</p>
                    </div>
                  </a>
                  <a href="https://demos.creative-tim.com/argon-design-system/docs/foundation/colors.html" class="media d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                      <i class="ni ni-palette"></i>
                    </div>
                    <div class="media-body ml-3">
                      <h6 class="heading text-primary mb-md-1">Foundation</h6>
                      <p class="description d-none d-md-inline-block mb-0">Learn more about colors, typography, icons and the grid system we used for .</p>
                    </div>
                  </a>
                  <a href="https://demos.creative-tim.com/argon-design-system/docs/components/alerts.html" class="media d-flex align-items-center">
                    <div class="icon icon-shape bg-gradient-warning rounded-circle text-white">
                      <i class="ni ni-ui-04"></i>
                    </div>
                    <div class="media-body ml-3">
                      <h5 class="heading text-warning mb-md-1">Components</h5>
                      <p class="description d-none d-md-inline-block mb-0">Browse our 50 beautiful handcrafted components offered in the Free version.</p>
                    </div>
                  </a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                <i class="ni ni-collection d-lg-none"></i>
                <span class="nav-link-inner--text">Examples</span>
              </a>
              <div class="dropdown-menu">
                <a href="../examples/landing.html" class="dropdown-item">Landing</a>
                <a href="../examples/profile.html" class="dropdown-item">Profile</a>
                <a href="../examples/login.html" class="dropdown-item">Login</a>
                <a href="../examples/register.html" class="dropdown-item">Register</a>
              </div>
            </li>
          </ul> -->
          <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" :href="platform.facebook_url" target="_blank" data-toggle="tooltip" title="Like us on Facebook">
                <i class="fab fa-facebook-square"></i>
                <span class="nav-link-inner--text d-lg-none">Facebook</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" 
                :href="platform.instagram_url" target="_blank" data-toggle="tooltip" title="Follow us on Instagram">
                <i class="fab fa-instagram"></i>
                <span class="nav-link-inner--text d-lg-none">Instagram</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" :href="platform.twitter_url" target="_blank" data-toggle="tooltip" title="Follow us on Twitter">
                <i class="fab fa-twitter-square"></i>
                <span class="nav-link-inner--text d-lg-none">Twitter</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" :href="platform.linkedin_Url" target="_blank" data-toggle="tooltip" title="Star us on Github">
                <i class="fab fa-linkedin"></i>
                <span class="nav-link-inner--text d-lg-none">Linkedin</span>
              </a>
            </li>
            <!-- <li class="nav-item d-none d-lg-block ml-lg-4">
              <a href="https://www.creative-tim.com/product/argon-design-system-pro?ref=ads-upgrade-pro" target="_blank" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon">
                  <i class="fa fa-shopping-cart"></i>
                </span>
                <span class="nav-link-inner--text">Upgrade to PRO</span>
              </a>
              <a href="https://www.creative-tim.com/product/argon-design-system" target="_blank" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon">
                  <i class="fa fa-cloud-download mr-2"></i>
                </span>
                <span class="nav-link-inner--text">Download</span>
              </a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper">
      <div class="section section-hero section-shaped">
        <div class="shape shape-style-3 shape-default">
          <span class="span-150"></span>
          <span class="span-50"></span>
          <span class="span-50"></span>
          <span class="span-75"></span>
          <span class="span-100"></span>
          <span class="span-75"></span>
          <span class="span-50"></span>
          <span class="span-100"></span>
          <span class="span-50"></span>
          <span class="span-100"></span>
        </div>
        <div class="page-header">
          <div class="container shape-container d-flex align-items-center py-lg">
            <div class="col px-0">
              <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 text-center">
                  <h1 class="text-white display-3">Understand. Challenge. Redefine. Create.</h1>
                  <h2 class="display-4 font-weight-normal text-white">
                    Tell us about your idea, and we’ll offer the most fitting technological solution
                  </h2>
                  <!-- <div class="btn-wrapper mt-4">
                    <a href="https://www.creative-tim.com/product/argon-design-system" class="btn btn-warning btn-icon mt-3 mb-sm-0">
                      <span class="btn-inner--icon"><i class="ni ni-button-play"></i></span>
                      <span class="btn-inner--text">Play more</span>
                    </a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
          <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </div>
      <div class="section features-6">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="info info-horizontal info-hover-primary">
                <div class="description pl-4">
                  <h5 class="title">Cloud Computing</h5>
                  <p>
                    Use cloud computing solutions to create a scalable, 
                    flexible, and connected enterprise environment.
                  </p>
                </div>
              </div>
              <div class="info info-horizontal info-hover-primary mt-5">
                <div class="description pl-4">
                  <h5 class="title">Artificial Intelligence</h5>
                  <p>
                    Custom AI-based solutions like machine and deep 
                    learning will help you automate any operation.
                  </p>
                </div>
              </div>
              <div class="info info-horizontal info-hover-primary mt-5">
                <div class="description pl-4">
                  <h5 class="title">UI/UX Design</h5>
                  <p>
                    Build the product you need on time with an 
                    experienced team that uses a clear and effective design process.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-10 mx-md-auto">
              <img class="ml-lg-5" src="/images/pair_programming.png" width="100%">
            </div>
          </div>
        </div>
      </div>
      <div class="section features-1">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
              <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
              <h3 class="display-3">Services</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-primary">
                  Enterprise Software Development
                </h6>
                <p class="description opacity-8">
                  Create complex enterprise software, ensure reliable 
                  software integration, modernise your legacy system.
                </p>
                <!-- <a href="javascript:;" class="text-primary">More about us
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-success">
                  Mobile App Development
                </h6>
                <p class="description opacity-8">
                  Create an impactful mobile app that fits your 
                  brand and industry within a shorter time frame.
                </p>
                <!-- <a href="javascript:;" class="text-primary">Learn about our products
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-warning">IT Consulting</h6>
                <p class="description opacity-8">
                  Trust our top minds to eliminate workflow pain points, 
                  implement new tech, and consolidate app portfolios.
                </p>
                <!-- <a href="javascript:;" class="text-primary">Check our documentation
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-warning">Dedicated Development Team</h6>
                <p class="description opacity-8">
                  Hire a loyal software development team with niche skills and deep expertise.
                </p>
                <!-- <a href="javascript:;" class="text-primary">Check our documentation
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-primary">UI/UX Design</h6>
                <p class="description opacity-8">
                  Build the product you need on time with an experienced team 
                  that uses a clear and effective design process.
                </p>
                <!-- <a href="javascript:;" class="text-primary">Check our documentation
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="info">
                <h6 class="info-title text-uppercase text-success">QA & Testing</h6>
                <p class="description opacity-8">
                  Turn to our experts to perform comprehensive, 
                  multi-stage testing and auditing of your software.
                </p>
                <!-- <a href="javascript:;" class="text-primary">Check our documentation
                  <i class="ni ni-bold-right text-primary"></i>
                </a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="section features-1">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-8 mx-auto text-center">
              <!-- <span class="badge badge-primary badge-pill mb-3">Insight</span> -->
              <h3 class="display-3">Clients & Partners</h3>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <img src="/images/bob/boblogo.png" alt="" class="img-fluid">
            </div>
            <!-- <div class="col-md-4">
              <img src="/images/dataphyte_logo.jpg" alt="" class="img-fluid">
            </div> -->
          </div>
        </div>
      </div>
      <br /><br />
    </div>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../components/PageHeader";

export default {
  name: "home-index",

  components: {
    PageHeader
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
