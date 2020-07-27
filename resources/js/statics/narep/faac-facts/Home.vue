<template>
  <div>
    <div class="wrapper">
      <div class="landing-header" :style="{ backgroundImage: `url(${backgroundUrl})` }">
        <div class="container">
          <div class="motto">
            <h1 class="title-uppercase">FAAC Figures</h1>
            <h3>
              Demystifying the figures behind
              <br />monthly allocations!
            </h3>
          </div>
        </div>
      </div>
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
                    href="http://lawnigeria.com/LawsoftheFederation/ALLOCATION-OF-REVENUE-%28FEDERATION-ACCOUNT,-ETC.%29-ACT.html"
                  >here</a>.
                </h5>
              </div>
            </div>
          </div>
        </div>
        <div class="section section-dark text-center landing-section">
          <div class="container">
            <h2>Overview of FAAC Disbursement (2007 - 2018)</h2>
            <TableauHolder />
          </div>
        </div>
        <div class="section landing-section">
          <div class="container">
            <div class="row d-flex justify-content-center">
              <div class="col-md-8 col-md-offset-2">
                <h2 class="text-center">Make a Request</h2>
                <br />
                <h5>
                  If you can't find what you need, please reach out to
                  <a
                    href="mailto:akintunde@ptcij.org?subject=I NEED HELP WITH FAAC DATA"
                  >
                    Akintunde
                    Babatunde.
                  </a>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer-demo section-dark">
      <div class="container d-flex justify-content-center">
        <nav class="pull-left">
          <ul>
            <li>
              <a href="https://ptcij.org">PTCIJ</a>
            </li>

            <li>
              <a
                href="https://www.premiumtimesng.com/tag/federation-accounts-allocation-committee"
              >FAAC Stories</a>
            </li>
            <li>
              <router-link
                to="/"
              >{{ CurrentTenant.platform.display_name || CurrentTenant.platform.name || CurrentTenant.hostname.fqdn }}</router-link>
            </li>
          </ul>
        </nav>
        <div class="copyright pull-right">&copy; 2019, made for you by PTCIJ</div>
      </div>
    </footer>
  </div>
</template>
<script>
import TableauHolder from './TableauHolder'
import backgroundUrl from '../../../../../public/images/narep/paper_img/nigeria_FAAC.png'
export default {
  name: 'faac-facts',
  data () {
    return {
      backgroundUrl
    }
  },
  components: {
    TableauHolder
  }
}
</script>
<style lang="scss" scoped>
@import "../../../../../resources/sass/ct-paper.scss";
@import "../../../../../resources/sass/examples.scss";
@import "../../../../../resources/sass/demo.scss";
</style>