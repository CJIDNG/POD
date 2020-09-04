<template>
  <div>
    <PageHeader />
    <div class="wrapper">
      <PageBanner />
      <div class="main">
        <div class="section text-center landing-section">
          <div class="container">
            <div class="row d-flex justify-content-center">
              <div class="col-md-8 col-md-offset-2">
                <h2>Let's talk about FAAC</h2>
                <h5>
                  Federal Account Allocation Committee (FAAC) is the distribution of revenue accruing to
                  the Federation Account between the Federal and State Governments and the Local
                  Government Councils in the States.
                </h5>
                <h5>
                  The Federation Account serves as the main account through which the Federal, State, and
                  Local Government fund developmental projects and maintain their respective workforce.
                </h5>
                <h5>
                  The legislation backing the FAAC can be found
                  <a
                    target="_blank"
                    href="http://lawnigeria.com/LawsoftheFederation/ALLOCATION-OF-REVENUE-%28FEDERATION-ACCOUNT,-ETC.%29-ACT.html"
                  >here</a>.
                </h5>
              </div>
            </div>
          </div>
        </div>
        <TableauContainer :url="url" title="Overview of FAAC Disbursement (2007 - 2018)" />
        <PageCTA />
        <PageFooter />
      </div>
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
.section {
  padding: 100px 0;
  position: relative;
  background-color: #f4f3ef;
  background-image: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0) 0%,
    rgba(112, 112, 112, 0) 60%,
    rgba(186, 186, 186, 0.15) 100%
  );

  h2 {
    font-size: 3em;
    color: #66615b;
  }
  h5 {
    font-size: 1.25em;
    font-weight: 400;
    line-height: 1.4em;
    margin-bottom: 15px;
    color: #66615b;
  }
  a {
    color: #68b3c8;
    transition: all 150ms linear;
  }
}
.section-tableau {
  background-color: #172b4d;
  h2 {
    color: #fff;
  }
}
</style>