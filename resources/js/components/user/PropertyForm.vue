<template>
  <div class="form-input-align-right">
    <form id="form form-input-align-right" @submit.prevent="submitForm">
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

      <div class="row mt-3">
        <h4 class="col-md-12">物件画像</h4>
      </div>

      <div v-for="(param, key) in image_files" :key="key">
        <small v-for="errorText in param.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>

      <div class="row">
        <div v-for="(param, key) in image_files" :key="key" class="col-md-4 mb-3 col-property-image">
          <div class="card">
            <div v-if="param.src.length" class="top-right" @click="removeImage(param.name)">
              <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center mypage-property-image" :style="{ backgroundImage: 'url(' + param.src + ')' }" @click="onClick(param.name)">
              <h5 v-show="!param.src.length" class="card-title">+</h5>
              <input type="file" style="display: none;" accept="image/gif,image/jpeg,image/png" :name="param.name" :ref="param.name" @change="onChange($event, param.name)">
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <template v-if="property_id == null">
          <button type="submit" class="btn btn-primary btn-md col-12">登録</button>
        </template>
        <template v-else>
          <button type="submit" class="btn btn-primary btn-md col-6">更新</button>
          <button type="button" class="btn btn-danger btn-md col-6" @click="onDelete">物件削除</button>
        </template>
      </div>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/property.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInputGroupText.vue";

export default {
  props: {
    property_id: {
      type: Number,
    },
    edit_complete: {
      type: Function,
    },
  },
  data() {
    return {
      form_params: {
        name: {
          id: "name",
          name: "name",
          type: "text",
          prepend: "物件名",
          value: "",
          placeholder: "",
          errors: [],
        },
        address: {
          id: "address",
          name: "address",
          type: "text",
          prepend: "住所",
          value: "",
          placeholder: "",
          errors: [],
        },
        area: {
          id: "area",
          name: "area",
          type: "number",
          prepend: "敷地面積",
          append: "㎡",
          value: "",
          placeholder: "",
          errors: [],
        },
        floors: {
          id: "floors",
          name: "floors",
          type: "number",
          prepend: "階数",
          append: "階",
          value: "",
          placeholder: "",
          errors: [],
        },
        age: {
          id: "age",
          name: "age",
          type: "number",
          prepend: "築年数",
          append: "年",
          value: "",
          placeholder: "",
          errors: [],
        },
        type: {
          id: "type",
          name: "type",
          type: "select",
          prepend: "物件の種類",
          value: "0",
          options: [],
          placeholder: "　",
          errors: [],
        },
        type_wall: {
          id: "type_wall",
          name: "type_wall",
          type: "select",
          prepend: "外壁の種類",
          value: "0",
          options: [],
          placeholder: "　",
          errors: [],
        },
        type_roof: {
          id: "type_roof",
          name: "type_roof",
          type: "select",
          prepend: "屋根の種類",
          value: "0",
          options: [],
          placeholder: "　",
          errors: [],
        },
        repainting_wall: {
          id: "repainting_wall",
          name: "repainting_wall",
          type: "number",
          prepend: "前回の外壁塗り替え",
          append: "年前",
          value: "",
          placeholder: "",
          errors: [],
        },
        repainting_roof: {
          id: "repainting_roof",
          name: "repainting_roof",
          type: "number",
          prepend: "前回の屋根塗り替え",
          append: "年前",
          value: "",
          placeholder: "",
          errors: [],
        },
        budget: {
          id: "budget",
          name: "budget",
          type: "number",
          prepend: "工事予算額",
          append: "万円",
          value: "",
          placeholder: "",
          errors: [],
        },
      },
      image_files: {
        image_file1: {
          name: "image_file1",
          src_name: "image1",
          src: '',
          del_name: "del_flg1",
          del_flg: false,
          errors: [],
        },
        image_file2: {
          name: "image_file2",
          src_name: "image2",
          src: '',
          del_name: "del_flg2",
          del_flg: false,
          errors: [],
        },
        image_file3: {
          name: "image_file3",
          src_name: "image3",
          src: '',
          del_name: "del_flg3",
          del_flg: false,
          errors: [],
        },
        image_file4: {
          name: "image_file4",
          src_name: "image4",
          src: '',
          del_name: "del_flg4",
          del_flg: false,
          errors: [],
        },
        image_file5: {
          name: "image_file5",
          src_name: "image5",
          src: '',
          del_name: "del_flg5",
          del_flg: false,
          errors: [],
        },
        image_file6: {
          name: "image_file6",
          src_name: "image6",
          src: '',
          del_name: "del_flg6",
          del_flg: false,
          errors: [],
        },
      },
    };
  },
  computed: {
    ...mapGetters('Config', [
      'property',
      'roof',
      'wall',
    ]),
    ...mapGetters('Property', [
      'findProperty',
    ]),
    apiUrl() {
      return this.property_id == null ? Api.store : Api.update + this.property_id;
    },
  },
  mounted() {
    this.$store.dispatch('Config/load').then(() => {
      this.form_params.type.options = this.property;
      this.form_params.type_wall.options = this.roof;
      this.form_params.type_roof.options = this.wall;
    }).finally(() => {
      if (this.property_id != null) {
        this.setFormParams(this.findProperty(this.property_id));
      }
    });
  },
  methods: {
    onClick(name) {
      this.$refs[name][0].click();
    },
    onChange(e, name) {
      const files = e.target.files ? e.target.files : e.dataTransfer.files;

      if (files[0]) {
        this.renderImage(files[0], name);
      }
    },
    renderImage(file, name) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.image_files[name].src = e.target.result;
        this.image_files[name].del_flg = false;
      };

      reader.readAsDataURL(file);
    },
    removeImage(name) {
      this.$refs[name][0].value = null;
      this.image_files[name].src = '';
      this.image_files[name].del_flg = true;
    },
    onDelete() {
      axios.post(Api.destroy + this.property_id).then(response => {
        this.resetErrors();
        this.edit_complete();
      }).catch(error => {
        console.log(error);
      });
    },
    submitForm() {
      axios.post(this.apiUrl, this.getFormParams(), {
        headers: {
          'content-type': 'multipart/form-data',
        },
      }).then(response => {
        this.resetErrors();
        this.edit_complete();
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
        if (this.$refs[this.image_files[key].name][0].value) {
          params.append(this.image_files[key].name, this.$refs[this.image_files[key].name][0].files[0]);
        } else if (this.image_files[key].del_flg) {
          params.append(this.image_files[key].del_name, this.image_files[key].del_flg);
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

        if (key in this.image_files && responseData[key]?.length) {
          const name = this.image_files[key].src_name;
          const src = responseData[name];
          this.$set(this.image_files[key], 'src', src);
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
  },
};
</script>