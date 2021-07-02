<template>
  <div v-if="bread_crumb">
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
      <div
        class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
      >
        <div class="d-flex align-items-center flex-wrap mr-1">
          <div class="d-flex align-items-baseline flex-wrap mr-5">
            <h5 v-if="bread_title" class="text-dark font-weight-bold my-1 mr-5">
              {{ bread_title }}
            </h5>
            <ul
              class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm"
            >
              <li v-if="!Array.isArray(bread_crumb)" class="breadcrumb-item">
                <router-link
                  :to="{ name: bread_crumb.name }"
                  class="text-muted"
                  >{{ bread_crumb }}</router-link
                >
              </li>
              <li
                v-else-if="Array.isArray(bread_crumb)"
                v-for="crumb in bread_crumb"
                :key="crumb.name"
                class="breadcrumb-item"
              >
                <router-link :to="{ name: crumb.name }" class="text-muted">{{
                  crumb.title
                }}</router-link>
              </li>
              <li v-else class="breadcrumb-item">
                <router-link
                  :to="{ name: bread_crumb.name }"
                  class="text-muted"
                  >{{ bread_crumb }}</router-link
                >
              </li>
            </ul>
          </div>
        </div>
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    bread_crumb: null,
    bread_title: null,
  },
};
</script>
