<template>
  <div class="landing-section">
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
</template>

<script>
export default {
  name: 'faac-page-cta'
}
</script>
<style lang="scss" scoped>
.landing-section {
  color: #66615b;
  padding: 100px 0;
  position: relative;
  background-color: #f4f3ef;
  background-image: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0) 0%,
    rgba(112, 112, 112, 0) 60%,
    rgba(186, 186, 186, 0.15) 100%
  );
  a {
    color: #68b3c8;
    -webkit-transition: all 150ms linear;
    -moz-transition: all 150ms linear;
    -o-transition: all 150ms linear;
    -ms-transition: all 150ms linear;
    transition: all 150ms linear;
  }
  h2,
  .h2 {
    font-size: 3em;
  }
  h5 {
    font-size: 1.25em;
    font-weight: 400;
    line-height: 1.4em;
    margin-bottom: 15px;
  }
}
</style>