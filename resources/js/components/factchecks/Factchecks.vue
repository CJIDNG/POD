<template>
  <table class="table table-default table-striped mt-5 mb-5">
    <thead>
      <tr>
        <th scope="col-5">{{ trans.app.claims }}</th>
        <th scope="col-5">{{ trans.app.conclusions }}</th>
        <th scope="col-2" v-if="editable">
          <button @click="addFactcheck()" class="btn btn-info btn-sm">
            {{ trans.app.add }}
          </button>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(factcheck, index) in factchecks" :key="index">
        <th v-if="!editable">{{ factcheck.claim }}</th>
        <th v-if="!editable">{{ factcheck.conclusion }}</th>
        <th v-if="editable">
          <textarea 
            v-model="factcheck.claim"
            class="form-control" 
            :placeholder="trans.app.write_claim" 
            required></textarea>
        </th>
        <th v-if="editable">
          <textarea 
            v-model="factcheck.conclusion"
            class="form-control" 
            :placeholder="trans.app.write_conclusion" 
            required></textarea>
        </th>
        <th v-if="editable">
          <button @click="removeFactcheck(index)" class="btn btn-info btn-danger btn-sm">
            {{ trans.app.delete }}
          </button>
        </th>
      </tr>
    </tbody>
    <tfoot v-if="editable">
      <tr>
        <th scope="col">
          <button @click="update" class="btn btn-info btn-success btn-sm">
            {{ trans.app.update }}
          </button>
        </th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </tfoot>
  </table>
</template>

<script>
export default {
  name: "factchecks-component",

  props: {
    factchecks: {
      type: Array,
      required: true
    },

    editable: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations)
    }
  },

  methods: {
    addFactcheck() {
      this.factchecks.push({
        id: null,
        claim: '',
        conclusion: ''
      })
    },

    removeFactcheck(id) {
      this.factchecks.splice(id, 1)
    },

    update() {
      if (this.factchecks.length <= 0) return
      let hasError = this.factchecks.some((factcheck) => !factcheck.claim || !factcheck.conclusion)

      if (!hasError) {
        this.$emit('update:factchecks', this.factchecks)
        this.$parent.$parent.update()
      } else {
        alert('cant add factchecks')
      }
    }
  }
}
</script>

<style>

</style>