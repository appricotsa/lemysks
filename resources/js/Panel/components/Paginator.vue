<template>
  <!-- eslint-disable vue/no-use-v-if-with-v-for,vue/no-confusing-v-for-v-if -->
  <div v-if="data">
    <div
      v-if="data.total - data.per_page > 0"
      class="d-flex justify-content-between align-items-center flex-wrap"
    >
      <div class="d-flex flex-wrap py-2 mr-3">
        <a
          v-if="data.current_page > 1"
          @click="getLinks(1)"
          class="btn btn-icon btn-sm btn-light-danger mr-2 my-1"
          ><i class="ki ki-bold-double-arrow-back icon-xs"></i
        ></a>
        <a
          v-if="data.current_page > 1"
          @click="getLinks(data.current_page - 1)"
          class="btn btn-icon btn-sm btn-light-danger mr-2 my-1"
          ><i class="ki ki-bold-arrow-back icon-xs"></i
        ></a>

        <a
          v-if="data.current_page > 3"
          @click="getLinks(1)"
          class="btn btn-icon btn-sm border-0 btn-hover-danger mr-2 my-1"
        >
          1</a
        >
        <a
          v-if="data.current_page > 3"
          class="btn btn-icon btn-sm border-0 btn-hover-danger mr-2 my-1"
        >
          ...</a
        >

        <a
          v-for="i in data.last_page"
          :key="i"
          v-bind:class="[data.current_page === i ? 'active' : '']"
          @click="getLinks(i)"
          v-if="i < data.current_page + 3 && i > data.current_page - 3"
          class="btn btn-icon btn-sm border-0 btn-hover-danger mr-2 my-1"
        >
          {{ i }}</a
        >

        <a
          v-if="data.current_page > 0 && data.current_page < data.last_page - 2"
          class="btn btn-icon btn-sm border-0 btn-hover-danger mr-2 my-1"
        >
          ...</a
        >
        <a
          v-if="data.current_page > 0 && data.current_page < data.last_page - 2"
          @click="getLinks(data.last_page)"
          class="btn btn-icon btn-sm border-0 btn-hover-danger mr-2 my-1"
        >
          {{ data.last_page }}</a
        >

        <a
          v-if="data.current_page != data.last_page"
          @click="getLinks(data.current_page + 1)"
          class="btn btn-icon btn-sm btn-light-danger mr-2 my-1"
          ><i class="ki ki-bold-arrow-next icon-xs"></i
        ></a>
        <a
          v-if="data.current_page > 0 && data.current_page != data.last_page"
          @click="getLinks(data.last_page)"
          class="btn btn-icon btn-sm btn-light-danger mr-2 my-1"
          ><i class="ki ki-bold-double-arrow-next icon-xs"></i
        ></a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: null,
    apiPath: null,
    filters: null,
    text: null,
    title: null
  },
  methods: {
    getLinks(i) {
      this.swalFire = Swal.fire({
        title: this.title ? this.title : "Yükleniyor...",
        text: this.text ? this.text : "Getiriliyor.",
        allowOutsideClick: false,
        didOpen: function() {
          Swal.showLoading();
        }
      });
      let formData = new FormData();
      formData.append("page", i);
      this.filters !== null
        ? formData.append("filters", JSON.stringify(this.filters))
        : null;
      this.axios
        .post(this.apiPath, formData)
        .then(response => {
          this.$emit("paginate", response);
        })
        .catch(error => {
          if (error.response.status === 404 || error.response.status === 400) {
            this.errors = error.response.data.errors;
          } else if (error.response.status === 500) {
            this.errors = [{ any: error.response.data.message }];
          }
          this.$emit("errors", this.errors);
          this.swalFire.close();
        })
        .finally(() => this.swalFire.close());
    }
  }
};
</script>

<style>
</style>
