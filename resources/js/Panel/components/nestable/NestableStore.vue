<script>
export default {
  state: {
    nestable_data: {},
    edit_data: {},
    refresh: 0
  },
  getters: {
    nestable_data(state) {
      return state.nestable_data;
    },
    edit_data(state) {
      return state.edit_data;
    },
    refresh(state) {
      return state.refresh;
    }
  },
  actions: {
    nestable_data(context, data) {
      context.commit("nestable_data", data);
    },
    edit_data(context, data) {
      context.commit("edit_data", data);
    },
    refresh(context, data) {
      context.commit("refresh", data);
    }
  },
  mutations: {
    nestable_data(state, data) {
      return (state.nestable_data = data);
    },
    edit_data(state, data) {
      return (state.edit_data = data);
    },
    refresh(state, data) {
      return (state.refresh = data);
    }
  }
};
</script>
