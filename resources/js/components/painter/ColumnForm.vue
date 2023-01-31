<template>
  <div>
    <div v-if="preview" style="margin-top: -3rem">
      <ColumnPreview
        :painter_name="painter_name"
        :profile_image="profile_image"
        :title="form_params.title.value"
        :contents="form_params.contents.value"
        :date="previewDate"
        :images="previewImages"
      ></ColumnPreview>

      <button type="submit" class="btn-send mt-5" @click="submitForm">投稿する</button>
      <button type="button" class="btn-link mt-5" @click="setPreview(false)">修正する</button>
    </div>

    <form v-show="!preview" @submit.prevent="submitForm">
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

      <div class="form-title mt-5">写真の追加</div>

      <div v-for="(param, key) in image_files" :key="key">
        <small v-for="errorText in param.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>

      <div class="row mt-3">
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

      <button type="button" class="btn-send mt-5" @click="setPreview(true)">プレビューを確認</button>
      <button type="submit" class="btn-send mt-5">投稿する</button>

      <button v-if="this.column_id != null" type="button" class="btn-delete mt-5" @click="clickDeleteBtn">コラムを削除する</button>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInput.vue";
import ColumnPreview from "js/components/painter/ColumnPreview.vue";
import ImageFileCard from "js/components/form/ImageFileCard.vue";

export default {
  props: {
    column_id: {
      type: Number,
    },
  },
  data() {
    return {
      preview: false,
      column: null,
      painter_name: '',
      profile_image: '',
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
        title: {
          id: "title",
          name: "title",
          type: "text",
          label: "タイトル",
          value: "",
          placeholder: "外壁塗装あれこれ",
          errors: [],
        },
        contents: {
          id: "contents",
          name: "contents",
          type: "textarea",
          label:"内容",
          value: "",
          rows: "8",
          placeholder: "（1000文字以内）",
          errors: [],
        },
      },
    };
  },
  computed: {
    ...mapGetters('Column', [
      'findColumn',
    ]),
    previewImages() {
      let images = [];

      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].src && this.image_files[key].src.length > 0) {
          images.push({ src: this.image_files[key].src });
        }
      });

      return images;
    },
    previewDate() {
      if (this.column != null) {
        return this.column.updated_at;
      } else {
        const now = new Date();
        const year = now.getFullYear()
        const month = ("00" + (now.getMonth()+1)).slice(-2)
        const date = ("00" + now.getDate()).slice(-2)
        const hour = ("00" + now.getHours()).slice(-2)
        const minute = ("00" + now.getMinutes()).slice(-2)
        const second = ("00" + now.getSeconds()).slice(-2)

        return year + '-' + month + '-' + date + ' ' + hour + ':' + minute + ':' + second;
      }
    }
  },
  mounted() {
    axios.get(Api.show).then(response => {
      if (response.data) {
        this.painter_name = response.data.name;
        this.profile_image = response.data.profile_image;
      }
    }).catch(error => {
      console.log(error);
    });

    if (this.column_id != null) {
      this.$store.dispatch('Column/loadMyColumn', this.column_id).then(() => {
        this.column = this.findColumn(this.column_id);
        this.setFormParams(this.column);
      }).catch(error => {
        console.log(error);
      });
    }
  },
  methods: {
    submitForm() {
      const url = this.column_id != null ? Api.column.id(this.column_id) : Api.column.index;
      const params = this.getFormParams();

      if (this.column_id != null) {
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
    setPreview(value) {
      this.preview = value;
    },
    clickDeleteBtn() {
      if (confirm('このコラムを削除します。\n本当によろしいですか？')) {
        axios.delete(Api.column.id(this.column_id)).then(response => {
          location.href = response.data.next;
        }).catch(error => {
          console.log(error);
        });
      }
    },
  },
  components: {
    FormInput,
    ColumnPreview,
    ImageFileCard,
  },
};
</script>