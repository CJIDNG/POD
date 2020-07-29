<template>
  <div class="shadow">
    <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
      <nav class="navbar navbar-expand-lg">
        <button v-if="isAdminPage" type="button" id="sidebarCollapse" class="btn btn-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px">
            <path fill="#607D8B" d="M6 22H42V26H6zM6 10H42V14H6zM6 34H42V38H6z" />
          </svg>
        </button>
        <button
          v-else
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNavAltMarkup"
          aria-controls="navbarNavAltMarkup"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24px" height="24px">
            <path fill="#607D8B" d="M6 22H42V26H6zM6 10H42V14H6zM6 34H42V38H6z" />
          </svg>
        </button>

        <router-link to="/" class="navbar-brand">FAAC Facts</router-link>

        <ul class="navbar-nav mr-auto flex-row float-right">
          <li class="text-muted font-weight-bold">
            <slot name="status" />
          </li>
        </ul>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav ml-auto">
            <router-link
              to="/"
              class="navbar-brand"
            >{{ CurrentTenant.platform.display_name || CurrentTenant.platform.name || CurrentTenant.hostname.fqdn }}</router-link>
            <router-link
              class="nav-item nav-link"
              to="/faac-facts/13-percent-derivation"
            >13% Derivation</router-link>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="yearlyDisbursementsDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >Yearly Disbursements</a>
              <div class="dropdown-menu" aria-labelledby="yearlyDisbursementsDropdown">
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2007</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2008</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2009</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2010</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2011</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2012</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2013</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2014</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2015</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2016</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2017</router-link>
                <router-link class="dropdown-item" :to="{name: 'products-show'}">2018</router-link>
              </div>
            </li>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import { EventBus } from "../../../../bus";

export default {
  name: "page-header",

  data () {
    return {
      user: CurrentTenant.user,
      avatar: this.$root.avatar,
      token: this.getToken(),
    };
  },

  mounted () {
    $("#sidebarCollapse").on("click", function () {
      EventBus.$emit("sidebar-collapse-clicked");
    });
  },

  watch: {
    "$root.avatar": function (url) {
      this.avatar = url;
    }
  },

  methods: {
    sessionLogout () {
      this.logout();
    }
  }
};
</script>
