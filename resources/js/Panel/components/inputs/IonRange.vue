<template>
  <div class="form-group">
    <label class="form-control-label">{{ title }}</label>
    <a
      @click="resetRange"
      style="float: right; margin-top: -3px !important"
      class="btn btn-icon btn-outline-danger btn-circle btn-xs m-auto"
    >
      <i class="flaticon-refresh"></i>
    </a>
    <div class="ion-range-slider">
      <input type="hidden" v-bind:id="id" v-bind:name="name" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: null,
    type: null,
    grid: false,
    min: null,
    max: null,
    from: null,
    to: null,
    prefix: "",
    id: { required: true },
    name: { required: true },
    value: null,
  },
  methods: {
    resetRange() {
      const data = $("#" + this.id).data("ionRangeSlider");
      data.reset();
      this.$emit("reset", data);
    },
  },
  mounted() {
    const self = this;
    $("#" + this.id).ionRangeSlider({
      type: this.type,
      grid: this.grid,
      min: this.min,
      max: this.max,
      from: this.from,
      to: this.to,
      prefix: this.prefix,
      onStart: function (data) {
        self.$emit("onStart", data);
      },
      onChange: function (data) {
        self.$emit("onChange", data);
      },
      onFinish: function (data) {
        self.$emit("onFinish", data);
      },
      onUpdate: function (data) {
        self.$emit("onUpdate", data);
      },
    });
  },
};
</script>

<style>
</style>
