<template>
  <div class="column-detail">
    <div class="header">
      <p class="header-img" :style="{ backgroundImage: 'url(' + profile_image + ')' }" />
      <p class="header-txt">{{ painter_name }}</p>
    </div>

    <div class="part">
      <p class="part-date">{{ column.updated_at }}</p>
      <p class="part-title">{{ column.title }}</p>
      <Slider :items="getImages(column)" />
      <div class="part-txt">
        <p class="pre-wrap">{{ column.contents }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Slider from "js/components/Slider.vue";

export default {
  props: {
    painter_name: {
      type: String,
    },
    profile_image: {
      type: String,
    },
    column_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      column: {},

      image_file_keys: [
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
      ],
    };
  },
  computed: {
    ...mapGetters('Column', [
      'findColumn',
    ]),
  },
  created() {
    this.$store.dispatch('Column/loadColumn', this.column_id).then(() => {
      this.column = this.findColumn(this.column_id);
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    getImages(obj) {
      let images = [];

      this.image_file_keys.forEach(key => {
        if (obj[key] && obj[key].length > 0) {
          images.push({ src: obj[key] });
        }
      });

      return images;
    },
  },
  components: {
    Slider,
  },
};
</script>