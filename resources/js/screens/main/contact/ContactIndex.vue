<template>
  <div>
    <contact></contact>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageFooter from "../../../components/PageFooter"
import {
  Statics,
} from "../../../statics"

export default {
  name: "contact-index",

  components: {
    Contact: Statics.Contact,
    PageFooter,
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.lang),
    };
  },

  mounted() {
    
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
