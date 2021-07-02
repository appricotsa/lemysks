<template>
  <div class="form-group">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>
    <textarea
      @input="inputChange($event)"
      :type="type ? type : 'text'"
      class="form-control"
      v-bind:class="[
        isValid === true ? 'is-valid' : isValid === false ? 'is-invalid' : null,
      ]"
      v-bind:name="name"
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
      v-bind:formInputKey="formInputKey ? formInputKey : null"
      v-bind:rows="rows ? rows : 3"
      v-bind:id="id"
      v-bind:cols="cols ? cols : null"
    ></textarea>
    <div v-if="isValid" class="valid-feedback">
      {{ sMessage ? sMessage : null }}
    </div>
    <div v-if="!isValid" class="invalid-feedback">
      {{ eMessage ? eMessage : null }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    label: null,
    eMessage: null,
    sMessage: null,
    mendatory: null,
    type: null,
    id: { required: true },
    isValid: null,
    name: { required: true },
    rows: null,
    cols: null,
    col: null,
    value: null,
    formInputKey: null,
  },
  data() {
    return {
      modelValue: null,
    };
  },
  methods: {
    inputChange(e) {
      this.$emit("inputChange", e);
    },
  },
  mounted() {
    this.modelValue = this.value;
  },
};
</script>

<style>
</style>
