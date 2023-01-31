<template>
  <div>
    <form @submit.prevent="submitForm">
     <div class="form-div" v-for="param in [form_params.name]" :key="param.id">
        <FormInput
          :id="param.id"
          :name="param.name"
          :type="param.type"
          :title="param.title"
          :placeholder="param.placeholder"
          :label_description="param.label_description"
          :errors="param.errors"
          v-model="param.value"
        ></FormInput>
      </div>

      <div class="pt-3"></div>

      <div class="form-div" v-for="param in [form_params.email, form_params.email_confirmation]" :key="param.id">
        <FormInput
          :id="param.id"
          :name="param.name"
          :type="param.type"
          :title="param.title"
          :placeholder="param.placeholder"
          :label_description="param.label_description"
          :no_copy="param.no_copy"
          :errors="param.errors"
          v-model="param.value"
        ></FormInput>
      </div>

      <div class="pt-3"></div>

      <div class="form-div" v-for="param in [form_params.password, form_params.password_confirmation]" :key="param.id">
        <FormInput
          :id="param.id"
          :name="param.name"
          :type="param.type"
          :title="param.title"
          :placeholder="param.placeholder"
          :label_description="param.label_description"
          :errors="param.errors"
          v-model="param.value"
        ></FormInput>
      </div>

      <button type="submit" class="btn-send mt-5">登録</button>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import FormInput from "js/components/form/FormInput.vue";

export default {
  data() {
    return {
      form_params: {
        name: {
          id: "name",
          name: "name",
          type: "text",
          title: "事業者名",
          value: "",
          placeholder: "",
          errors: [],
        },
        email: {
          id: "email",
          name: "email",
          type: "email",
          title: "メールアドレス",
          value: "",
          no_copy: true,
          errors: [],
        },
        email_confirmation: {
          id: "email_confirmation",
          name: "email_confirmation",
          type: "email",
          title: "メールアドレス（確認用）",
          value: "",
          no_copy: true,
          errors: [],
        },
        password: {
          id: "password",
          name: "password",
          type: "password",
          title: "パスワード",
          value: "",
          placeholder: "",
          label_description: "※8〜12の英数字で入力してください",
          errors: [],
        },
        password_confirmation: {
          id: "password_confirmation",
          name: "password_confirmation",
          type: "password",
          title: "パスワード（確認用）",
          value: "",
          placeholder: "",
          label_description: "※コビーをせず入力してください",
          errors: [],
        },
      },
    };
  },
  methods: {
    submitForm() {
      axios.post(Api.entry, this.getFormParams()).then(response => {
        location.href = response.data.next;
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