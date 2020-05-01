<template>
  
</template>

<script>
export default {
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      allPlatforms: CurrentTenant.allPlatforms
    };
  },
}
</script>

<style>

</style>