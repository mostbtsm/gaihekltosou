<template>
  <div>
  <div class="create-form" v-show="!preview">
    <form id="form" @submit.prevent="submitForm" method="post">
      <!--<div class="row">
        <div class="col d-flex justify-content-center">
          <h2>コラム投稿</h2>
        </div>
      </div>-->
      <br>
      <div class="form-div" v-for="(param, key) in form_params" :key="key">
        <label :for="param.name">タイトル</label>
          <FormInput 
            :id="param.id"
            :name="param.name"
            :type="param.type"
            :title="param.title"
            :placeholder="param.placeholder"
            :prepend="param.prepend"
            :errors="param.errors"
            v-model="param.value"
          ></FormInput>
      </div>
      <div class="form-div">
        <FormInput cols="20" rows="5" maxlength="5" v-for="(param, key) in form_params3" :key="key"
          :id="param.id"
          :name="param.name"
          :type="param.type"
          :title="param.title"
          :placeholder="param.placeholder"
          :prepend="param.prepend"
          :errors="param.errors"
          v-model="param.value"
        ></FormInput>
      </div>
<!--
      <div class="form-div">
          <label>#ハッシュタグの設定をする</label>
        <button type="button">設定</button>
      </div>
      <div class="form-div">
          <label class="description">#外壁塗装 </label>
          <label class="description">#防水工事 </label>
      </div>
-->
      <div class="form-div">
          <label>写真の追加</label>
      </div>
      <div class="row">
        <div v-for="(param, key) in image_files" :key="key" class="col-md-4 mb-3">
          <div class="card" @click="onClick(param.name)">
            <div class="card-body d-flex justify-content-center align-items-center mypage-property-image" :style="{ backgroundImage: 'url(' + param.src + ')' }">
              <h5 v-show="!param.src.length" class="card-title">+</h5>
              <input type="file" style="display: none;" accept="image/gif,image/jpeg,image/png" :name="param.name" :ref="param.name" @change="onChange($event, param.name)">
            </div>
          </div>
        </div>
      </div>
      <br>
<!--
      <div class="form-div">
          <label>動画リンク</label>
        <FormInput v-for="(param, key) in form_params4" :key="key"
          
          :id="param.id"
            :name="param.name"
            :type="param.type"
            :title="param.title"
            :placeholder="param.placeholder"
            :prepend="param.prepend"
            :errors="param.errors"
            v-model="param.value"
        ></FormInput>
      </div>
      <br>
-->
      <div class="button-div">
        <button type="button" class="btn-confirm-edit" @click="clickPreviewBtn">プレビューを確認</button>
        <button type="submit" class="btn-submit">投稿する</button>
      <br>
      <br>
      <br>
      </div>
    </form>
  </div>
  <div class="confirm-form"  v-show="preview">
      <div class="column-list">
         <div class="header">
            <img class="header-img" alt="" :src=painters[0].image_file />
            <p class="header-txt">{{ painters[0].name }}</p>
         </div>
         <div class="part">
            <p class="part-date">{{ now }}</p>
            <p class="part-title">{{ form_params.title.value }}</p>
<!--
            <p class="part-subtitle">#外壁塗装&nbsp;#屋根塗装&nbsp;#ベランダ防水&nbsp;#塗替え道場</p>
-->
            <div>
              <Slider :items="images"/>
            </div>
            <div class="part-txt" style="white-space: pre-line;">
                <p>
                {{ form_params3.contents.value }}
                </p>
            </div>
            <div class="button-div">
              <button type="button" class="btn-submit" @click="onUpload">投稿する</button>
              <button type="button" class="btn-edit" @click="clickEditBtn">
                修正する
              </button>
            </div>
         </div>
      </div>
  </div>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import FormInput from "js/components/form/FormInputGroupText.vue";
import Slider from "js/components/Slider.vue";

