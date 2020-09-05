<template>
  <div>
    <PageHeader />
    <div class="wrapper">
      <PageBanner />
      <div>
        <router-view></router-view>
      </div>
      <PageCTA />
      <PageFooter />
    </div>
  </div>
</template>

<script>
import NProgress from "nprogress"
import PageHeader from './components/PageHeader'
import PageFooter from './components/PageFooter'
import PageCTA from './components/PageCTA'
import PageBanner from './components/PageBanner'
import TableauContainer from './components/TableauContainer'
export default {
  name: 'faac-facts',
  data () {
    return {
      url: "https://public.tableau.com/views/2007-2008FAACAllocation/Dashboard1?:embed=y&:showVizHome=no&:host_url=https%3A%2F%2Fpublic.tableau.com%2F&:embed_code_version=3&:tabs=no&:toolbar=yes&:animate_transition=yes&:display_static_image=no&:display_spinner=no&:display_overlay=yes&:display_count=yes&publish=yes&:loadOrderID=0"
    }
  },
  components: {
    PageFooter,
    PageCTA,
    PageBanner,
    PageHeader,
    TableauContainer
  }
  ,
  mounted () {
    NProgress.done()
  }
}
</script>
<style lang="scss" scoped>
.wrapper {
  font-size: 16px;
  font-family: "Montserrat", "Helvetica", Arial, sans-serif;
}
</style>