<template>
  <div class="landing-header">
    <div class="container">
      <div class="motto">
        <h1 class="title-uppercase mt-0">FAAC Figures</h1>
        <h3>
          Demystifying the figures behind
          <br />monthly allocations!
        </h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'faac-page-banner',
}
</script>
<style lang="scss" scoped>
.landing-header {
  background-size: cover;
  min-height: 570px;
  background-image: url("/images/narep/paper_img/nigeria_FAAC.png");

  .motto {
    padding-top: 8%;
    text-align: left;
    z-index: 3;
    h1 {
      text-transform: uppercase;
      color: #66615b;
      font-size: 4.5em;
    }
    h3 {
      color: #66615b;
    }
  }
}
</style>