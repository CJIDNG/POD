<template>
  <div>
    <PageHeader />
    <div class="wrapper">
      <PageBanner />
      <div class="section section-dark text-center landing-section">
        <div class="container">
          <h2>2016 Disbursement</h2>
          <br />
          <TableauHolder :url="url" />
        </div>
      </div>
      <PageCTA />
      <PageFooter />
    </div>
  </div>
</template>
<script>
import NProgress from "nprogress"
import TableauHolder from '../components/TableauHolder'
import PageHeader from '../components/PageHeader'
import PageFooter from '../components/PageFooter'
import PageCTA from '../components/PageCTA'
import PageBanner from '../components/PageBanner'
export default {
  name: 'yearly-disbursement-2016',
  data () {
    return {
      url: "https://public.tableau.com/views/2007FAACDisbursement/Dashboard1?:embed=y&:showVizHome=no&:host_url=https%3A%2F%2Fpublic.tableau.com%2F&:embed_code_version=3&:tabs=no&:toolbar=yes&:animate_transition=yes&:display_static_image=no&:display_spinner=no&:display_overlay=yes&:display_count=yes&publish=yes&:loadOrderID=0"
    }
  },
  components: {
    TableauHolder,
    PageFooter,
    PageCTA,
    PageBanner,
    PageHeader
  },
  mounted () {
    NProgress.done()
  }
}
</script>
<style lang="scss" scoped>
@import "../../../../../../resources/sass/ct-paper.scss";
@import "../../../../../../resources/sass/examples.scss";
</style>