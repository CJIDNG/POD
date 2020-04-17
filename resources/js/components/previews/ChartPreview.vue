<template>
  <highcharts :options="chartOptions"></highcharts>
</template>

<script>
import {Chart} from 'highcharts-vue'

export default {
  name: 'ChartPreview',

  props: {
    chartOptions: {
      type: Object,
      required: true
    },
    resource: {
      type: Object,
      required: true,
    },
    activeSheetName: {
      type: String,
      required: true
    }
  },

  components: {
    highcharts: Chart
  },

  data() {
    return {
      title: {
        text: 'Comparing crony capitalism around the world',
        style: {
          'text-align': 'center'
        }
      },
      defaults: {
        type: 'string',
        width: 100,
        sortable: true,
        editable: false,
        resizable: true
      }
    }
  },

  computed: {
    columns() {
      let header = this.data.shift()

      return header.map((value, index) => {
        return {
          index: index,
          title: value
        }
      })
    }
  },

  watch: {
    
  }

}
</script>

<style>

</style>
