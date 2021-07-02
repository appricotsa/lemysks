<template>
  <div class="dd" v-if="data">
    <ol class="dd-list">
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
              @click="editData(d)"
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
          @updateData="updateData"
          @done="done()"
          :data="d[childrenColumn]"
          :keyValue="'category_guid'"
          :parentKeyValue="'parent_category_guid'"
          :text="'text'"
          :childrenColumn="'children'"
          :dataLength="data.length"
          :orderColumn="orderColumn"
          :editable="editable"
        ></children>
      </li>
    </ol>
    <eModal
      :modalId="'editModal'"
      :createInput="true"
      :col="[12]"
      :inputAttr="[
        {
          type: 'text',
          name: text,
          label: 'İsim',
          id: text
        }
      ]"
      :title="'Veriyi Düzenle'"
      :dataForModal="edit_data"
      :formInputKey="keyValue"
      :key="componentKey"
      @saveClick="editModalSave($event)"
    ></eModal>
  </div>
</template>

<script>
import Modal from "../../components/modals/Modal";

export default {
  components: {
    children: () => import("./Children.vue"),
    eModal: Modal
  },
  props: {
    data: { required: true, type: Array },
    keyValue: { required: true, type: String },
    parentKeyValue: { required: true, type: String },
    text: { required: true, type: String },
    childrenColumn: { required: true, type: String },
    editable: { required: true, type: Boolean },
    orderColumn: { type: String }
  },
  data() {
    return {
      serialize: false,
      componentKey: 0,
      idList: [],
      parentId: 0,
      list: [],
      parentList: null,
      depth: 0
    };
  },
  methods: {
    done() {
      this.serialize = true;
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
    },
    updateOutput(e) {
      this.refresh += 1;
      const self = this;
      this.idList = [];
      if (e.target.className === "dd") {
        setTimeout(() => {
          const ddItems = document.getElementsByClassName("dd-item");
          Array.from(ddItems).forEach(item => {
            const id = item.getAttribute("data-id");
            const parentId = item.getAttribute("data-parent-id");
            const findOrderLength = self.idList.filter(
              o => o.parentId === parentId
            ).length;
            self.idList.push({
              id: id,
              parentId: parentId,
              order: findOrderLength
            });
          });
          this.$emit("onChange", this.idList);
        }, 300);
      }
    },
    editData(d) {
      this.edit_data = JSON.parse(JSON.stringify(d));
      $("#editModal").modal("show");
    },
    editModalSave(e) {
      this.changeData(this.data, e);
      this.$emit("updateData", e);
    },
    changeData(data, e) {
      data.forEach(d => {
        const index = data.findIndex(
          o => o[this.keyValue] === e.row[this.keyValue]
        );
        if (index !== -1) {
          data[index][this.text] = e.row[this.text];
          this.componentKey += 1;
        } else {
          if (d[this.childrenColumn].length > 0) {
            this.changeData(d[this.childrenColumn], e);
          } else {
            return;
          }
        }
      });
    },
    updateData(e) {
      const index = this.data.findIndex(
        o => o[this.keyValue] === e.row[this.keyValue]
      );
      if (index !== -1) {
        this.data[index] = e.row;
        this.componentKey += 1;
      }
      this.$emit("updateData", e);
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
    nestable_data: {
      get() {
        return this.$store.getters.nestable_data;
      },
      set(newValue) {
        return this.$store.dispatch("nestable_data", newValue);
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
  watch: {
    serialize() {
      $(".dd")
        .nestable({ maxDepth: 20, collapsedClass: "dd-collapsed" })
        .on("change", this.updateOutput);
      $(".dd").nestable("collapseAll");
      this.$store.dispatch("nestable_data", this.data);
      this.refresh += 1;
    }
  }
};
</script>
