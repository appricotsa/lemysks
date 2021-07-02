<template>
  <div class="form-group">
    <label class="form-control-label">
      {{ label }}
      <span v-if="mendatory" class="text-danger"> *</span>
    </label>

    <div class="input-group">
      <input
        :type="type ? type : 'text'"
        class="form-control datetimepicker-input"
        v-bind:class="[
          isValid === true
            ? 'is-valid'
            : isValid === false
            ? 'is-invalid'
            : null
        ]"
        v-bind:name="name"
        v-bind:formInputKey="formInputKey ? formInputKey : null"
        v-bind:id="id"
        ref="target"
        readonly="readonly"
        v-bind:value="modelValue"
        v-bind:disabled="disabled ? disabled : null"
        data-toggle="datetimepicker"
        v-bind:data-target="'#' + id"
      />
      <div class="input-group-append">
        <span class="input-group-text">
          <i class="la la-calendar-check-o"></i>
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
    id: { requred: true },
    value: null,
    minDate: null,
    maxDate: null,
    disabled: null,
    minHour: null,
    position: {
      type: String
    },
    formInputKey: null
  },
  data() {
    return {
      modelValue: null
    };
  },
  methods: {},
  watch: {
    value: function(e) {
      this.modelValue = e;
    }
  },
  mounted() {
    var arrows;
    if (KTUtil.isRTL()) {
      arrows = {
        leftArrow: '<i class="la la-angle-right"></i>',
        rightArrow: '<i class="la la-angle-left"></i>'
      };
    } else {
      arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
      };
    }
    $("#" + this.id).datetimepicker({
      format: "yyyy-MM-DD HH:mm:ss",
      maxDate: this.maxDate,
      minDate: this.minDate
    });
    $("#" + this.id).on("change.datetimepicker", () => {
      const value = this.$refs.target.value;
      this.$emit("input", `${value}`);
      const self = this;
      this.modelValue = this.$refs.target.value;
      if (this.value !== this.modelValue) {
        self.$emit("onChange", this.$refs);
      }
    });
    if (this.value !== null && this.value !== undefined) {
      this.modelValue =
        this.value.split("T").length > 1
          ? this.value.split("T")[0] +
            " " +
            this.value.split("T")[1].substr(0, 8)
          : this.value;
    }
  }
};
</script>


