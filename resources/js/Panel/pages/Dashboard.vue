<template>
  <parent>
    <!-- Breed Crumb Begin -->
    <breadCrumb :bread_title="bread_title" :bread_crumb="bread_crumb">
    </breadCrumb>
    <!-- Breed Crumb End -->
    <Nestable
      @updateData="updateData"
      @onChange="test"
      :data="categories"
      :childrenColumn="'children'"
      :keyValue="'category_guid'"
      :parentKeyValue="'parent_category_guid'"
      :text="'text'"
      :orderColumn="'order'"
      :editable="true"
    ></Nestable>
  </parent>
</template>

<script>
import Wrapper from "../modules/Wrapper";
import BreadCrumb from "../routes/BreadCrumb";
import Nestable from "../components/Nestable/Nestable";

export default {
  components: {
    parent: Wrapper,
    breadCrumb: BreadCrumb,
    Nestable
  },
  data() {
    return {
      categories: [],
      bread_title: "Bread Title",
      bread_crumb: [
        {
          url: "/admin/",
          title: "Dashboard"
        }
      ]
    };
  },
  beforeCreate() {
    this.axios.post("/api/categories").then(r => {
      this.categories = r.data.categories;
    });
  },
  methods: {
    test(e) {
      console.log(e);
    },
    updateData(e) {
      console.log("main2", e);
    }
  },
  mounted() {
    /* this.sockets.subscribe("test", data => {
      console.log("Bu bir Testttir", data);
    });
    setTimeout(() => {
      this.$socket.emit("users-test", "test message");
    }, 2000);*/
  }
};
</script>
