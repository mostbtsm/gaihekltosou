<template>
  <form id="form" @submit.prevent="submitForm">
    <FormInput
      :id="form_params.title.id"
      :name="form_params.title.name"
      :type="form_params.title.type"
      :title="form_params.title.title"
      :placeholder="form_params.title.placeholder"
      :errors="form_params.title.errors"
      v-model="form_params.title.value">
    </FormInput>

    <FormInput
      :id="form_params.address.id"
      :name="form_params.address.name"
      :type="form_params.address.type"
      :title="form_params.address.title"
      :placeholder="form_params.address.placeholder"
      :errors="form_params.address.errors"
      v-model="form_params.address.value">
    </FormInput>

    <div class="form-group row">
      <label class="col-sm-2 col-form-label">{{ form_params.category.title }}</label>
      <div class="col-sm-10">
        <Multiselect
          :options="form_params.category.options"
          v-model="form_params.category.value"
          label="name"
          track-by="id"
          tag-placeholder=""
          placeholder=""
          :multiple="true"
          :taggable="true"
          :searchable="false"
          :show-labels="false">
        </Multiselect>
        <small v-for="errorText in form_params.category.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>
    </div>

    <FormInput
      :id="form_params.property_type.id"
      :name="form_params.property_type.name"
      :type="form_params.property_type.type"
      :title="form_params.property_type.title"
      :placeholder="form_params.property_type.placeholder"
      :options="form_params.property_type.options"
      :errors="form_params.property_type.errors"
      v-model="form_params.property_type.value">
    </FormInput>

    <div class="control-group warranty-group">
      <label class="group-label">保証内容</label>

      <FormInput
        :id="form_params.warranty_value1.id"
        :name="form_params.warranty_value1.name"
        :type="form_params.warranty_value1.type"
        :title="form_params.warranty_value1.title"
        :placeholder="form_params.warranty_value1.placeholder"
        :options="form_params.warranty_value1.options"
        :errors="form_params.warranty_value1.errors"
        v-model="form_params.warranty_value1.value">

      </FormInput>
      <FormInput
        :id="form_params.warranty_value2.id"
        :name="form_params.warranty_value2.name"
        :type="form_params.warranty_value2.type"
        :title="form_params.warranty_value2.title"
        :placeholder="form_params.warranty_value2.placeholder"
        :options="form_params.warranty_value2.options"
        :errors="form_params.warranty_value2.errors"
        v-model="form_params.warranty_value2.value">

      </FormInput>
      <FormInput
        :id="form_params.warranty_value3.id"
        :name="form_params.warranty_value3.name"
        :type="form_params.warranty_value3.type"
        :title="form_params.warranty_value3.title"
        :placeholder="form_params.warranty_value3.placeholder"
        :options="form_params.warranty_value3.options"
        :errors="form_params.warranty_value3.errors"
        v-model="form_params.warranty_value3.value">

      </FormInput>
      <FormInput
        :id="form_params.warranty_value4.id"
        :name="form_params.warranty_value4.name"
        :type="form_params.warranty_value4.type"
        :title="form_params.warranty_value4.title"
        :placeholder="form_params.warranty_value4.placeholder"
        :options="form_params.warranty_value4.options"
        :errors="form_params.warranty_value4.errors"
        v-model="form_params.warranty_value4.value">

      </FormInput>
      <FormInput
        :id="form_params.warranty_value5.id"
        :name="form_params.warranty_value5.name"
        :type="form_params.warranty_value5.type"
        :title="form_params.warranty_value5.title"
        :placeholder="form_params.warranty_value5.placeholder"
        :options="form_params.warranty_value5.options"
        :errors="form_params.warranty_value5.errors"
        v-model="form_params.warranty_value5.value">
        <template v-slot:label>
          <div class="col-sm-2 mb-3">
            <TextInput
              :id="form_params.warranty_name5.id"
              :name="form_params.warranty_name5.name"
              :type="form_params.warranty_name5.type"
              :title="form_params.warranty_name5.title"
              :placeholder="form_params.warranty_name5.placeholder"
              :errors="form_params.warranty_name5.errors"
              v-model="form_params.warranty_name5.value">
            </TextInput>
          </div>
        </template>
      </FormInput>
    </div>

    <FormInput
      :id="form_params.amount.id"
      :name="form_params.amount.name"
      :type="form_params.amount.type"
      :title="form_params.amount.title"
      :placeholder="form_params.amount.placeholder"
      :options="form_params.amount.options"
      :errors="form_params.amount.errors"
      v-model="form_params.amount.value">
    </FormInput>

    <div class="form-group row">
      <label class="col-sm-2 col-form-label">完工日</label>
      <div class="col-sm-10">
        <div class="d-flex date-group">
          <SelectInput
            :id="form_params.complete_date_year.id"
            :name="form_params.complete_date_year.name"
            :type="form_params.complete_date_year.type"
            :placeholder="form_params.complete_date_year.placeholder"
            :options="form_params.complete_date_year.options"
            v-model="form_params.complete_date_year.value">
          </SelectInput>
          <label>年</label>

          <SelectInput
            :id="form_params.complete_date_month.id"
            :name="form_params.complete_date_month.name"
            :type="form_params.complete_date_month.type"
            :placeholder="form_params.complete_date_month.placeholder"
            :options="form_params.complete_date_month.options"
            v-model="form_params.complete_date_month.value">
          </SelectInput>
          <label>月</label>
        </div>
        <small v-for="errorText in form_params.complete_date_year.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
        <small v-for="errorText in form_params.complete_date_month.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>
    </div>

    <FormInput
      :id="form_params.period.id"
      :name="form_params.period.name"
      :type="form_params.period.type"
      :title="form_params.period.title"
      :placeholder="form_params.period.placeholder"
      :options="form_params.period.options"
      :errors="form_params.period.errors"
      v-model="form_params.period.value">
    </FormInput>

    <div class="control-group">
      <label class="group-label"> 写真の追加</label>

      <div v-for="(param, key) in image_files" :key="key">
        <small v-for="errorText in param.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>

      <div class="row picture-area">
        <div v-for="(param, key) in image_files" :key="key" class="col-md-4 mb-3">
          <label>{{ param.title }}</label>
          <ImageFileCard
            :name="param.name"
            :src.sync="param.src"
            :blob.sync="param.blob"
            :mime_type="param.mime_type"
            :del_flg.sync="param.del_flg"
          ></ImageFileCard>
        </div>
      </div>
    </div>

    <div class="control-group">
      <label class="group-label">{{ form_params.comment.title }}</label>

      <div class="form-group row">
        <div class="col-sm-12">
          <TextArea
            :id="form_params.comment.id"
            :name="form_params.comment.name"
            :type="form_params.comment.type"
            :placeholder="form_params.comment.placeholder"
            :rows="form_params.comment.rows"
            v-model="form_params.comment.value">
          </TextArea>
          <small v-for="errorText in form_params.comment.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
        </div>
      </div>
    </div>

    <div class="button-div">
      <button type="submit" class="btn-confirm-edit">登録する</button>
    </div>

    <button v-if="this.example_id != null" type="button" class="btn-delete mt-5" @click="clickDeleteBtn">施工事例を削除する</button>
  </form>
