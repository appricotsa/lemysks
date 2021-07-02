<template>
  <div>
    <div
      v-for="error in errors"
      :key="error.any"
      class="alert alert-custom alert-notice alert-light-danger fade show mb-5"
      role="alert"
    >
      <div class="alert-icon"><i class="flaticon-warning"></i></div>
      <div v-for="er in error" :key="er.any" class="alert-text">
        {{ er }}
      </div>
      <div class="alert-close">
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    errors: null,
  },
};
</script>
