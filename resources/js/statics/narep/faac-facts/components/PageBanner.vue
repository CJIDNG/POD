<template>
  <div class="landing-header" :style="{ backgroundImage: `url(${backgroundUrl})` }">
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
import backgroundUrl from '../../../../../../public/images/narep/paper_img/nigeria_FAAC.png'
export default {
  name: 'faac-page-banner',
  data () {
    return {
      backgroundUrl
    }
  },
}
</script>
<style lang="scss" scoped>
@import "../../../../../../resources/sass/ct-paper.scss";
@import "../../../../../../resources/sass/examples.scss";
</style>