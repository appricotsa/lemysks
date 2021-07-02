<template>
  <div class="form-group d-flex flex-column">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>
    <select
      @change="change($event)"
      v-bind:name="name"
      v-bind:formInputKey="formInputKey ? formInputKey : null"
      class="form-control select2"
      v-bind:id="id"
      v-bind:value="modelValue"
      ref="target"
      v-select2
    >
      <option :value="d[dataValueKey]" v-for="d in data" :key="d[dataValueKey]">
        {{ d[dataValue] }}
      </option>
    </select>
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
  props: ["value"],
  props: {
    id: { required: true },
    label: null,
    name: { required: true },
    value: null,
    data: { required: true },
    dataValueKey: { required: true, type: String },
    placeholder: null,
    dataValue: { required: true, type: String },
    formInputKey: null,
    mendatory: null,
    isValid: null,
    sMessage: null,
    eMessage: null
  },
  data() {
    return {
      modelValue: null
    };
  },
  methods: {
    change(e) {
      const value = this.$refs.target.value;
      this.$emit("input", `${value}`);
      const self = this;
      this.modelValue = this.$refs.target.value;

      if (this.value !== this.modelValue) {
        self.$emit("onChange", this.$refs);
      } else if (this.modelValue.toString() === "0") {
        self.$emit("onChange", this.$refs);
      }
    }
  },
  watch: {
    modelValue: function(e) {
      setTimeout(() => {
        if (this.data.length > 0) {
          $("#" + this.id)
            .select2()
            .val(e)
            .trigger("change");
        }
      }, 20);
    },
    value: function(e) {
      this.modelValue = e;
    },
    data: function(e) {
      if (e.length === 0) {
        $("#" + this.id).select2({
          placeholder: this.placeholder
        });
      }
    }
  },
  directives: {
    select2: {
      bind: function(el, binding, vnode) {
        $(el).on("select2:select", () => {
          const event = new Event("change", {
            bubbles: true,
            cancelable: true
          });
          el.dispatchEvent(event);
        });
      }
    }
  },
  mounted() {
    this.modelValue = this.value;
    $("#" + this.id).select2({
      placeholder: this.placeholder
    });
  }
};
</script>

<style>
</style>
