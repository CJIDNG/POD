<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">


        <div class="container marketing">

          <div class="row featurette" style="margin-top: 50px">
            <div class="col-md-5 order-md-2 my-auto">
              <h2 class="featurette-heading">
                PHC Tracker is a
                <span class="text-muted">review website for primary health care</span></h2>
              <p class="lead">
                Tell us about your experience in the primary health care facilities around the 
                country.
              </p>
              <p class="lead">
                <i class="text-small">An initiative of PTCIJ</i>
              </p>
            </div>
            <div class="col-md-7 order-md-1">
              <img :src="medicine_svg" alt="" class="img-fluid">
            </div>
          </div>

          <div class="mt-5 mb-5">
            <iframe width="100%" height="600" src="//jsfiddle.net/frknasir/ckrovnpb/7/embedded/result/dark/" allowfullscreen="allowfullscreen" allowpaymentrequest frameborder="0"></iframe>
          </div>

        </div><!-- /.container -->

      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import PageHeader from "../../components/PageHeader";
import MedicineSVG from "../../../../public/assets/svg/undraw_medicine_b1ol.svg"
import CollectingSVG from "../../../../public/assets/svg/undraw_collecting_fjjl.svg"
import SortingSVG from "../../../../public/assets/svg/undraw_sorting_thoughts_6d48.svg"
import ContentCreator from "../../../../public/assets/svg/undraw_content_creator_xeju.svg"

export default {
  name: "contact-index",

  components: {
    PageHeader
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      medicine_svg: MedicineSVG,
      collecting_svg: CollectingSVG,
      sorting_svg: SortingSVG,
      content_svg: ContentCreator
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
