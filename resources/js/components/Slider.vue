<template>
  <VueSlickCarousel v-if="items.length > 0" v-bind="slickSetting">
    <div v-for="(item, key) in items" :key="key">
      <div class="carousel-image-cell" :style="{ backgroundImage: 'url(' + item.src + ')' }"></div>
    </div>
  </VueSlickCarousel>
</template>

<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
import "vue-slick-carousel/dist/vue-slick-carousel-theme.css";

export default {
  props: {
    items: {
      type: Array,
      default: [],
    }
  },
  data() {
    return {
      slickSetting: {
        arrows: false,
        dots: true,
        dotsClass: "slick-dots custom-dot-class",
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipeToSlide: true,
        touchMove: true,
        centerMode: true,
        centerPadding: "220px",
        responsive: [
          {
            breakpoint: 968,
            settings: {
              centerPadding: "110px",
            }
          },
          {
            breakpoint: 767,
            settings: {
              centerMode: false,
            }
          },
        ],
      },
    }
  },
  components: {
    VueSlickCarousel,
  },
};
</script>