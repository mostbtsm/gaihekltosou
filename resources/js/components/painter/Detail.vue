<template>
  <div class="painter-detail">
    <Slider :items="getImages(painter)" />

    <div class="profile">
      <div class="profile-header">
        <div class="address-name">
          <p>{{ painter.prefecture_name }}{{ painter.city }}</p>
          <h2>{{ painter.name }}</h2>
        </div>
      </div>

      <div class="category-area">
        <div class="item" v-for="category in painter.category_names" :key="category">
          {{ category }}
        </div>
      </div>

      <div class="pr-area">
        <p>{{ painter.pr_copy }}</p>
      </div>

      <div class="btn-area">
        <slot name="btn_consul" :painter="painter"></slot>
        <slot name="btn_favorite" :painter="painter"></slot>
      </div>

      <div class="copy-area">
        <div class="copy-title">
          <h4>プロフィール</h4>
        </div>
        <div class="copy-body">
          <p>{{ painter.catch_copy }}</p>
        </div>
      </div>

      <div class="company">
        <div class="company-title">
          <h4>会社概要</h4>
        </div>
        <div class="company-body">
          <div class="row">
            <div class="col-header">名称</div>
            <div class="col-body">{{ painter.name }}</div>
          </div>
          <div class="row">
            <div class="col-header">代表者</div>
            <div class="col-body">{{ painter.ceo_name }}</div>
          </div>
          <div class="row">
            <div class="col-header">所在地</div>
            <div class="col-body">{{ painter.prefecture_name }}{{ painter.city }}{{ painter.address1 }}{{ painter.address2 }}</div>
          </div>
          <div class="row">
            <div class="col-header">TEL</div>
            <div class="col-body">{{ painter.tel }}</div>
          </div>
          <div class="row">
            <div class="col-header">FAX</div>
            <div class="col-body">{{ painter.fax }}</div>
          </div>
          <div class="row">
            <div class="col-header">設立</div>
            <div class="col-body">{{ painter.established }}</div>
          </div>
          <div class="row">
            <div class="col-header">事業内容</div>
            <div class="col-body">{{ painter.type }}</div>
          </div>
          <div class="row">
            <div class="col-header">加盟団体</div>
            <div class="col-body">{{ painter.organization }}</div>
          </div>
        </div>
      </div>

      <div class="example" v-if="examples.length">
        <div class="example-body">
          <div class="example-item" v-for="example in examples" :key="example.id" >
            <img :src="example.image_file1" />
          </div>
        </div>
        <div class="example-footer">
          <slot name="btn_example">
            <a href="#" class="show-btn">施工事例を見る</a>
          </slot>
        </div>
      </div>

      <div class="column" v-if="columns.length">
        <div class="column-contain">
          <div class="column-header">
            <img src="/image/column.png" alt="">
            <h4>コラム</h4>
          </div>
          <div class="column-body">
            <h4 class="column-date">{{ columns[0].updated_at }}</h4>
            <h4 class="column-title">{{ columns[0].title }}</h4>

            <div class="column-image">
              <Slider :items="getImages(columns[0])" />
            </div>

            <div class="column-contents">
              <p>{{ columns[0].contents }}</p>
            </div>
          </div>
        </div>

        <div class="column-footer">
          <slot name="btn_column">
            <a href="#" class="show-btn">コラムを見る</a>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Slider from 'js/components/Slider.vue';
import VueSlickCarousel from "vue-slick-carousel";

export default {
  props: {
    painter_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      painter: {},

      image_file_keys: [
        'profile_image',
        'image_file1',
        'image_file2',
        'image_file3',
        'image_file4',
      ],
    };
  },
  computed: {
    ...mapGetters('Painter', [
      'findPainter',
    ]),
    ...mapGetters('Example', [
      'examples',
    ]),
    ...mapGetters('Column', [
      'columns',
    ]),
  },
  mounted() {
    this.painter = this.findPainter(this.painter_id);
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
    VueSlickCarousel,
  },
};
</script>