export default {

  data() {
    return {
      preview: false,
      painters: [],
      now: "00:00:00",

      form_params: {
        title: {
          id: "title",
          name: "title",
          type: "title",
          title: "",
          value: "",
          placeholder: "外壁塗装あれこれ",
          errors: [],
        },
      },

      form_params2: {
        category: {
          id: "category",
          name: "category",
          value: "",
          placeholder: "",
          options: [
                    '塗装施工内容について',
                    '防水工事の施工内容について',
                    'その他工事について',
                    '業者選びについて',
                    'その他',
                   ],
          errors: [],
        },
      },

      form_params3: {
        contents: {
          id: "contents",
          name: "contents",
          type: "textarea",
          title: "",
          value: "",
          placeholder: "内容 (1000文字以内)",
          errors: [],
        },
      },
      form_params4: {
        videourl: {
          id: "videourl",
          name: "videourl",
          type: "videourl",
          title: "",
          value: "",
          placeholder: "YouTube URL",
          errors: [],
        },
      },
      image_files: {
        image_file1: {
          name: "image_file1",
          src: '',
          errors: [],
        },
        image_file2: {
          name: "image_file2",
          src: '',
          errors: [],
        },
        image_file3: {
          name: "image_file3",
          src: '',
          errors: [],
        },
        image_file4: {
          name: "image_file4",
          src: '',
          errors: [],
        },
        image_file5: {
          name: "image_file5",
          src: '',
          errors: [],
        },
        image_file6: {
          name: "image_file6",
          src: '',
          errors: [],
        },
      },
    };
  },
  mounted() {
      axios.get(Api.getpainterinfo).then(response => {
            this.painters = response.data;
      }).catch(error => {
        if (error.response) {
          if (error.response.status == 422) {
          }
        }
      });

  },
  watch: {
    form_params3: {
      handler: function(val, oldVal){
        let oldvalue = this.form_params3.contents.value;
        this.form_params3.contents.value = this.charaLimit(val.contents.value);
        if ( oldvalue != this.form_params3.contents.value){
          let reviewTextarea = document.getElementById('contents');
          reviewTextarea.value = this.form_params3.contents.value;
        }
      },
      deep: true
    }
  },
  methods: {
    charaLimit(inputText) {
      return inputText.length > 1000 ? inputText.slice(0, 1000) : inputText;
    },
    clickPreviewBtn() {
          let date = new Date();
          let month = date.getMonth() + 1;
          
          this.now = date.getFullYear() + "."
          + month + "." +
          + date.getDate() + " "
          + date.getHours() + ":"
          + date.getMinutes();

                let sliderimage = [];
                let imagefile1 = {
                  img: true,
                  src: '',
                };
                let imagefile2 = {
                  img: true,
                  src: '',
                };
                let imagefile3 = {
                  img: true,
                  src: '',
                };
                let imagefile4 = {
                  img: true,
                  src: '',
                };
                let imagefile5 = {
                  img: true,
                  src: '',
                };
                let imagefile6 = {
                  img: true,
                  src: '',
                };
                if(this.image_files.image_file1.src){
                  this.$set(imagefile1, 'src', this.image_files.image_file1.src);
                  sliderimage.push(imagefile1);
                }
                if(this.image_files.image_file2.src){
                  this.$set(imagefile2, 'src', this.image_files.image_file2.src);
                  sliderimage.push(imagefile2);
                }
                if(this.image_files.image_file3.src){
                  this.$set(imagefile3, 'src', this.image_files.image_file3.src);
                  sliderimage.push(imagefile3);
                }
                if(this.image_files.image_file4.src){
                  this.$set(imagefile4, 'src', this.image_files.image_file4.src);
                  sliderimage.push(imagefile4);
                }
                if(this.image_files.image_file5.src){
                  this.$set(imagefile5, 'src', this.image_files.image_file5.src);
                  sliderimage.push(imagefile5);
                }
                if(this.image_files.image_file6.src){
                  this.$set(imagefile6, 'src', this.image_files.image_file6.src);
                  sliderimage.push(imagefile6);
                }

                this.images = sliderimage;

      this.preview = true;
    },
    clickEditBtn() {
      this.preview = false;
    },
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
      };

      reader.readAsDataURL(file);
    },
    submitForm() {
      axios.post(Api.columnstore, this.getFormParams()).then(response => {
        location.href = response.data.next;
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
    onUpload() {
      this.submitForm();
    },
    getFormParams() {
      const params = new FormData();
      Object.keys(this.form_params).forEach(key => {
        params.append(this.form_params[key].name, this.form_params[key].value);
      });
//      Object.keys(this.form_params2).forEach(key => {
//        params.append(this.form_params2[key].name, this.form_params2[key].value);
//      });
      Object.keys(this.form_params3).forEach(key => {
        params.append(this.form_params3[key].name, this.form_params3[key].value);
      });
      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].src?.length) {
          params.append(this.image_files[key].name, this.$refs[this.image_files[key].name][0].files[0]);
        }
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
          else if (key in this.form_params2) {
            this.$set(this.form_params2[key], 'errors', responseData.errors[key]);
          }
          else if (key in this.form_params3) {
            this.$set(this.form_params3[key], 'errors', responseData.errors[key]);
          }
          else if (key in this.image_files) {
            this.$set(this.image_files[key], 'errors', responseData.errors[key]);
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
      Object.keys(this.form_params3).forEach(key => {
        this.$set(this.form_params3[key], 'errors', []);
      });
      Object.keys(this.image_files).forEach(key => {
        this.$set(this.image_files[key], 'errors', []);
      });
    },
  },
  components: {
    FormInput,
    Slider,
  },
};
</script>