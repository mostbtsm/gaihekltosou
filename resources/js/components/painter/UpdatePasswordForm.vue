<template>
<div v-if="success" class="setting-complete">
  <div class="message-title">パスワードの変更を<br/>完了致しました</div>
  <div class="message-content">引き続き塗装道埸を<br/>ご利用ください</div>
</div>

<div v-else class="password-form">
  <form id="form" @submit.prevent="submitForm">
    <FormInput v-for="(param, key) in form_params" :key="key"
      :id="param.id"
      :name="param.name"
      :type="param.type"
      :title="param.title"
      :placeholder="param.placeholder"
      :errors="param.errors"
      v-model="param.value"
    ></FormInput>

    <button type="submit" class="btn-send">送信</button>
  </form>
</div>
</template>

<script>
import { Api } from "js/route/painter.js";
import FormInput from "js/components/form/FormInput.vue";

export default {
  data() {
    return {
      success: false,
      form_params: {
        old_password: {
          id: "old_password",
          name: "old_password",
          type: "password",
          title: "現在のパスワード",
          value: "",
          placeholder: "",
          errors: [],
        },
        new_password: {
          id: "new_password",
          name: "new_password",
          type: "password",
          title: "新しいパスワード",
          value: "",
          placeholder: "",
          errors: [],
        },
        new_password_confirm: {
          id: "new_password_confirmation",
          name: "new_password_confirmation",
          type: "password",
          title: "確認用",
          value: "",
          placeholder: "",
          errors: [],
        },
      },
    };
  },
  computed: {

  },
  methods: {
    submitForm() {
      axios.post(Api.updatePassword, this.getFormParams()).then(response => {
        this.success = true;
      }).catch(error => {
        if (error.response) {
          if (error.response.status == 422) {
            this.setParamErrors(error.response.data);
          }
        }
      });
    },
    getFormParams() {
      const params = new URLSearchParams();
      Object.keys(this.form_params).forEach(key => {
        params.append(this.form_params[key].name, this.form_params[key].value);
      });

      return params;
    },
    setParamErrors(responseData) {
      if (responseData.errors) {
        this.resetErrors();
        Object.keys(responseData.errors).forEach(key => {
          if (key in this.form_params) {
            this.$set(this.form_params[key], 'errors', responseData.errors[key]);
          }
        });
      }
    },
    resetErrors() {
      Object.keys(this.form_params).forEach(key => {
        this.$set(this.form_params[key], 'errors', []);
      });
    },
  },
  components: {
    FormInput,
  },
};
</script>