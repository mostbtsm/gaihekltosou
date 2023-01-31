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
    <div class="form-group" style="margin-bottom:10px;">
      <div class="col-12">
        <label for="kbn">会員区分</label>
      </div>
      <div v-if="confirm" class="col-12" style="text-align :center; color: #318cd2; padding: 10px;">
        {{ (userType == 0 ? '個人' : (userType == 1 ? '企業' : '非会員')) }}
      </div>
      <div v-else class="col-12" style="text-align:center;">
        <input type="radio" id="kbn_0" name="kbn" value="0" v-model="userType" />個人
        <input type="radio" id="kbn_1" name="kbn" value="1" v-model="userType" />企業
        <input type="radio" id="kbn_2" name="kbn" value="2" v-model="userType" />非会員
      </div>
    </div>
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
import { Api } from "js/route/common.js";
import FormInput from "js/components/form/FormInput.vue";

export default {
  data() {
    return {
      confirm: false,
      success: false,
      form_params: {
        name: {
          id: "name",
          name: "name",
          type: "text",
          title: "お名前・会社名",
          value: "",
          placeholder: "お名前又は会社名",
          errors: [],
        },
        email: {
          id: "email",
          name: "email",
          type: "email",
          title: "メールアドレス",
          value: "",
          placeholder: "sample@example.co.jp",
          errors: [],
        },
        contents: {
          id: "contents",
          name: "contents",
          type: "textarea",
          title: "お問合せ内容",
          value: "",
          rows: "8",
          placeholder: "ログイン操作に失敗する\n登録したメールアドレスを忘れた　等",
          errors: [],
        },
      },
      userType: 0,
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
      params.append('userType', this.userType);

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