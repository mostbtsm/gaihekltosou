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
              <button type="button" class="btn-round" @click="clickEditBtn(example)">編集</button>
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
  </div>
</template>

<script>
import { Web } from "js/route/painter.js";
import { mapGetters } from "vuex";
import Slider from "js/components/Slider.vue";

export default {
  data() {
    return {
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
  computed: {
    ...mapGetters('Example', [
      'examples',
    ]),
  },
  mounted() {
    this.$store.dispatch('Example/loadMyExamples').catch(error => {
      console.log(error);
    });
  },
  methods: {
    clickEditBtn(example) {
      location.href = Web.example.edit(example.id);
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
  },
  components: {
    Slider,
  },
};
</script>