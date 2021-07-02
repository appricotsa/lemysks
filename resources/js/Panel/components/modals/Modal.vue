<template>
  <div
    class="modal fade"
    v-bind:id="modalId"
    data-backdrop="static"
    tabindex="-1"
    role="dialog"
    aria-labelledby="staticBackdropEdit"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            {{ title ? title : "Title Yok" }}
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          {{ bodyText ? bodyText : null }}
          <div v-if="createInput" class="row">
            <div
              v-bind:class="
                col.length > 1 ? 'col-xl-' + col[index] : 'col-xl-' + col
              "
              v-for="(attr, index) in inputAttr"
              :key="attr[formInputKey]"
            >
              <formSelect
                v-if="attr.type === 'select'"
                @onChange="inputChange($event)"
                :label="attr.label ? attr.label : 'Başlık Yok'"
                :name="attr.name"
                :value="getSelect(dataForModal, attr)"
                :data="attr.data"
                :dataValue="attr.dataValue"
                :dataValueKey="attr.dataValueKey"
                :id="attr.id ? attr.id : attr.name"
                :placeholder="attr.placeholder ? attr.placeholder : null"
                :formInputKey="dataForModal ? dataForModal[formInputKey] : null"
              ></formSelect>
              <fTextArea
                v-else-if="attr.type === 'textarea'"
                @inputChange="inputChange($event)"
                :value="dataForModal ? dataForModal[attr.name] : null"
                :type="attr.type ? attr.type : 'text'"
                :label="attr.label ? attr.label : 'Başlık Yok'"
                :eMessage="attr.eMessage ? attr.eMessage : ''"
                :sMessage="attr.sMessage ? attr.sMessage : ''"
                :mendatory="attr.mendatory ? true : false"
                :isValid="attr.isValid"
                :id="attr.id"
                :name="attr.name ? attr.name : null"
                :cols="attr.cols ? attr.cols : null"
                :rows="attr.rows ? attr.rows : null"
                :formInputKey="dataForModal ? dataForModal[formInputKey] : null"
              ></fTextArea>
              <fInput
                v-else
                @inputChange="inputChange($event)"
                :value="dataForModal ? dataForModal[attr.name] : null"
                :type="attr.type ? attr.type : 'text'"
                :step="attr.step ? attr.step : null"
                :label="attr.label ? attr.label : 'Başlık Yok'"
                :eMessage="attr.eMessage ? attr.eMessage : ''"
                :sMessage="attr.sMessage ? attr.sMessage : ''"
                :mendatory="attr.mendatory ? true : false"
                :isValid="attr.isValid"
                :name="attr.name ? attr.name : null"
                :formInputKey="dataForModal ? dataForModal[formInputKey] : null"
              ></fInput>
            </div>
          </div>
          <div v-else><slot></slot></div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-light-primary font-weight-bold"
            data-dismiss="modal"
          >
            {{ closeBtnText ? closeBtnText : "Kapat" }}
          </button>
          <button
            v-if="createInput"
            @click="saveEmit()"
            type="button"
            class="btn btn-primary font-weight-bold"
          >
            {{ saveBtnText ? saveBtnText : "Kaydet" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FormInput from "../inputs/FormInput";
import FormSelect from "../inputs/FormSelect";
import FormTextArea from "../inputs/FormTextArea";

export default {
  props: {
    bodyText: null,
    closeBtnText: null,
    saveBtnText: null,
    title: null,
    modalId: null,
    dataForModal: null,
    col: null,
    createInput: null,
    inputAttr: null,
    formInputKey: null
  },
  components: {
    fInput: FormInput,
    formSelect: FormSelect,
    fTextArea: FormTextArea
  },

  methods: {
    saveEmit() {
      if (this.dataPacket.length > 0) {
        this.dataSend["data"] = this.dataPacket;
      }
      this.dataSend["row"] = this.dataForModal;
      $("#" + this.modalId).modal("hide");
      this.$emit("saveClick", this.dataSend);
    },
    inputChange(e) {
      const targetName = e.target.attributes["name"]["value"];
      const targetValue = e.target.value;
      const targetOldValue = this.dataForModalClone[targetName];
      if (targetValue !== targetOldValue) {
        const findDataIndex = this.dataPacket.findIndex(
          o => o.name === targetName
        );
        if (findDataIndex !== -1) {
          this.dataPacket[findDataIndex].newData = targetValue;
        } else {
          const packet = {
            name: targetName,
            oldData: targetOldValue,
            newData: targetValue
          };
          this.dataPacket.push(packet);
        }
      }
      this.dataForModal[targetName] = targetValue;
      this.$emit("input", e);
    },
    getSelect(e, c) {
      if (e !== null) {
        $("#" + c.name)
          .select2()
          .val(e[c.dataValueKey])
          .trigger("change");
        return e[c.dataValueKey];
      }
    }
  },
  data() {
    return {
      dataForModalClone: [],
      dataPacket: [],
      dataSend: []
    };
  },
  watch: {
    dataForModal: function(e) {
      this.dataForModalClone = this.dataForModal;
    }
  },
  mounted() {}
};
</script>
