<template>
  <nav class="navbar navbar-horizontal navbar-expand-lg navbar-light">
    <div class="container">
      <router-link to="/" class="navbar-brand mr-lg-3">
        {{ platform.name || platform.display_name }}
      </router-link>
      <div class="navbar-collapse collapse" id="navbar-default-primary">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <router-link to="/">
              {{ platform.name || platform.display_name }}
            </router-link>
            </div>
            <div class="col-6 collapse-close">
              <i
                class="fas fa-times"
                data-toggle="collapse"
                role="button"
                data-target="#navbar-default-primary"
                aria-controls="navbar-default-primary"
                aria-expanded="false"
                aria-label="Toggle navigation"
              ></i>
            </div>
          </div>
        </div>
        <ul v-if="!isAdminPage" class="navbar-nav navbar-nav-hover align-items-lg-center">
          <li class="nav-item" v-if="hasSubapp('blog')">
            <router-link class="nav-link" to="/blog">
              {{
                /spoor/.test(this.CurrentTenant.platform.name) ?
                'Reasearch' : trans.app.blog
              }}
            </router-link>
          </li>
          <li v-if="hasSubapp('tracker')" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="trackerDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >{{ trans.app.trackers }}</a>
            <div class="dropdown-menu" aria-labelledby="trackerDropdown">
              <router-link
                v-for="(tracker, index) in trackers"
                :key="index"
                class="dropdown-item"
                :to="{name: 'trackerItems-main', params: { trackerId: tracker.id }}"
              >{{ tracker.name }}</router-link>
            </div>
          </li>
          <li class="nav-item" v-if="hasSubapp('data') && !/ptdata/.test(this.CurrentTenant.platform.name)">
            <router-link class="nav-link" to="/data">{{ trans.app.data }}</router-link>
          </li>
          <li class="nav-item" v-if="/ptdata/.test(this.CurrentTenant.platform.name)">
            <router-link class="nav-link" to="/">{{ trans.app.home }}</router-link>
          </li>
          <li class="nav-item" v-if="/ptdata/.test(this.CurrentTenant.platform.name)">
            <router-link class="nav-link" to="/data">{{ trans.app.datasets }}</router-link>
          </li>
          <li class="nav-item" v-if="/narepng/.test(this.CurrentTenant.platform.name)">
            <router-link class="nav-link" to="/faac-facts">FAAC Facts</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/about">{{ trans.app.about }}</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/contact">{{ trans.app.contact }}</router-link>
          </li>
          <li v-if="CurrentTenant.user && !isUser" class="nav-item d-block d-md-none">
            <router-link class="nav-link" to="/admin">{{ trans.app.admin }}</router-link>
          </li>
          <li v-if="CurrentTenant.user" class="nav-item d-block d-md-none">
            <router-link class="nav-link" :to="`${isAdminPage ?'/admin' : ''}/settings`">{{ trans.app.settings }}</router-link>
          </li>
          <li v-if="CurrentTenant.user" class="nav-item d-block d-md-none">
            <a href="#!" class="nav-link" @click.prevent="sessionLogout">
              {{ trans.app.sign_out }}
            </a>
          </li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        <div v-if="CurrentTenant.user" class="my-auto ml-auto d-flex align-items-end align-middle">
          <slot name="action" />
        </div>
        <ul v-if="CurrentTenant.user && !isAdminPage" class="navbar-nav align-items-center mr-auto mr-md-0 d-none d-md-block">
          <li class="nav-item dropdown">
            <a 
              class="nav-link pr-0" 
              href="#" 
              role="button" 
              data-toggle="dropdown" 
              aria-haspopup="true" 
              aria-expanded="true">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img
                    :src="avatar"
                    :alt="user.name"
                  />
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">
                    {{ user.name }}
                  </span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-left">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">{{ trans.app.welcome }}</h6>
              </div>
              <div v-if="!isUser" class="dropdown-divider"></div>
              <router-link v-if="!isUser" to="/admin" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>{{ trans.app.admin }}</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <router-link :to="`${isAdminPage ?'/admin' : ''}/settings`" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>{{ trans.app.settings }}</span>
              </router-link>
              <div class="dropdown-divider"></div>
              <a href="#!" class="dropdown-item" @click.prevent="sessionLogout">
                <i class="ni ni-user-run"></i> 
                <span>{{ trans.app.sign_out }}</span>
              </a>
            </div>
          </li>
        </ul>

        <a 
          v-else-if="!isAdminPage"
          href="/login"
          class="btn btn-md btn-secondary animate-up-2">
          <i class="fas fa-user mr-2"></i> 
          {{ trans.app.login }}
        </a>

        <button
          class="navbar-toggler ml-2"
          type="button"
          data-toggle="collapse"
          data-target="#navbar-default-primary"
          aria-controls="navbar-default-primary"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
import $ from "jquery";
import { EventBus } from "../../bus";

export default {
  name: "page-header",

  data () {
    return {
      user: CurrentTenant.user,
      platform: CurrentTenant.platform,
      avatar: this.$root.avatar,
      token: this.getToken(),
      trans: JSON.parse(CurrentTenant.translations),
      trackers: CurrentTenant.trackers || [],
      products: CurrentTenant.products || [],
    };
  },

  mounted () {
    
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