</template>

<script>
import { Api } from "js/route/painter.js";
import { mapGetters } from "vuex";
import FormInput from "js/components/form/FormInputHorizontal.vue";
import TextInput from "js/components/form/TextInput.vue";
import TextArea from "js/components/form/TextArea.vue";
import SelectInput from "js/components/form/SelectInput.vue";
import Multiselect from "vue-multiselect";
import ImageFileCard from "js/components/form/ImageFileCard.vue";

export default {
  props: {
    example_id: {
      type: Number,
    },
  },
  data() {
    return {
      form_params: {
        title: {
          id: "title",
          name: "title",
          type: "text",
          title: "案件名",
          value: "",
          placeholder: "戸建 M様",
          errors: [],
        },
        address: {
          id: "address",
          name: "address",
          type: "text",
          title: "場所",
          value: "",
          placeholder: "市区町村までを入力",
          errors: [],
        },
        category: {
          id: "category",
          name: "category",
          type: "select",
          title: "工事内容",
          value: [],
          options: [],
          errors: [],
        },
        property_type: {
          id: "property_type",
          name: "property_type",
          type: "select",
          title: "建物",
          value: "",
          options: [],
          errors: [],
        },
        warranty_value1: {
          id: "warranty_value1",
          name: "warranty_value1",
          type: "select",
          title: "外壁塗装",
          value: "",
          options: [],
          errors: [],
        },
        warranty_value2: {
          id: "warranty_value2",
          name: "warranty_value2",
          type: "select",
          title: "屋根塗装",
          value: "",
          options: [],
          errors: [],
        },
        warranty_value3: {
          id: "warranty_value3",
          name: "warranty_value3",
          type: "select",
          title: "屋上防水",
          value: "",
          options: [],
          errors: [],
        },
        warranty_value4: {
          id: "warranty_value4",
          name: "warranty_value4",
          type: "select",
          title: "ベランダ防水",
          value: "",
          options: [],
          errors: [],
        },
        warranty_name5: {
          id: "warranty_name5",
          name: "warranty_name5",
          type: "text",
          title: "",
          placeholder: "その他",
          value: "",
          errors: [],
        },
        warranty_value5: {
          id: "warranty_value5",
          name: "warranty_value5",
          type: "select",
          title: "",
          value: "",
          options: [],
          errors: [],
        },
        amount: {
          id: "amount",
          name: "amount",
          type: "select",
          title: "金額",
          value: "",
          options: [],
          errors: [],
        },
        period: {
          id: "period",
          name: "period",
          type: "select",
          title: "工事期間",
          value: "",
          options: [],
          errors: [],
        },
        complete_date_year: {
          id: "complete_date_year",
          name: "complete_date_year",
          type: "select",
          title: "",
          value: "",
          options: [],
          errors: [],
        },
        complete_date_month: {
          id: "complete_date_month",
          name: "complete_date_month",
          type: "select",
          title: "",
          value: "",
          options: {},
          errors: [],
        },
        comment: {
          id: "comment",
          name: "comment",
          type: "textarea",
          title: "施工紹介",
          value: "",
          rows: "20",
          placeholder: "施工紹介コメントを入力",
          errors: [],
        },
      },

      image_files: {
        image_file1: {
          name: "image_file1",
          title: "外観",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg1",
          del_flg: false,
          errors: [],
        },
        image_file2: {
          name: "image_file2",
          title: "右側面",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg2",
          del_flg: false,
          errors: [],
        },
        image_file3: {
          name: "image_file3",
          title: "左側面",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg3",
          del_flg: false,
          errors: [],
        },
        image_file4: {
          name: "image_file4",
          title: "裏面",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg4",
          del_flg: false,
          errors: [],
        },
        image_file5: {
          name: "image_file5",
          title: "その他",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg5",
          del_flg: false,
          errors: [],
        },
        image_file6: {
          name: "image_file6",
          title: "その他",
          src: "",
          blob: null,
          mime_type: 'image/jpeg',
          del_name: "del_flg6",
          del_flg: false,
          errors: [],
        },
      },
    };
  },
  computed: {
    ...mapGetters('Example', [
      'findExample',
    ]),
    ...mapGetters('Config', [
      'category', 'property', 'warranty', 'amount', 'construction_period'
    ]),
  },
  created() {
    const today = new Date();

    this.$store.dispatch('Config/load').then(() => {
      this.form_params.property_type.options = this.property;
      this.form_params.warranty_value1.options = this.warranty;
      this.form_params.warranty_value2.options = this.warranty;
      this.form_params.warranty_value3.options = this.warranty;
      this.form_params.warranty_value4.options = this.warranty;
      this.form_params.warranty_value5.options = this.warranty;
      this.form_params.amount.options = this.amount;
      this.form_params.period.options = this.construction_period;
      this.form_params.complete_date_year.options = this.getYears();
      this.form_params.complete_date_month.options = this.getMonths();

      this.$nextTick(() => {
        this.form_params.complete_date_year.value = String(today.getFullYear());
        this.form_params.complete_date_month.value = String(today.getMonth() + 1);
      });

      Object.keys(this.category).forEach(key => {
        this.form_params.category.options.push({ id: key, value: key, name: this.category[key] })
      });
    });
  },
  mounted() {
    if (this.example_id != null) {
      this.$store.dispatch('Example/loadMyExample', this.example_id).then(() => {
        this.setFormParams(this.findExample(this.example_id));
      }).catch(error => {
        console.log(error);
      });
    }
  },
  methods: {
    getYears() {
      let years = {};
      const today = new Date();
      const goBackYears = 100;
      const currentYear = today.getFullYear();
      const startYear = currentYear - goBackYears;

      [...Array(goBackYears + 1).keys()].forEach(x => years[String(x + startYear)] = String(x + startYear));

      return years;
    },
    getMonths() {
      let months = {};
      [...Array(12).keys()].forEach(x => months[String(x + 1)] = String(x + 1));

      return months;
    },
    submitForm() {
      const url = this.example_id != null ? Api.example.id(this.example_id) : Api.example.index;
      const params = this.getFormParams();

      if (this.example_id != null) {
        params.append('_method', 'patch');
      }

      axios.post(url, params, {
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
        if (key == "category") {
          this.form_params[key].value.forEach(obj => {
            params.append(this.form_params[key].name + '[' + obj.id +']', obj.value);
          });
        } else if (this.form_params[key].value?.length) {
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

      return params;
    },
    setFormParams(responseData) {
      Object.keys(responseData).forEach(key => {
        const value = Number.isFinite(responseData[key]) ? String(responseData[key]) : responseData[key];

        if (key == 'category') {
          return;
        }

        if (key == 'categories') {
          value.forEach(val => {
            const option = this.form_params.category.options.find(elem => elem.value == val);
            if (option) {
              this.form_params.category.value.push(option);
            }
          });
          return;
        }

        if (key == 'complete_date_json') {
          this.$set(this.form_params.complete_date_year, 'value', value.year);
          this.$set(this.form_params.complete_date_month, 'value', value.month);
          return;
        }

        if (key == 'warranties') {
          Object.keys(value).forEach((key) => {
            if (key == '外壁塗装') {
              this.$set(this.form_params.warranty_value1, 'value', value[key]);
            } else if (key == '屋根塗装') {
              this.$set(this.form_params.warranty_value2, 'value', value[key]);
            } else if (key == '屋上防水') {
              this.$set(this.form_params.warranty_value3, 'value', value[key]);
            } else if (key == 'ベランダ防水') {
              this.$set(this.form_params.warranty_value4, 'value', value[key]);
            } else {
              this.$set(this.form_params.warranty_name5, 'value', key);
              this.$set(this.form_params.warranty_value5, 'value', value[key]);
            }
          });
        }

        if (key in this.form_params) {
          if (value != null && value.length > 0) {
            this.$set(this.form_params[key], 'value', value);
          }
          return;
        }

        if (key in this.image_files && value && value?.length) {
          this.$set(this.image_files[key], 'src', value);
          return;
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
    clickDeleteBtn() {
      if (confirm('この施工事例を削除します。\n本当によろしいですか？')) {
        axios.delete(Api.example.id(this.example_id)).then(response => {
          location.href = response.data.next;
        }).catch(error => {
          console.log(error);
        });
      }
    },
  },
  components: {
    FormInput,
    TextInput,
    TextArea,
    SelectInput,
    Multiselect,
    ImageFileCard,
  },
};
</script>