<template>
  <div class="example-list">
    <div class="col-12" style="padding: 0px 7px 0 7px" v-for="example in examples" :key="example.id">
      <div class="header">
        <div class="header-img">
          <img src="/image/home01-icon.png" alt="" />
        </div>

        <div class="header-body">
          <p class="header-date">{{ example.complete_date }}</p>
          <div class="header-txt">
            <div class="m-name">
              <p>{{ example.title }}</p>
              <a :href="getPainterLink(example)">{{ example.painter_info.name }}</a>
            </div>
          </div>
        </div>
      </div>

      <Slider :items="getImages(example)" />

      <div class="main">
        <div class="part">
          <div class="part-left">場&nbsp;&nbsp;所</div>
          <div class="part-right">
            {{ example.address }}
          </div>
        </div>
        <div class="part">
          <div class="part-left">工事内容</div>
          <div class="part-right">
            {{ example.category_names.join(' ') }}
          </div>
        </div>
        <div class="part">
          <div class="part-left">期&nbsp;&nbsp;間</div>
          <div class="part-right">
            {{ example.period_name }}
          </div>
        </div>
        <div class="part">
          <div class="part-left">保&nbsp;&nbsp;証</div>
          <div class="part-right">
            <p class="pre-line">{{ example.warranty_names.join('\n') }}</p>
          </div>
        </div>
        <div class="part">
          <div class="part-txt pre-line">
            {{ example.comment }}
          </div>
        </div>
      </div>
    </div>

    <div id="loading-area" v-if="firstLoading || hasNext">
      <Loading></Loading>
    </div>
  </div>
</template>

<script>
import { Web } from "js/route/user.js";
import { mapGetters } from "vuex";
import Slider from "js/components/Slider.vue";
import Loading from "js/components/Loading.vue";

export default {
  data() {
    return {
      scrollY: 0,
      height: 0,
      loadOffset: 0,
      firstLoading: true,
      loadable: true,

      image_file_keys: [
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
        'image_file5',
        'image_file6',
      ],
    };
  },
  watch: {
    scrollY(value) {
      if (this.loadable && this.windowBottom > this.loadOffset) {
        this.loadable = false;
        this.fetch();
      }
    },
    windowBottom() {
      return this.scrollY + this.height;
    },
  },
  computed: {
    ...mapGetters('Example', [
      'examples',
      'hasNext',
    ]),
  },
  mounted() {
    const vm = this;
    this.$store.dispatch('Example/search', {}).then(() => {
      vm.firstLoading = false;

      if (vm.hasNext) {
        document.addEventListener('scroll', vm.scrollWatch);
      }
    });
  },
  methods: {
    getPainterLink(example) {
      return Web.painter.id(example.painter_info.id);
    },
    getImages(example) {
      let images = [];

      this.image_file_keys.forEach(key => {
        if (example[key] && example[key].length > 0) {
          images.push({ src: example[key] });
        }
      });

      return images;
    },
    scrollWatch() {
      this.scrollY = document.body.scrollTop || document.documentElement.scrollTop;
      this.height = window.innerHeight || document.documentElement.clientHeight;
      this.loadOffset = document.getElementById('loading-area').offsetTop;
    },
    fetch() {
      const vm = this;
      this.$store.dispatch('Painter/fetch').then(() => {
        vm.loadable = true;

        if (!vm.hasNext) {
          document.removeEventListener('scroll', vm.scrollWatch);
        }
      });
    },
  },
  components: {
    Slider,
    Loading,
  },
};
</script>