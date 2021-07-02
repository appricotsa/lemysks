<template>
  <router-view></router-view>
</template>

<script>
export default {
  data() {
    return {
      login: false,
      name: "",
      users: [],
      message: "",
      messages: [],
    };
  },
};
</script>
