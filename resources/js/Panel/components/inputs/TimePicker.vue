<template>
  <div class="form-group">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>

    <div class="input-group">
      <input
        :type="type ? type : 'text'"
        class="form-control"
        v-bind:class="[
          isValid === true
            ? 'is-valid'
            : isValid === false
            ? 'is-invalid'
            : null,
        ]"
        v-bind:name="name"
        v-bind:value="modelValue"
        v-bind:formInputKey="formInputKey ? formInputKey : null"
        v-bind:id="id"
        ref="target"
        readonly="readonly"
      />
      <div class="input-group-append">
        <span class="input-group-text">
          <i class="la la-clock-o"></i>
        </span>
      </div>
    </div>

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
    label: null,
    eMessage: null,
    sMessage: null,
    mendatory: null,
    type: null,
    isValid: null,
    name: { required: true },
    id: { required: true },
    value: null,
    minTime: null,
    maxTime: null,
    formInputKey: null,
  },
  data() {
    return {
      modelValue: null,
    };
  },
  methods: {},
  watch: {
    modelValue: function (e) {
      setTimeout(() => {
        $("#" + this.id).timepicker("setTime", e);
      }, 20);
    },
    value: function (e) {
      this.modelValue = e;
    },
  },
  mounted() {
    var arrows;
    if (KTUtil.isRTL()) {
      arrows = {
        leftArrow: '<i class="la la-angle-right"></i>',
        rightArrow: '<i class="la la-angle-left"></i>',
      };
    } else {
      arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>',
      };
    }
    $("#" + this.id)
      .timepicker({
        minuteStep: 1,
        minTime: this.minTime,
        maxTime: this.maxTime,
        showSeconds: true,
        showMeridian: false,
        snapToStep: true,
        timeFormat: "HH:mm:ss",
      })
      .on("change", () => {
        const value = this.$refs.target.value;
        this.$emit("input", `${value}`);
        const self = this;
        this.modelValue = this.$refs.target.value;
        if (this.value !== this.modelValue) {
          self.$emit("onChange", this.$refs);
        }
      });
    this.modelValue = this.value;
  },
};
</script>

<style>
</style>
