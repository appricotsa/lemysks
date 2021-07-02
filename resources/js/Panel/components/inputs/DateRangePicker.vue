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
        ref="target"
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
    id: { requred: true },
    valueStartDate: null,
    valueEndDate: null,
    position: {
      type: String
    },
    formInputKey: null
  },
  data() {
    return {
      modelValue: null,
      momentValueStartDate: null,
      momentValueEndDate: null
    };
  },
  methods: {},
  watch: {
    modelValue: function(e) {
      $("#" + this.id)
        .data("daterangepicker")
        .setStartDate(e.split(" - ")[0]);
      $("#" + this.id)
        .data("daterangepicker")
        .setEndDate(e.split(" - ")[1]);
    },
    value: function(e) {
      this.modelValue = e;
    }
  },

  mounted() {
    $("#" + this.id).daterangepicker({
      buttonClasses: " btn",
      applyClass: "btn-primary",
      cancelClass: "btn-secondary",
      locale: {
        format: "DD-MM-YYYY"
      }
    });
    const self = this;
    $("#" + this.id).on("apply.daterangepicker", function(ev, picker) {
      $(this).val(
        picker.startDate.format("DD-MM-YYYY") +
          " - " +
          picker.endDate.format("DD-MM-YYYY")
      );

      const value = self.$refs.target.value;
      self.$emit("input", `${value}`);
      self.modelValue = self.$refs.target.value;
      self.$emit("onChange", self.$refs);
    });

    setTimeout(() => {
      if (Array.isArray(this.valueStartDate)) {
        if (this.valueStartDate[0] === "subtract") {
          this.momentValueStartDate = moment()
            .subtract(this.valueStartDate[2], this.valueStartDate[1])
            .format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setStartDate(this.momentValueStartDate);
        } else if (this.valueStartDate[0] === "add") {
          this.momentValueStartDate = moment()
            .add(this.valueStartDate[2], this.valueStartDate[1])
            .format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setStartDate(this.momentValueStartDate);
        } else if (this.valueStartDate[0] === "now") {
          this.momentValueStartDate = moment().format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setStartDate(this.momentValueStartDate);
        }
      } else {
        console.error(
          this.valueStartDate + ": Girdiğiniz date formatı düzgün değil.",
          'Örnek: ["subtract", "month", 1]'
        );
      }
      if (Array.isArray(this.valueEndDate)) {
        if (this.valueEndDate[0] === "subtract") {
          this.momentValueEndDate = moment()
            .subtract(this.valueEndDate[2], this.valueEndDate[1])
            .format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setEndDate(this.momentValueEndDate);
        } else if (this.valueEndDate[0] === "add") {
          this.momentValueEndDate = moment()
            .add(this.valueEndDate[2], this.valueEndDate[1])
            .format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setEndDate(this.momentValueEndDate);
        } else if (this.valueEndDate[0] === "now") {
          this.momentValueEndDate = moment().format("DD-MM-YYYY");
          $("#" + this.id)
            .data("daterangepicker")
            .setEndDate(this.momentValueEndDate);
        }
      } else {
        console.error(
          this.valueStartDate + ": Girdiğiniz date formatı düzgün değil.",
          'Örnek: ["subtract", "month", 1]'
        );
      }
    }, 20);
  }
};
</script>


