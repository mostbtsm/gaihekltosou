<template>
  <div>
    <form id="form" class="mt-3" @submit.prevent="submitForm">
      <div class="form-title">登録画像</div>

      <div class="row mb-3">
        <div class="col">
          <div class="form-text">プロフィールページ上部にメイン画像とともにスライドで表示されます</div>
        </div>
      </div>

      <div v-for="(param, key) in image_files" :key="key">
        <small v-for="errorText in param.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>

      <div class="row">
        <div v-for="(param, key) in image_files" :key="key" class="col-md-6 mb-3 image-card-wrraper-default">
          <ImageFileCard
            :name="param.name"
            :src.sync="param.src"
            :blob.sync="param.blob"
            :mime_type="param.mime_type"
            :del_flg.sync="param.del_flg"
          ></ImageFileCard>
        </div>
      </div>

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

      <div class="form-div">
        <div class="form-group">
          <label for="category">{{ categories.title }}</label>
          <Multiselect
            :options="categories.options"
            v-model="categories.value"
            label="name"
            track-by="id"
            tag-placeholder=""
            placeholder=""
            :multiple="true"
            :taggable="true"
            :searchable="false"
            :show-labels="false">
          </Multiselect>
          <small v-for="errorText in categories.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
        </div>
      </div>

      <button type="submit" class="btn-send mt-5 mb-5">編集完了</button>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInput.vue";
import ImageFileCard from "js/components/form/ImageFileCard.vue";
import Multiselect from "vue-multiselect";

export default {
  data() {
    return {
      image_files: {
        image_file1: {
          name: "image_file1",
          src: '',
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg1",
          del_flg: false,
          errors: [],
        },
        image_file2: {
          name: "image_file2",
          src: '',
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg2",
          del_flg: false,
          errors: [],
        },
        image_file3: {
          name: "image_file3",
          src: '',
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg3",
          del_flg: false,
          errors: [],
        },
        image_file4: {
          name: "image_file4",
          src: '',
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg4",
          del_flg: false,
          errors: [],
        },
      },

      form_params: {
        catch_copy: {
          id: "catch_copy",
          name: "catch_copy",
          type: "textarea",
          label:"メインコピー",
          value: "",
          rows: "5",
          placeholder: "例:東海地区最大9店舗で展開する塗替え道場です。\nお客様の笑顔のために心を込めて施工させていただきます!",
          errors: [],
        },
        pr_copy: {
          id: "pr_copy",
          name: "pr_copy",
          type: "textarea",
          label:"PRコピー",
          value: "",
          rows: "8",
          placeholder: "例:完全自社施工が可能な技術力、お客様のニーズに合った塗装や施工方法を提案する提案力、デザイン性豊かなカラーシミュレーションによるデザインカといった当社を強みを生かして、お客様に満足していただける塗装リフォームサービスを提供しています。",
          errors: [],
        },
        name: {
          id: "name",
          name: "name",
          type: "text",
          label:"会社概要",
          title: "名称",
          value: "",
          placeholder: "",
          errors: [],
        },
        ceo_name: {
          id: "ceo_name",
          name: "ceo_name",
          type: "text",
          title: "代表者",
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
        email: {
          id: "email",
          name: "email",
          type: "email",
          title: "メールアドレス",
          value: "",
          placeholder: "",
          label_description: "※プロフィールには表示されません",
          errors: [],
        },
        tel: {
          id: "tel",
          name: "tel",
          type: "text",
          title: "TEL",
          value: "",
          placeholder: "",
          errors: [],
        },
        fax: {
          id: "fax",
          name: "fax",
          type: "text",
          title: "FAX",
          value: "",
          placeholder: "",
          errors: [],
        },
        established: {
          id: "established",
          name: "established",
          type: "select",
          title: "設立",
          value: "2000",
          options: [],
          placeholder: "",
          errors: [],
        },
        type: {
          id: "type",
          name: "type",
          type: "text",
          title: "事業内容",
          value: "",
          placeholder: "",
          errors: [],
        },
        organization: {
          id: "organization",
          name: "organization",
          type: "text",
          title: "加盟団体",
          value: "",
          placeholder: "",
          errors: [],
        },
        sales: {
          id: "sales",
          name: "sales",
          type: "select",
          title: "年間売上",
          value: "",
          options: [],
          placeholder: "",
          errors: [],
        },
      },

      categories: {
        id: "category",
        name: "category",
        type: "select",
        title: "対応施工内容",
        value: [],
        options: [],
        errors: [],
      },
    };
  },
  computed: {
    ...mapGetters('Config', [
      'prefecture',
      'sales',
      'category',
    ]),
  },
  created() {
    this.form_params.established.options = this.createEstablished();

    this.$store.dispatch('Config/load').then(() => {
      var i = 0;

      this.form_params.prefectures.options = this.prefecture;
      this.form_params.sales.options = this.sales;

      Object.keys(this.category).forEach(key => {
        this.categories.options.push({ id: i++, value: key, name: this.category[key] })
      });
    });
  },
  mounted() {
    axios.get(Api.show).then(response => {
      if (response.data) {
        this.setFormParams(response.data);
      }
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    createEstablished() {
      let options = {};
      const year = new Date().getFullYear();

      for (let i = 1000; i <= year; i++) {
        options[String(i)] = String(i) + '年';
      }

      return options;
    },

    submitForm() {
      axios.post(Api.update, this.getFormParams(), {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }).then(response => {
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
      const params = new FormData();
      Object.keys(this.form_params).forEach(key => {
        if (this.form_params[key].value?.length) {
          params.append(this.form_params[key].name, this.form_params[key].value);
        }
      });

      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].blob) {
          params.append(this.image_files[key].name, new File([this.image_files[key].blob], this.image_files[key].name, { type: this.image_files[key].mime_type, }));
        } else if (this.image_files[key].del_flg) {
          params.append(this.image_files[key].del_name, this.image_files[key].del_flg);
        }
      });

      this.categories.value.forEach(obj => {
        params.append(this.categories.name + '[' + obj.id +']', obj.value);
      });

      return params;
    },
    setFormParams(responseData) {
      Object.keys(responseData).forEach(key => {
        if (key in this.form_params) {
          const value = Number.isFinite(responseData[key]) ? String(responseData[key]) : responseData[key];

          if (value != null && value.length > 0) {
            this.$set(this.form_params[key], 'value', value);
          }
        }

        if (key in this.image_files && responseData[key] && responseData[key]?.length) {
          this.$set(this.image_files[key], 'src', responseData[key]);
        }

        if (key == 'category' && responseData[key]) {
          const values = responseData[key].split(',');

          values.forEach(value => {
            const option = this.categories.options.find(elem => elem.value == value);
            if (option) {
              this.categories.value.push(option);
            }
          });
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

          if (key in this.image_files) {
            this.$set(this.image_files[key], 'errors', responseData.errors[key]);
          }
        });
      }
    },
    resetErrors() {
      Object.keys(this.form_params).forEach(key => {
        this.$set(this.form_params[key], 'errors', []);
      });
      Object.keys(this.image_files).forEach(key => {
        this.$set(this.image_files[key], 'errors', []);
      });
    },
  },
  components: {
    FormInput,
    ImageFileCard,
    Multiselect,
  },
};
</script>