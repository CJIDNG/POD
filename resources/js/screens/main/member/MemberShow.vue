<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main class="py-4">
      {{member}}
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../../components/PageHeader";
import PageFooter from "../../../components/PageFooter"

export default {
  name: "member-show",

  components: {
    PageHeader,
    PageFooter
  },

  data() {
    return {
      member: {},
      trans: JSON.parse(CurrentTenant.translations),
      id: this.$route.params.id
    };
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/members/" + vm.id)
        .then(response => {
          vm.member = response.data

          NProgress.done();
        })
        .catch(error => {
          vm.$router.push({ name: "members-main" });
        });
    });
  },

  methods: {
    
  }
};
</script>

<style scoped></style>
