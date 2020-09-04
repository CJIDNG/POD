<template>
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
</template>

<script>
export default {
  name: 'faac-page-footer'
}
</script>
<style lang="scss" scoped>
</style>