<template>
  <span class="switch switch-outline switch-icon switch-success">
    <label>
      <input
        type="checkbox"
        @change="change($event)"
        v-bind:checked="checked"
        v-bind:name="name"
        v-bind:inputKey="inputKey"
      />
      <span></span>
    </label>
  </span>
</template>

<script>
export default {
  props: {
    checked: null,
    name: { required: true },
    inputKey: null
  },
  methods: {
    change(ev) {
      this.$emit("onChange", ev);
      this.$emit("input", ev.target.checked);
    }
  }
};
</script>

<style>
</style>
