<template>
  <div class="card image-card-default">
    <div v-if="src.length" class="image-file-button" @click="removeImage(name)">
      <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
    </div>
    <div class="card-body d-flex justify-content-center align-items-center image-card-body-default" :style="{ backgroundImage: 'url(' + src + ')' }" @click="onImageClick(name)">
      <h5 v-show="!src.length" class="card-title">+</h5>
      <input type="file" style="display: none;" accept="image/gif,image/jpeg,image/png" :name="name" :ref="name" @change="onImageChange($event)">
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  props: {
    name:  {
      type: String,
      required: true,
      default: '',
    },
    src: {
      type: String,
      default: '',
    },
    blob: {
      default: '',
    },
    mime_type: {
      type: String,
      default: 'image/jpeg',
    },
    del_flg: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      max_width: 320,
      max_height: 240,
    };
  },
  computed: {
    ...mapGetters('Config', ['image']),
  },
  created() {
    this.$store.dispatch('Config/load').then(() => {
      this.max_width = this.image.max_width;
      this.max_height = this.image.max_height;
    });
  },
  methods: {
    onImageClick(name) {
      this.$refs[name].click();
    },
    onImageChange(e) {
      const files = e.target.files ? e.target.files : e.dataTransfer.files;

      if (files[0]) {
        this.renderImage(files[0]);
      }
    },
    renderImage(file) {
      const reader = new FileReader();
      const image_reader = new Image();

      reader.onload = (e) => {
        image_reader.onload = () => {
          const w_ratio = this.max_width / image_reader.width;
          const h_ratio = this.max_height / image_reader.height;

          const width = (w_ratio > h_ratio) ? this.max_width : image_reader.width * h_ratio;
          const height = (h_ratio > w_ratio) ? this.max_height : image_reader.height * w_ratio;
          const x_offset = (width - this.max_width) / 2;
          const y_offset = (height - this.max_height) / 2;

          const canvas = document.createElement('canvas');
          canvas.width = this.max_width;
          canvas.height = this.max_height;
          const ctx = canvas.getContext('2d');
          //ctx.rect(x_offset, y_offset, this.max_width, this.max_height);
          //ctx.clip();
          ctx.drawImage(image_reader, -x_offset, -y_offset, width, height);
          const base64 = canvas.toDataURL(this.mime_type);

          this.$emit('update:src', base64);
          this.$emit('update:blob', this.base64ToBlob(base64));
          this.$emit('update:del_flg', false);
        };

        image_reader.src = e.target.result;
      };

      reader.readAsDataURL(file);
    },
    removeImage(name) {
      this.$refs[name].value = null;
      this.$emit('update:src', '');
      this.$emit('update:blob', null);
      this.$emit('update:del_flg', true);
    },
    base64ToBlob(base64) {
      const bin = atob(base64.replace(/^.*,/, ''));
      const buffer = new Uint8Array(bin.length);

      for (let i = 0; i < bin.length; i++) {
        buffer[i] = bin.charCodeAt(i);
      }

      return new Blob([buffer.buffer], {
        type: this.mime_type
      });
    }
  },
};
</script>