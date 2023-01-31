<template>
  <div class="column-detail">
    <div class="header">
      <p class="header-img" :style="{ backgroundImage: 'url(' + profile_image + ')' }" />
      <p class="header-txt">{{ painter_name }}</p>
    </div>
    <div class="part">
      <p class="part-date">{{ date }}</p>
      <p class="part-title">{{ title }}</p>
      <Slider v-if="images.length > 0" :items="images" />
      <div class="part-txt">
        <p class="pre-wrap">{{ contents }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import Slider from "js/components/Slider.vue";

export default {
  props: {
    painter_name: {
      type: String,
    },
    profile_image: {
      type: String,
    },
    title: {
      type: String,
    },
    contents: {
      type: String,
    },
    date: {
      type: String,
    },
    images: {
      type: Array,
    },
  },
  components: {
    Slider,
  },
};
</script>