<template>
  <div id="vizContainer"></div>
</template>

<script>
export default {
  name: 'TableauHolder',
  data () {
    return {
      viz: null
    }
  },
  props: {
    url: {
      type: String,
      required: true
    }
  },
  watch: {
    url: function (val) {
      this.viz = null
      this.initViz()
    }
  },
  methods: {
    initViz () {
      const containerDiv = document.getElementById("vizContainer")
      let url = this.url
      let options = {
        hideTabs: true,
        onFirstInteractive: () => {
        }
      }

      this.viz = new window.tableau.Viz(containerDiv, url, options)
    }
  },
  mounted () {
    this.initViz()
  }
}
</script>


<style scoped>
</style>