<template>
  <div class="form-group">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>
    <input
      @input="inputChange($event)"
      :type="type ? type : 'text'"
      class="form-control"
      v-bind:class="[
        isValid === true ? 'is-valid' : isValid === false ? 'is-invalid' : null
      ]"
      v-bind:name="name"
      v-bind:value="value"
      v-on:input="$emit('input', $event.target.value)"
      v-bind:formInputKey="formInputKey ? formInputKey : null"
      v-bind:maxlength="maxlength ? maxlength : null"
      v-bind:id="id"
      v-bind:step="step ? step : null"
      v-bind:placeholder="placeholder ? placeholder : null"
    />
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
    id: { requred: true },
    type: null,
    isValid: null,
    name: { required: true },
    step: null,
    value: null,
    maxlength: null,
    formInputKey: null,
    placeholder: null
  },
  data() {
    return {
      modelValue: null
    };
  },
  methods: {
    inputChange(e) {
      this.$emit("inputChange", e);
    }
  },
  mounted() {
    this.modelValue = this.value;
  }
};
</script>
