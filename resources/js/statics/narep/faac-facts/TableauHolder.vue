<template>
  <div id="vizContainer"></div>
</template>

<script>
export default {
  name: 'TableauHolder',
  methods: {
    initViz () {
      const containerDiv = document.getElementById("vizContainer")

      let url = "https://public.tableau.com/views/2007-2008FAACAllocation/Dashboard1?:embed=y&:showVizHome=no&:host_url=https%3A%2F%2Fpublic.tableau.com%2F&:embed_code_version=3&:tabs=no&:toolbar=yes&:animate_transition=yes&:display_static_image=no&:display_spinner=no&:display_overlay=yes&:display_count=yes&publish=yes&:loadOrderID=0"
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