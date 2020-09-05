<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-default">
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

    <router-link to="/faac-facts" class="navbar-brand">FAAC Facts</router-link>

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
        <router-link class="nav-item nav-link" to="/faac-facts/13-percent-derivation">13% Derivation</router-link>
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
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2007">2007</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2008">2008</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2009">2009</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2010">2010</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2011">2011</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2012">2012</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2013">2013</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2014">2014</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2015">2015</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2016">2016</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2017">2017</router-link>
            <router-link class="dropdown-item" to="/faac-facts/yearly-disbursement/2018">2018</router-link>
          </div>
        </li>
         
      </div>
    </div>
  </nav>
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

<style lang="scss" scoped>
</style>