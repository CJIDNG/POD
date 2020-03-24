<template>
  <div>
    <page-header></page-header>

    <main class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">


        <div class="container marketing">
          <div class="row featurette" style="margin-top: 100px">
            <div class="col-md-5 order-md-2">
              <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
              <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-7 order-md-1">
              <img :src="medicine_svg" alt="" class="img-fluid">
            </div>
          </div>

          <!-- Three columns of text below the carousel -->
          <div class="row" style="margin-top: 200px">
            <div class="col-lg-4">
              <img :src="collecting_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Collect</h2>
              <p>
                Donec sed odio dui. Etiam porta sem malesuada 
                magna mollis euismod. Nullam id dolor id nibh 
                ultricies vehicula ut id elit. Morbi leo risus, 
                porta ac consectetur ac, vestibulum at eros. 
                Praesent commodo cursus magna.
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img :src="sorting_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Index</h2>
              <p>
                Duis mollis, est non commodo luctus, nisi 
                erat porttitor ligula, eget lacinia odio sem 
                nec elit. Cras mattis consectetur purus sit 
                amet fermentum. Fusce dapibus, tellus ac cursus 
                commodo, tortor mauris condimentum nibh.
              </p>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
              <img :src="content_svg" alt="" class="img-fluid img-thumbnail">
              <h2>Publish</h2>
              <p>
                Donec sed odio dui. Cras justo odio, dapibus 
                ac facilisis in, egestas eget quam. Vestibulum 
                id ligula porta felis euismod semper. Fusce dapibus, 
                tellus ac cursus commodo, tortor mauris 
                condimentum nibh, ut fermentum massa justo 
                sit amet risus.
              </p>
            </div><!-- /.col-lg-4 -->
          </div><!-- /.row -->


          <!-- START THE FEATURETTES -->

          

          <div class="row featurette" style="margin-top: 200px">
            <div class="col-md-7">
              <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
              <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-5">
              <img :src="medicine_svg" alt="" class="img-fluid img-thumbnail">
            </div>
          </div>

          

          <div class="row featurette" style="margin-top: 200px">
            <div class="col-md-7 order-md-2">
              <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
              <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-5 order-md-1">
              <img :src="medicine_svg" alt="" class="img-fluid img-thumbnail">
            </div>
          </div>

          

          <!-- <div class="row featurette" style="margin-top: 200px">
            <div class="col-md-7">
              <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
              <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-5">
              <img :src="medicine_svg" alt="" class="img-fluid img-thumbnail">
            </div>
          </div> -->

          <!-- /END THE FEATURETTES -->

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
      trans: JSON.parse(CurrentTenant.lang),
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
