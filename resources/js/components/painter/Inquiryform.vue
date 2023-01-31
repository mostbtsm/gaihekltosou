<template>
<div v-if="success" class="inquiry-complete">
    <div class="message-title">お問合せの受付を<br/>完了致しました</div>
    <div class="message-content">後日メールにて<br/>返答させていただきます<br/>のでお待ちください</div>
</div>

<div v-else class="inquiry-form">
  <div class="inquiry-confirm" v-show="confirm">
    <div class="message-content">まだお問合せは完了していません<br/>下記内容を確認のうえ、「送信」を選択してください</div>
  </div>

  <form id="form" @submit.prevent="submitForm">
    <FormInput v-for="(param, key) in form_params" :key="key"
      :id="param.id"
      :name="param.name"
      :type="param.type"
      :title="param.title"
      :rows="param.rows"
      :placeholder="param.placeholder"
      :disabled="confirm"
      :errors="param.errors"
      v-model="param.value"
    ></FormInput>
    <button @click="back()" v-if="confirm" type="buttoon" class="btn-send">戻る</button>
    <button type="submit" class="btn-send">{{ confirm ? "送信" : "確認 "}}</button>
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
        contents: {
          id: "contents",
          name: "contents",
          type: "textarea",
          title: "お問合せ内容",
          value: "",
          rows: "8",
          placeholder: "料金に関して詳しく知りたい\n登録した画像を消したい　等",
          errors: [],
        },
      },
    };
  },
  methods: {
    submitForm() {
      axios.post(Api.inquiry, this.getFormParams()).then(response => {
        this.resetErrors();
        if (this.confirm) {
          this.success = true;
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