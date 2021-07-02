<template>
  <!--begin::Advance Table Widget 1-->
  <div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 py-5">
      <h3 class="card-title align-items-start flex-column">
        <span class="card-label font-weight-bolder text-dark">{{ title }}</span>
      </h3>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-0">
      <!--begin::Table-->
      <div class="table-responsive">
        <table
          class="table table-head-custom table-vertical-center"
          id="kt_advance_table_widget_1"
        >
          <thead>
            <tr class="text-left">
              <th
                style="min-width: 200px"
                v-bind:style="[
                  tr.minWidth !== undefined
                    ? 'min-width:' + tr.minWidth + 'px'
                    : 'min-width: 200px',
                ]"
                v-for="tr in trs"
                :key="tr.title"
              >
                {{ tr.title }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(data, index) in dataForTable"
              v-bind:item="data"
              v-bind:index="index"
              v-bind:key="data[formInputKey]"
            >
              <td
                v-for="(a, index) in editBtn ? attr.length + 1 : attr.length"
                :key="index"
              >
                <span
                  class="text-dark-75 font-weight-bolder d-block font-size-lg"
                >
                  {{ data[attr[index]] }}
                </span>
                <span
                  v-if="
                    (editBtn || removeBtn) &&
                    index == (editBtn ? attr.length : attr.length - 1)
                  "
                  class="text-dark-75 font-weight-bolder d-block font-size-lg"
                >
                  <button
                    v-if="
                      editBtn &&
                      index == (editBtn ? attr.length : attr.length - 1)
                    "
                    @click="editModalClick(data[formInputKey])"
                    type="button"
                    class="btn btn-icon btn-light-primary mr-2"
                  >
                    <i class="flaticon2-edit"></i>
                  </button>
                  <button
                    v-if="
                      removeBtn &&
                      index == (editBtn ? attr.length : attr.length - 1)
                    "
                    type="button"
                    data-toggle="modal"
                    data-target="#staticBackdropRemove"
                    class="btn btn-icon btn-danger mr-2"
                  >
                    <i class="flaticon2-trash"></i>
                  </button>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--end::Table-->
    </div>
    <!--end::Body-->
    <eModal
      @click="saveEmit"
      @input="inputChange"
      :modalId="'editModal'"
      :createInput="createModalInput"
      :col="col"
      :dataForModal="dataForModal"
      :inputAttr="inputModalAttr"
      :formInputKey="formInputKey"
      :key="componentKey"
      >{{ contentText }}</eModal
    >
  </div>

  <!--end::Advance Table Widget 1-->
</template>

<script>
import Modal from "../modals/Modal.vue";
export default {
  data() {
    return {
      dataForModal: null,
      componentKey: 0,
    };
  },
  props: {
    title: null,
    dataForTable: null,
    attr: null,
    trs: null,
    editBtn: null,
    removeBtn: null,
    createModalInput: null,
    inputModalAttr: null,
    col: null,
    formInputKey: null,
    contentText: null,
  },
  components: {
    eModal: Modal,
  },

  methods: {
    inputChange(e) {
      this.dataForModal[e.target.attributes["name"]["value"]] = e.target.value;
      this.$emit("input", this.dataForModal);
    },
    saveEmit(e) {
      const Index = this.dataForTable.findIndex(
        (o) => o[this.formInputKey] == this.dataForModal[this.formInputKey]
      );
      this.dataForTable[Index] = this.dataForModal;
      this.$emit("editModalSave", this.dataForTable[Index]);
      this.componentKey += 1;
      $("#editModal").modal("hide");
    },
    editModalClick(key) {
      this.dataForModal = JSON.parse(
        JSON.stringify(
          this.dataForTable.find((o) => o[this.formInputKey] == key)
        )
      );
      $("#editModal").modal("show");
    },
  },
  mounted() {},
};
</script>

<style>
</style>
