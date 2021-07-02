<template>
  <div
    class="image-input image-input-outline"
    v-bind:class="[imageType === 'circle' ? 'image-input-circle' : null]"
    v-bind:id="id"
    v-bind:style="' background-image: url(/backend/media/users/blank.png);'"
  >
    <div
      class="image-input-wrapper"
      v-bind:style="
        imagePath !== null ? ' background-image: url(' + imagePath + ');' : null
      "
    ></div>

    <label
      class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
      data-action="change"
      data-toggle="tooltip"
      title=""
      data-original-title="Change avatar"
    >
      <i class="fa fa-pen icon-sm text-muted"></i>
      <input
        @change="change($event)"
        type="file"
        v-bind:name="name"
        v-bind:formInputKey="formInputKey"
        v-on:input="$emit('input', $event.target.files[0])"
        accept=".png, .jpg, .jpeg"
        ref="target"
      />
      <input type="hidden" v-bind:name="name + '_remove'" />
    </label>

    <span
      class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
      data-action="cancel"
      data-toggle="tooltip"
      title="Cancel avatar"
    >
      <i class="ki ki-bold-close icon-xs text-muted"></i>
    </span>

    <span
      v-if="imagePath"
      class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
      data-action="remove"
      data-toggle="tooltip"
      title="Remove avatar"
    >
      <i class="ki ki-bold-close icon-xs text-muted"></i>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    id: { required: true },
    imageType: null,
    imagePath: null,
    name: { required: true },
    formInputKey: null
  },
  data() {
    return {
      file: null
    };
  },
  methods: {
    change(e) {
      this.file = e.target.files[0];
      this.$emit("onChange", { target: e.target, type: "uploaded" });
    }
  },
  mounted() {
    const self = this;
    var avatar4 = new KTImageInput(this.id);
    avatar4.on("remove", function(imageInput) {
      self.file = "deleted";
      self.$emit("onChange", { target: self.$refs.target, type: "deleted" });
    });
    avatar4.on("cancel", function(imageInput) {
      self.file = "canceled";
      self.$emit("onChange", { target: self.$refs.target, type: "canceled" });
    });
  }
};
</script>

<style>
</style>
