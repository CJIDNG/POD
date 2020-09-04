<template>
  <div>
    <PageHeader />
    <div class="wrapper">
      <PageBanner />
      <div class="section-tableau text-center landing-section">
        <div class="container">
          <h2>What is 13% Derivation?</h2>
          <br />
          <p>
            According to
            <a
              target="_blank"
              href="http://petrobarometer.thecable.ng/2018/07/27/buhari-promises-to-look-into-13-percent-derivation-for-oil-states/"
            >The Cable's petrobarometer</a>, it is the fund set aside to assist oil-producing communities tackle infrastructural decay and degradation. The 1995 constitutional conference recommended that in sharing the federation account revenue, 13% should be set aside to assist the development of oil-producing communities.
          </p>
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
import TableauHolder from './components/TableauHolder'
import PageHeader from './components/PageHeader'
import PageFooter from './components/PageFooter'
import PageCTA from './components/PageCTA'
import PageBanner from './components/PageBanner'
export default {
  name: 'faac-facts',
  data () {
    return {
      url: "https://public.tableau.com/views/13Derivation/Dashboard1?:embed=y&:showVizHome=no&:host_url=https%3A%2F%2Fpublic.tableau.com%2F&:embed_code_version=3&:tabs=no&:toolbar=yes&:animate_transition=yes&:display_static_image=no&:display_spinner=no&:display_overlay=yes&:display_count=yes&publish=yes&:loadOrderID=0"
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
.section-tableau {
  background-color: #172b4d;
  padding: 100px 0;
  h2 {
    color: #fff;
    font-size: 3em;
  }
  p {
    color: #fff;
  }
  a {
    color: #68b3c8;
  }
}
</style>