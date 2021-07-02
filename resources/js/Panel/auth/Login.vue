<template>
  <div class="login-form">
    <!--begin::Form-->

    <!--begin::Title-->
    <div class="pb-5 pb-lg-15">
      <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">
        Giriş Yap
      </h3>
    </div>
    <!--begin::Title-->
    <!--begin::Form group-->
    <div class="row">
      <div class="col-xl-12">
        <errorAlert :errors="errors"></errorAlert>
      </div>
    </div>
    <div class="form-group">
      <label class="font-size-h6 font-weight-bolder text-dark">E-Mail</label>
      <input
        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"
        type="text"
        name="email"
        v-model="email"
        autocomplete="off"
      />
    </div>
    <!--end::Form group-->
    <!--begin::Form group-->
    <div class="form-group">
      <div class="d-flex justify-content-between mt-n5">
        <label class="font-size-h6 font-weight-bolder text-dark pt-5"
          >Şifre</label
        >
      </div>
      <input
        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0"
        type="password"
        name="pw"
        v-model="pw"
        autocomplete="off"
      />
    </div>
    <!--end::Form group-->
    <!--begin::Action-->
    <div class="pb-lg-0 pb-5">
      <button
        type="button"
        class="btn btn-primary"
        @click="login()"
        v-bind:class="[isClick ? 'spinner spinner-white spinner-right' : '']"
        v-bind:disabled="isClick"
      >
        Giriş Yap
      </button>
    </div>
    <!--end::Action-->
  </div>
</template>

<script>
import ErrorAlert from "../components/alerts/Error";

export default {
  components: {
    errorAlert: ErrorAlert
  },
  data() {
    return {
      isClick: false,
      email: null,
      pw: null,
      errors: []
    };
  },
  methods: {
    login() {
      this.isClick = true;
      this.errors = [];
      if (this.email === null || this.email === "") {
        this.errors.push({ any: "E-Mail Boş Olamaz" });
      }
      if (this.pw === null || this.pw === "") {
        this.errors.push({ any: "Şifre Boş Olamaz" });
      }
      if (this.errors.length > 0) {
        this.isClick = false;
        return;
      }
      const formData = new FormData();
      formData.append("email", this.email);
      formData.append("pw", this.pw);
      this.axios
        .post("/admin/doLogin", formData)
        .then(response => {
          window.location = "/admin";
        })
        .catch(error => {
          if (error.response.status === 404 || error.response.status === 400) {
            this.errors = error.response.data.errors;
          } else if (error.response.status === 500) {
            this.errors = [{ any: error.response.data.message }];
          }
          this.isClick = false;
          this.swalFire.close();
        });
    }
  }
};
</script>
