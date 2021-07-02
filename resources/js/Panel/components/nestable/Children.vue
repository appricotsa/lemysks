<template>
  <ol class="dd-list" v-if="data">
    <li
      class="dd-item"
      v-bind:data-id="d[keyValue]"
      :ref="d[keyValue]"
      v-bind:data-parent-id="getParentId(d)"
      v-bind:order="orderColumn ? d[orderColumn] : null"
      v-bind:refresh="refresh"
      v-for="d in data"
      :key="d[keyValue]"
    >
      <div class="dd-handle">
        {{ d[text] }}
        <div v-if="editable">
          <button
            @click="editDataChildren(d)"
            type="button"
            class="btn btn-sm btn-icon btn-primary pulse pulse-primary mr-2"
          >
            <i class="flaticon2-edit"></i> <span class="pulse-ring"></span>
          </button>
          <button
            type="button"
            class="btn btn-sm btn-icon btn-danger pulse pulse-danger mr-2"
          >
            <i class="flaticon2-trash"></i> <span class="pulse-ring"></span>
          </button>
        </div>
      </div>

      <children
        @done="done()"
        :data="checkChildren(d[childrenColumn])"
        :keyValue="'category_guid'"
        :text="'text'"
        :childrenColumn="'children'"
        :dataLength="data.length"
        :editable="editable"
        :parentKeyValue="'parent_category_guid'"
        :orderColumn="orderColumn"
      ></children>
    </li>
  </ol>
</template>

<script>
import Modal from "../../components/modals/Modal";

export default {
  components: {
    children: () => import("./Children.vue"),
    eModal: Modal
  },
  data() {
    return {
      serialize: false,
      counter: 0,
      componentKey: 0
    };
  },
  methods: {
    checkChildren(d) {
      if (d.length === 0) {
        if (this.counter === this.dataLength) {
          this.$emit("done");
        } else {
          this.counter += 1;
        }
        return null;
      } else {
        return d;
      }
    },
    done() {
      this.$emit("done");
    },
    editDataChildren(d) {
      this.edit_data = JSON.parse(JSON.stringify(d));
      $("#editModal").modal("show");
    },
    getParentId(evd) {
      if (this.$refs[evd[this.keyValue]] !== undefined) {
        const dataId = this.$refs[
          evd[this.keyValue]
        ][0].parentElement.parentElement.getAttribute("data-id");
        if (dataId !== null) {
          return dataId;
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    }
  },
  computed: {
    edit_data: {
      get() {
        return this.$store.getters.edit_data;
      },
      set(newValue) {
        return this.$store.dispatch("edit_data", newValue);
      }
    },
    refresh: {
      get() {
        return this.$store.getters.refresh;
      },
      set(newValue) {
        return this.$store.dispatch("refresh", newValue);
      }
    }
  },
  props: {
    data: { required: true },
    keyValue: { required: true, type: String },
    text: { required: true, type: String },
    childrenColumn: { required: true, type: String },
    dataLength: { required: true, type: Number },
    editable: { required: true, type: Boolean },
    parentKeyValue: { required: true, type: String },
    orderColumn: { type: String }
  }
};
</script>
