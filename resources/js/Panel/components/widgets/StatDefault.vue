<template>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4">
    <!--begin::Stats Widget 29-->
    <div
      class="card card-custom bgi-no-repeat card-stretch gutter-b"
      style="
        background-position: right top;
        background-size: 30% auto;
        background-image: url(assets/media/svg/shapes/abstract-1.svg);
      "
    >
      <!--begin::Body-->
      <div class="card-body">
        <span
          class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-3 d-block"
          >{{ value !== null ? value : ":value is empty" }}</span
        >
        <span class="font-weight-bold text-muted font-size-sm">{{
          title !== null ? title : ":title is empty"
        }}</span>
      </div>
      <!--end::Body-->
    </div>
    <!--end::Stats Widget 29-->
  </div>
</template>

<script>
export default {
  props: {
    title: null,
    value: null,
  },
};
</script>

<style>
</style>
