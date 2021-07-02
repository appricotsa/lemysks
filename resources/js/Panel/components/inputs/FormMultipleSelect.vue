<template>
  <div class="form-group d-flex flex-column">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>
    <select
      v-bind:name="name"
      class="form-control select2"
      v-bind:id="id"
      multiple="multiple"
    >
      <option :value="d[dataValueKey]" v-for="d in data" :key="d[dataValueKey]">
        {{ d[dataValue] }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  props: ["value"],
  props: {
    id: { required: true },
    label: null,
    name: { required: true },
    value: null,
    data: { required: true },
    dataValueKey: { required: true, type: String },
    placeholder: null,
    selected: { required: true },
    dataValue: { required: true, type: String },
    formInputKey: null,
    multiple: null,
    mendatory: null
  },
  data() {
    return {
      values: []
    };
  },
  watch: {
    data: function(e) {
      if (e.length === 0) {
        $("#" + this.id).select2({
          placeholder: this.placeholder
        });
      }
    }
  },
  mounted() {
    $("#" + this.id).select2({
      placeholder: this.placeholder
    });
    $("#" + this.id)
      .select2()
      .val(this.selected)
      .trigger("change");
    this.values = this.selected;
    $("#" + this.id).on("select2:select", e => {
      const value = e.params.data.id;
      this.values.push(value);
      this.$emit("input", this.values);
      e.detail = this.values;
      this.$emit("onChange", e);
    });

    $("#" + this.id).on("select2:unselect", e => {
      const value = e.params.data.id;
      const findHastagIndex = this.values.findIndex(o => o === value);
      this.values.splice(findHastagIndex, 1);
      this.$emit("input", this.values);
      e.detail = this.values;
      this.$emit("onChange", e);
    });
  }
};
</script>

<style>
</style>
