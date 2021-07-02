<template>
  <div class="row">
    <div class="col-xl-12">
      <!--begin::Advance Table Widget 1-->
      <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 py-5">
          <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Filters</span>
          </h3>
          <div class="text-right">
            <button
              class="btn"
              type="button"
              data-toggle="collapse"
              data-target="#collapseExample"
              aria-expanded="false"
              aria-controls="collapseExample"
            >
              <i
                class="flaticon p-0"
                :class="[open ? 'flaticon2-up' : 'flaticon2-down']"
                @click="change()"
              ></i>
            </button>
          </div>
        </div>

        <!--end::Header-->
        <!--begin::Body-->
        <div class="collapse" id="collapseExample">
          <div class="card-body py-0">
            <slot></slot>
          </div>
          <div class="card-footer text-right">
            <button
              type="reset"
              @click="resetEmit()"
              class="btn btn-danger mr-2"
            >
              Reset
            </button>
            <button
              type="button"
              @click="saveEmit()"
              class="btn btn-light mr-2"
            >
              Filter
            </button>
          </div>
        </div>
        <!--end::Body-->
      </div>
      <!--end::Advance Table Widget 1-->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      open: true,
    };
  },
  methods: {
    resetEmit() {
      this.$emit("resetClick", true);
    },
    saveEmit() {
      this.$emit("filterClick", true);
    },
    change() {
      this.open = !this.open;
    },
  },
};
</script>

<style>
</style>
