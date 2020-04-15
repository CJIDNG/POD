<template>
  <fancy-grid-vue :config="gridConfig"></fancy-grid-vue>
</template>

<script>
import FancyGridVue from 'fancy-grid-vue'

export default {
  name: 'TabularPreview',

  props: {
    data: {
      type: Array,
      required: true
    }
  },

  components: {
    FancyGridVue
  },

  data() {
    return {
      gridConfig: {
        title: 'Vue with FancyGrid',
        theme: 'gray',
        width: '100%',
        height: 400,
        data: this.data,
        resizable: true,
        defaults: {
          type: 'string',
          width: 100,
          sortable: true,
          editable: true,
          resizable: true
        },
        selModel: 'rows',
        trackOver: true,
        // columns: [{
        //   type: 'select'
        // },{
        //   index: 'company',
        //   title: 'Company'
        // },{
        //   index: 'name',
        //   title: 'Name'
        // },{
        //   index: 'surname',
        //   title: 'Sur Name'
        // },{
        //   index: 'age',
        //   title: 'Age',
        //   type: 'number',
        //   width: 80
        // },{
        //   index: 'email',
        //   title: 'Email',
        //   width: 160
        // }]
      }
    }
  }

}
</script>

<style>

</style>
