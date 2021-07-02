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
            : null
        ]"
        v-bind:name="name"
        v-bind:value="modelValue"
        v-bind:formInputKey="formInputKey ? formInputKey : null"
        v-bind:id="id"
        readonly="readonly"
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
    id: { required: true },
    value: null,
    startDate: null,
    endDate: null,
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

  watch: {
    modelValue: function(e) {
      setTimeout(() => {
        $("#" + this.id).datepicker("setDate", e);
      }, 20);
    },
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
    $("#" + this.id).datepicker({
      rtl: KTUtil.isRTL(),
      todayHighlight: true,
      orientation: this.position ? this.position : '"top left"',
      format: "yyyy-mm-dd",
      templates: arrows,
      endDate: this.endDate,
      startDate: this.startDate
    });
    const self = this;
    $("#" + this.id).on("changeDate", ev => {
      const value = ev.target.value;
      self.$emit("input", `${value}`);
      self.$emit("onChange", ev);
    });
    if (this.value !== undefined) {
      this.modelValue = this.value;
    }
  }
};
</script>


