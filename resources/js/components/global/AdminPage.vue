<template>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar" class="shadow-sm text-white border border-right">
      <div class="sidebar-header border border-bottom">
        <h3>{{ trans.app.admin }}</h3>
      </div>

      <ul class="list-unstyled components">
        <li :class="{'active': /admin\/stats/.test($route.path)}">
          <router-link to="/admin/stats">
            <span>{{ trans.app.analytics }}</span>
          </router-link>
        </li>
        <li class="dropdown" :class="{'active': /admin\/partners/.test($route.path) || 
          /admin\/platforms/.test($route.path) || 
          /admin\/designations/.test($route.path) || 
          /admin\/members/.test($route.path) ||
          /admin\/services/.test($route.path)}">
          <a
            href="#platformSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="dropdown-toggle"
          >
            <span>{{ trans.app.platforms }}</span>
          </a>
          <ul class="collapse list-unstyled" id="platformSubmenu">
            <li>
              <router-link :to="`/admin/platforms/${CurrentTenant.platform.id}/edit`">
                <span>{{ trans.app.platforms }}</span>
              </router-link>
            </li>
            <li v-if="hasSubapp('partners')">
              <router-link to="/admin/partners">
                <span>{{ trans.app.partners }}</span>
              </router-link>
            </li>
            <li v-if="hasSubapp('members')">
              <router-link to="/admin/designations">
                <span>{{ trans.app.designations }}</span>
              </router-link>
            </li>
            <li v-if="hasSubapp('members')">
              <router-link to="/admin/members">
                <span>{{ trans.app.members }}</span>
              </router-link>
            </li>
            <li v-if="hasSubapp('services')">
              <router-link to="/admin/services">
                <span>{{ trans.app.services }}</span>
              </router-link>
            </li>
            <li v-if="hasSubapp('products')">
              <router-link to="/admin/products">
                <span>{{ trans.app.products }}</span>
              </router-link>
            </li>
          </ul>
        </li>
        <li class="dropdown" v-if="hasSubapp('blog')" :class="{'active': /admin\/posts/.test($route.path)}">
          <a
            href="#postSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="dropdown-toggle"
          >
            <span>{{ trans.app.posts_simple }}</span>
          </a>
          <ul class="collapse list-unstyled" id="postSubmenu">
            <li>
              <router-link to="/admin/posts">
                <span>{{ trans.app.posts_simple }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/posts/tags">
                <span>{{ trans.app.tags }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/posts/topics">
                <span>{{ trans.app.topics }}</span>
              </router-link>
            </li>
          </ul>
        </li>
        <li class="dropdown" v-if="hasSubapp('data')" :class="{'active': /admin\/data/.test($route.path)}">
          <a
            href="#dataSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="dropdown-toggle"
          >
            <span>{{ trans.app.data }}</span>
          </a>
          <ul class="collapse list-unstyled" id="dataSubmenu">
            <li>
              <router-link to="/admin/data/topics">
                <span>{{ trans.app.topics }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/data/tags">
                <span>{{ trans.app.tags }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/data/formats">
                <span>{{ trans.app.format }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/data/licenses">
                <span>{{ trans.app.license }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/data/datasets">
                <span>{{ trans.app.dataset }}</span>
              </router-link>
            </li>
          </ul>
        </li>
        <li
          v-if="hasSubapp('tracker')"
          class="dropdown" 
          :class="{'active': /admin\/trackers/.test($route.path) || /admin\/trackerItems/.test($route.path)}">
          <a
            href="#trackersSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="dropdown-toggle"
          >
            <span>{{ trans.app.trackers }}</span>
          </a>
          <ul class="collapse list-unstyled" id="trackersSubmenu">
            <li>
              <router-link to="/admin/trackers">
                <span>{{ trans.app.trackers }}</span>
              </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'trackerItems-select' }">
                <span>{{ trans.app.tracker_items }}</span>
              </router-link>
            </li>
          </ul>
        </li>
        <li class="dropdown" 
          :class="{'active': /admin\/users/.test($route.path) || /admin\/roles/.test($route.path)}">
          <a
            href="#usersSubmenu"
            data-toggle="collapse"
            aria-expanded="false"
            class="dropdown-toggle"
          >
            <span>{{ trans.app.users }}</span>
          </a>
          <ul class="collapse list-unstyled" id="usersSubmenu">
            <li>
              <router-link to="/admin/roles">
                <span>{{ trans.app.roles }}</span>
              </router-link>
            </li>
            <li>
              <router-link to="/admin/users">
                <span>{{ trans.app.users }}</span>
              </router-link>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Main -->
    <div style="width: 100%">
      <slot name="main" />
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../bus";
var $ = require("jquery");
require("jquery-mousewheel")($);
require("malihu-custom-scrollbar-plugin")($);

export default {
  name: "page-side-bar",

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  created() {
    if (this.isUser) {
      this.$router.push({ name: "home" });
    }
  },

  mounted() {
    $("#sidebar").mCustomScrollbar({
      theme: "minimal"
    });

    EventBus.$on("sidebar-collapse-clicked", () => {
      // open or close navbar
      $("#sidebar").toggleClass("active");
      // close dropdowns
      $(".collapse.in").toggleClass("in");
      // and also adjust aria-expanded attributes we use for the open/closed arrows
      // in our CSS
      $("a[aria-expanded=true]").attr("aria-expanded", "false");
    });
  },

  beforeDestroy() {
    EventBus.$off("sidebar-collapse-clicked");
  },

  watch: {},

  methods: {}
};
</script>

<style scoped>
.wrapper {
  display: flex;
  align-items: stretch;
}

#sidebar {
  min-width: 250px;
  max-width: 250px;
  min-height: 100vh;
  transition: all 0.3s;
}

#sidebar.active {
  margin-left: -250px;
}

#sidebar.active {
  margin-left: -250px;
}

a[data-toggle="collapse"] {
  position: relative;
}

.dropdown-toggle::after {
  display: block;
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}

@media (max-width: 768px) {
  #sidebar {
    margin-left: -250px;
  }
  #sidebar.active {
    margin-left: 0;
  }
}

/*
    ADDITIONAL DEMO STYLE, NOT IMPORTANT TO MAKE THINGS WORK BUT TO MAKE IT A BIT NICER :)
  */
@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

a,
a:hover,
a:focus {
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}

#sidebar .sidebar-header {
  /* padding: 20px; */
  color: #444;
}

#sidebar ul.components {
  padding: 20px 0;
  border-bottom: 1px solid #fff;
}

#sidebar ul p {
  padding: 10px;
}

#sidebar ul li a {
  padding: 10px;
  font-size: 1.1em;
  display: block;
  color: #444;
}

#sidebar ul li a:hover {
  color: #444;
  background: #fff;
}

#sidebar ul li.active > a,
a[aria-expanded="true"] {
  border: 1px solid #777;
  border-radius: 12px;
}

ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: #fff;
}

.dropdown ul li a:hover {
  color: #444;
  background: #fff;
}
</style>
