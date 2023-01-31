<template>
  <div>
    <form id="form" class="mt-3" @submit.prevent="submitForm">
      <div class="form-div" v-for="(param, key) in form_params" :key="key">
        <div class="form-title">{{ param.label }}</div>
        <FormInput
          :id="param.id"
          :name="param.name"
          :type="param.type"
          :title="param.title"
          :rows="param.rows"
          :placeholder="param.placeholder"
          :label_description="param.label_description"
          :options="param.options"
          :errors="param.errors"
          v-model="param.value"
        ></FormInput>
      </div>

      <button type="submit" class="btn-send mt-5 mb-5">編集完了</button>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/user.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInput.vue";

export default {
  data() {
    return {
      form_params: {
        nickname: {
          id: "nickname",
          name: "nickname",
          type: "text",
          title: "ニックネーム",
          value: "",
          placeholder: "",
          errors: [],
        },
        name1: {
          id: "name1",
          name: "name1",
          type: "text",
          title: "姓",
          value: "",
          placeholder: "",
          errors: [],
        },
        name2: {
          id: "name2",
          name: "name2",
          type: "text",
          title: "名",
          value: "",
          placeholder: "",
          errors: [],
        },
        kana1: {
          id: "kana1",
          name: "kana1",
          type: "text",
          title: "姓（カナ）",
          value: "",
          placeholder: "",
          errors: [],
        },
        kana2: {
          id: "kana2",
          name: "kana2",
          type: "text",
          title: "名（カナ）",
          value: "",
          placeholder: "",
          errors: [],
        },
        postal: {
          id: "postal",
          name: "postal",
          type: "text",
          title: "郵便番号",
          value: "",
          placeholder: "000-0000",
          errors: [],
        },
        prefectures: {
          id: "prefectures",
          name: "prefectures",
          type: "select",
          title: "都道府県",
          value: "",
          options: [],
          placeholder: "　",
          errors: [],
        },
        city: {
          id: "city",
          name: "city",
          type: "text",
          title: "市町区村",
          value: "",
          placeholder: "",
          errors: [],
        },
        address1: {
          id: "address1",
          name: "address1",
          type: "text",
          title: "住所1",
          value: "",
          placeholder: "",
          errors: [],
        },
        address2: {
          id: "address2",
          name: "address2",
          type: "text",
          title: "住所2",
          value: "",
          placeholder: "",
          errors: [],
        },
        tel: {
          id: "tel",
          name: "tel",
          type: "text",
          title: "電話番号",
          value: "",
          placeholder: "000-0000-0000",
          errors: [],
        },
        mobile: {
          id: "mobile",
          name: "mobile",
          type: "text",
          title: "携帯番号",
          value: "",
          placeholder: "000-0000-0000",
          errors: [],
        },
        email: {
          id: "email",
          name: "email",
          type: "email",
          title: "メールアドレス",
          value: "",
          label_description: "※プロフィールには表示されません",
          placeholder: "",
          errors: [],
        },
      },
    };
  },
  computed: {
    ...mapGetters('Config', [
      'prefecture',
    ]),
  },
  mounted() {
    this.$store.dispatch('Config/load').then(() => {
      this.form_params.prefectures.options = this.prefecture;
    });
    axios.get(Api.show).then(response => {
      if (response.data) {
        this.setFormParams(response.data);
      }
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    submitForm() {
      axios.post(Api.update, this.getFormParams()).then(response => {
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
        if (this.form_params[key].value?.length) {
          params.append(this.form_params[key].name, this.form_params[key].value);
        }
      });

      return params;
    },
    setFormParams(responseData) {
      Object.keys(responseData).forEach(key => {
        if (key in this.form_params) {
          const value = Number.isFinite(responseData[key]) ? String(responseData[key]) : responseData[key];
          this.$set(this.form_params[key], 'value', value);
        }
      });
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