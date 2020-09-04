<template>
  <div>
    <Home />
    <router-view></router-view>
  </div>
</template>
<script>
import Home from './Home'
export default {
  components: {
    Home
  }
}
</script>