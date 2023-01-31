<template>
<div class="form-container">
  <form id="form" @submit.prevent="submitForm" method="post">
    <div class="title text-blue text-center">
        <h4 style="font-weight:800">{{ painter_name }}との契約が<br>完了いたしました<br><br>
        評価へのご協力をお願いします</h4>
    </div>
    <div class="star">
        <StarRatingEvaluate :styleStarHeight=50 :styleStarWidth=50  :isIndicatorActive="true" @catchMessage="displayMessage"></StarRatingEvaluate>
    </div>

    <div class="evaluation">
      <FormInput v-for="(param, key) in form_params" :key="key"
        :id="param.id"
        :name="param.name"
        :type="param.type"
        :title="param.title"
        :placeholder="param.placeholder"
        :prepend="param.prepend"
        :append="param.append"
        :options="param.options"
        :errors="param.errors"
        v-model="param.value"
      ></FormInput>
    </div>

    <div class="evaluation">
        <h6 style="font-weight:600">
            口コミ評価
        </h6>
          <FormInput v-for="(param, key) in form_params2" :key="key"
            :id="param.id"
            :name="param.name"
            :type="param.type"
            :title="param.title"
            :placeholder="param.placeholder"
            :prepend="param.prepend"
            :append="param.append"
            :options="param.options"
            :errors="param.errors"
            v-model="param.value"
          ></FormInput>

        <button type="submit" class="red_btn">送信</button>
    </div>
  </form>
</div>
</template>

<script>
import { Api } from "js/route/user.js";
import FormInput from "js/components/form/FormInputGroupText.vue";
import StarRatingEvaluate from 'js/components/user/StarRatingEvaluate.vue';
export default {
  props: ['evaluation_id', 'painter_name'],
  data() {
    return {
      //レート
      rate: 0,

      form_params: {
        name: {
          id: "name",
          name: "name",
          type: "text",
          prepend: "名前",
          value: "",
          placeholder: "",
          errors: [],
        },
      },
      form_params2: {
        evaluation: {
          id: "evaluation",
          name: "evaluation",
          type: "textarea",
          prepend: "口コミ評価",
          placeholder: "終始において迅速、丁寧な対応をして いただき、安心してお任せできる業者 さんでした等…",
          value: "",
          placeholder: "",
          errors: [],
        },
      },
    };
  },
  methods: {
    displayMessage(rating){
       this.rate = rating;
    },
   
    submitForm() {
      axios.post(Api.evaluationupdate, this.getFormParams()).then(response => {
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
      Object.keys(this.form_params2).forEach(key => {
        params.append(this.form_params2[key].name, this.form_params2[key].value);
      });

      params.append('correspondence', this.rate);
      params.append('id', this.evaluation_id);

      return params;
    },
    setParamErrors(responseData) {
      if (responseData.errors) {
        this.resetErrors();
        Object.keys(responseData.errors).forEach(key => {
          if (key in this.form_params) {
            this.$set(this.form_params[key], 'errors', responseData.errors[key]);
          }
          if (key in this.form_params2) {
            this.$set(this.form_params2[key], 'errors', responseData.errors[key]);
          }
        });
      }
    },
    resetErrors() {
      Object.keys(this.form_params).forEach(key => {
        this.$set(this.form_params[key], 'errors', []);
      });
      Object.keys(this.form_params2).forEach(key => {
        this.$set(this.form_params2[key], 'errors', []);
      });
    },
  },
  components: {
    FormInput,
    StarRatingEvaluate,
  },
};
</script>