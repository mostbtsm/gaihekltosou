<template>
<div v-if="success" class="setting-complete">
  <div class="message-title">退会を完了致しました</div>
  <div class="message-content">ご利用ありがとう<br/>ございました</div>
</div>

<div v-else class="withdraw-form">
  <form  d="form" @submit.prevent="submitForm">
    <div class="method-title">退会する</div>
    <div class="message-content">退会すると全ての登録内容が削除されます<br/>本当に削除して良いですか</div>

    <FormInput v-for="(param, key) in form_params" :key="key"
      :id="param.id"
      :name="param.name"
      :type="param.type"
      :title="param.title"
      :placeholder="param.placeholder"
      :errors="param.errors"
      v-model="param.value"
    ></FormInput>

    <button @click="back()" v-if="confirm" type="buttoon" class="btn-send">戻る</button>
    <button type="submit" class="btn-send">{{ confirm ? "送信" : "確認" }}</button>
  </form>
</div>
</template>

<script>
import { Api } from "js/route/painter.js";
import FormInput from "js/components/form/FormInput.vue";

export default {
  data() {
    return {
      confirm: false,
      success: false,
      form_params: {
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
  methods: {
    submitForm() {
      axios.post(Api.withdraw, this.getFormParams()).then(response => {
        this.resetErrors();
        if (this.confirm) {
          this.success = true;

          window.setTimeout(() => {
              location.href = response.data.next;
          }, 5000);
        } else {
          this.confirm = true;
        }
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

      params.append('confirmed', this.confirm ? 1 : 0);

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
    back() {
      this.confirm = false;
    },
  },
  components: {
    FormInput,
  },
};
</script>