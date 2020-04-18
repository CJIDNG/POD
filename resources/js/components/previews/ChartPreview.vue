<template>
  <div class="row">
    <div class="col-12 col-md-8">
      <highcharts :options="chartOptions"></highcharts>
    </div>
    <div class="col-12 col-md-4">
      <form>
        <div class="form-group">
          <label for="chart-type">{{ $parent.trans.app.chart_type }}</label>
          <select class="form-control" id="chart-type">
            <option 
              v-for="(chart,index) in availableCharts" 
              :key="index">
              {{ chart }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="x_axis">{{ $parent.trans.app.group_column }}</label>
          <select class="form-control" id="x_axis">
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
        <!-- <div class="form-group">
          <label for="x_axis_type">{{ $parent.trans.app.axis_type }}</label>
          <select class="form-control" id="x_axis_type">
            <option value="categories" selected>Categories</option>
            <option value="linear">Linear</option>
            <option value="logarithmic">Logarithmic</option>
            <option value="datetime">Datetime</option>
          </select>
        </div> -->
        <div class="form-group">
          <label for="axes">{{ $parent.trans.app.axes }}</label>
          <select multiple class="form-control" id="axes">
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Chart} from 'highcharts-vue'

export default {
  name: 'ChartPreview',

  props: {
    isReady: {
      type: Boolean,
      required: true
    },
    data: {
      type: Array,
      required: true
    },
    columns: {
      type: Array,
      required: true  
    },
    resource: {
      type: Object,
      required: true
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
      availableCharts: ['line', 'spline', 'area', 'areaspline', 'column', 'bar', 'pie', 'scatter', 'gauge', 'arearange', 'areasplinerange', 'columnrange'],
      chart: {
        type: '',
        height: 600
      },
      title: '',
      xAxis: [{
        title: {
          text: ''
        },
        categories: [],
      }],
      yAxis: [{
        title: {
          text: ''
        },
        // opposite: true
      }],
      series: [{
        yAxis: 0,
        name: '',
        data: [] 
      }],
      // chartOptions: {
      //   chart: {
      //     type: ''
      //   },
      //   title: {
      //     text: this.resource.title
      //   },
      //   xAxis: [{ //--- Primary yAxis
      //     title: {
      //       text: 'Cities'
      //     },
      //     categories: ['Kano', 'Kaduna', 'Zaria', 'Abuja', 'Ibadan', 'Jalingo', 'Taraba', 'Kontagora', 'Niger', 'Benue', 'Osun', 'Ogun']
      //   }],
      //   yAxis: [{ //--- Primary yAxis
      //     title: {
      //       text: 'Temperature'
      //     }
      //   }, { //--- Secondary yAxis
      //     title: {
      //       text: 'Rainfall'
      //     },
      //     opposite: true
      //   }],
      //   series: [{
      //     name: 'Temperature',
      //     yAxis: 0,
      //     data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
      //   },{
      //     name: 'Rainfall',
      //     yAxis: 1,
      //     data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
      //   }]
      // },
    }
  },

  computed: {

  }

}
</script>

<style>

</style>
