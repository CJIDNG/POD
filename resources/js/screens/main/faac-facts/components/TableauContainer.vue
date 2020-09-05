<template>
  <div class="section section-tableau text-center landing-section">
    <div class="container">
      <h2>{{title}}</h2>
      <br />
      <TableauHolder :url="url" />
    </div>
  </div>
</template>
<script>
import TableauHolder from './TableauHolder'
export default {
  name: 'TableauContainer',
  TableauHolder,
  components: {
    TableauHolder
  },
  props: {
    url: {
      type: String,
      required: true
    },
    title: {
      type: String
    },
    subtitle: {
      type: String
    },
    link: {
      type: String
    }
  },
}

</script>
<style lang="scss" scoped>
.section-tableau {
  background-color: #172b4d;
  padding: 100px 0;
  h2 {
    color: #fff;
    font-size: 3em;
  }
}
</style>