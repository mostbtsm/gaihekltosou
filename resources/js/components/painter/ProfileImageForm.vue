<template>
  <div class="card image-card-default">
    <div class="image-file-button" @click="onClickRegister">
      <button type="button" class="btn btn-sm white"><i class="fa fa-camera"></i></button>
    </div>
    <div class="card-body d-flex justify-content-center align-items-center image-card-body-default" :style="{ backgroundImage: 'url(' + this.compSrc + ')' }" @click="onClickRegister">
      <h5 v-show="!this.compSrc.length" class="card-title">+</h5>
      <input type="file" style="display: none;" accept="image/gif,image/jpeg,image/png" ref="image_file" @change="onChange">
    </div>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";

export default {
  props: {
    src: {
      type: String,
      default: '',
    },
    exists: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      inner_src: '',
      inner_exists: false,
    };
  },
  computed: {
    compSrc() {
      return this.inner_src;
    },
    compExists() {
      return this.inner_exists;
    },
  },
  mounted() {
    this.inner_src = this.src;
    this.inner_exists = this.exists;
  },
  methods: {
    onClickRegister(e) {
      this.$refs.image_file.value = null;
      this.$refs.image_file.click();
    },
    onChange() {
      const formData = new FormData();
      formData.append("image_file", this.$refs.image_file.files[0]);

      axios.post(Api.uploadImage, formData).then(response => {
        this.inner_src = response.data.profile_image;
        this.inner_exists = true;
      }).catch(error => {
        // ToDo
      });
    },
  },
};
</script>