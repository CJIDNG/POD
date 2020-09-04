<template>
  <footer class="footer-demo">
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
.footer-demo {
  background-attachment: fixed;
  position: relative;
  line-height: 20px;
  background-color: #172b4d;
  color: #fff;
}
.footer-demo nav > ul {
  list-style: none;
  margin: 0;
  padding: 0;
  font-weight: normal;
}
.footer-demo nav > ul > li {
  display: inline-block;
  padding: 10px 15px;
  margin: 15px 3px;
  line-height: 20px;
  text-align: center;
}
.footer-demo nav > ul > li:first-child {
  margin: 0;
  padding: 0;
}
.footer-demo nav > ul a:not(.btn) {
  color: #777777;
  display: block;
  margin-bottom: 3px;
}
.footer-demo nav > ul a:not(.btn):hover,
.footer nav > ul a:not(.btn):focus {
  color: #e3e3e3;
}
.footer-demo .copyright {
  color: #777777;
  padding: 10px 15px;
  font-size: 14px;
  margin: 15px 3px;
  line-height: 20px;
  text-align: center;
}
.footer-demo .heart {
  color: #eb5e28;
}
</style>