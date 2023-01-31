<template>
  <div>
    <form id="form" @submit.prevent="submitForm" method="post">
      <input type="hidden" name="_token" :value="csrf">
      <FormInput v-for="(param, key) in form_params" :key="key"
        :id="param.id"
        :name="param.name"
        :type="param.type"
        :title="param.title"
        :placeholder="param.placeholder"
        :errors="param.errors"
        v-model="param.value"
      ></FormInput>
      <button type="submit" class="btn-send mt-5">ログイン</button>
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
        email: {
          id: "email",
          name: "email",
          type: "email",
          title: "メールアドレス",
          value: "",
          placeholder: "",
          errors: [],
        },
        password: {
          id: "password",
          name: "password",
          type: "password",
          title: "パスワード",
          value: "",
          placeholder: "",
          errors: [],
        },
      },
    };
  },
  computed: {
    csrf() {
      return document.head.querySelector('meta[name="csrf-token"]').content;
    }
  },
  methods: {
    submitForm() {
      axios.post(Api.login, this.getFormParams()).then(response => {
        $('#form').submit();
      }).catch(error => {
        if (error.response) {
          if (error.response.status == 422) {
            this.setParamErrors(error.response.data);
          } else if (error.response.status == 401) {
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