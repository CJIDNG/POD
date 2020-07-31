<template>
  <div id="vizContainer"></div>
</template>

<script>
export default {
  name: 'TableauHolder',
  props: {
    url: {
      type: String,
      required: true
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
    window.addEventListener('load', () => {
      this.initViz()
    })
  }
}
</script>


<style scoped>
</style>