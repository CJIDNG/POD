<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <home></home>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import {
  Statics,
} from "../../../statics"

export default {
  name: "home-index",

  components: {
    Home: Statics.Home
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  mounted() {
    
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
