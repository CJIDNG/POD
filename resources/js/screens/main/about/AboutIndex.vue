<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <about></about>
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
  name: "contact-index",

  components: {
    About: Statics.About
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
