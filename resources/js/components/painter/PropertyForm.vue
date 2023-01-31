<template>
  <div class="form-input-align-right">
    <form id="form form-input-align-right" @submit.prevent="submitForm">

      <div v-for="(param, key) in image_files" :key="key">
        <small v-for="errorText in param.errors" :key="errorText" class="form-text text-danger">{{ errorText }}</small>
      </div>

      <div class="row">
        <div v-for="(param, key) in image_files" :key="key" class="col-md-4 mb-3 col-property-image">
          <div class="card" @click="onClick(param.name)">
            <div class="card-body d-flex justify-content-center align-items-center mypage-property-image" :style="{ backgroundImage: 'url(' + param.src + ')' }">
              <h5 v-show="!param.src.length" class="card-title">+</h5>
              <input type="file" style="display: none;" accept="image/gif,image/jpeg,image/png" :name="param.name" :ref="param.name" @change="onChange($event, param.name)">
            </div>
          </div>
        </div>
      </div>

      <button style="margin-bottom:60px" type="submit" class="btn btn-primary btn-md btn-block mt-3">登録</button>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInputGroupText.vue";

export default {
  props: {
    edit_complete: {
      type: Function,
    },
  },
  data() {
    return {
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
    this.setFormParams();
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
      };

      reader.readAsDataURL(file);
    },
    getImageURL() {

      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].src != ''){
          let params = new URLSearchParams();
          params.append("image_file", this.image_files[key].src);
          axios.get(Api.imageurl, {params: params }).then(response => {
            this.$set(this.image_files[key], 'src', response.data.image_file);

          }).catch(error => {
            if (error.response) {
              if (error.response.status == 422) {
              }
            }
          });
        }
      });

    },
    submitForm() {
      axios.post(Api.store, this.getFormParams(), {
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

      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].src?.length) {
          params.append(this.image_files[key].name, this.$refs[this.image_files[key].name][0].files[0]);
        }
      });

      return params;
    },
    async setFormParams() {
      await axios.get(Api.images).then(response => {

        var i = 0;
        var j = 0;
        for (var k in response.data) {
           i += 1;
           j = 0;
           Object.keys(this.image_files).forEach(key => {
             j += 1;
             if (i == j) {
                 this.$set(this.image_files[key], 'src', response.data[k].image_file);
             }
           });
        }
            
      }).catch(error => {
        if (error.response) {
          if (error.response.status == 422) {
          }
        }
      });

      this.getImageURL();
    },
    setParamErrors(responseData) {
      if (responseData.errors) {
        this.resetErrors();
        Object.keys(responseData.errors).forEach(key => {

          if (key in this.image_files) {
            this.$set(this.image_files[key], 'errors', responseData.errors[key]);
          }
        });
      }
    },
    resetErrors() {
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