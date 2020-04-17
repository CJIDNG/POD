<template>
  <fancy-grid-vue 
	  :title="`Sheet - ${activeSheetName}`"
    :theme="'bootstrap'"
    width="100%"
    height="100%"
    :data="data"
    :resizable="true"
    :defaults="defaults"
    :sel-model="'rows'"
    :trackOver="true"
    :columns="columns"
    :paging="true"
    :tbar="[{
      type: 'search',
      width: 350,
      emptyText: 'Search',
      paramsMenu: true,
      paramsText: 'Parameters'
    }]"></fancy-grid-vue>
</template>

<script>
import FancyGridVue from 'fancy-grid-vue'

export default {
  name: 'TabularPreview',

  props: {
    data: {
      type: Array,
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
    FancyGridVue
  },

  data() {
    return {
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
