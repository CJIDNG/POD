<template>
  <div class="row">
    <div 
      class="col-lg-4"
      v-for="(feature, index) in features" 
      :key="index">
      <img 
        v-if="feature.thumbnail"
        height="140" 
        width="140" 
        :src="feature.thumbnail" 
        class="bd-placeholder-img rounded-circle rounded" 
        alt="...">
      <svg 
        v-else
        class="bd-placeholder-img rounded-circle" 
        width="140" 
        height="140" 
        xmlns="http://www.w3.org/2000/svg" 
        preserveAspectRatio="xMidYMid slice" 
        focusable="false" 
        role="img" 
        aria-label="Placeholder: 140x140">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"/>
        <text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
      </svg>
      <h2>{{ feature.title }}</h2>
      <p v-html="feature.description"></p>
    </div><!-- /.col-lg-4 -->
  </div><!-- /.row -->
</template>

<script>
export default {
  props: {
    features: {
      type: Array,
      required: true
    }
  }
}
</script>

<style>

</style>