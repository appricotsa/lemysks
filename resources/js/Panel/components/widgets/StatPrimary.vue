<template>
  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4">
    <!--begin::Stats Widget 32-->
    <div class="card card-custom bg-dark card-stretch gutter-b">
      <!--begin::Body-->
      <div class="card-body">
        <span
          class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-3 text-hover-primary d-block"
          >{{ value }}</span
        >
        <span class="font-weight-bold text-white font-size-sm">{{
          title
        }}</span>
      </div>
      <!--end::Body-->
    </div>
    <!--end::Stats Widget 32-->
  </div>
</template>

<script>
export default {
  props: {
    title: { required: true },
    value: { required: true }
  }
};
</script>

<style>
</style>
