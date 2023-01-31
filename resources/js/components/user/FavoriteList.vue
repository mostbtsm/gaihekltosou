<template>
  <div class="painter-list">
    <div class="row list-area">
      <div class="list-item col-12" v-for="(painter, index) in painters" :key="index">
        <div class="card" @click="click_painter(painter.id)">
          <div class="company-card-header">
            <div class="company-image-area">
              <img alt="image" :src=painter.profile_image>
            </div>

            <div class="company-name-area">
              <div class="company-name-box">
                <p class="company-address">{{ painter.prefecture_name }}{{ painter.city }}</p>
                <p class="company-name">{{ painter.name }}</p>

                <div class="work-type">
                  <div class="item" v-for="category in painter.category_names" :key="category">
                    {{ category }}
                  </div>
                </div>
              </div>

              <div class="favorite-box" v-if="!isFavorite(painter.id)">
                <p class="favorite-label">お気に入り登録</p>
                <div id="fav-icon" class="favorite-icon" @click.stop="addFavorite(painter)"></div>
              </div>
              <div class="favorite-box" v-else>
                <p class="favorite-label">お気に入り解除</p>
                <div id="fav-icon" class="favorite-icon active" @click.stop="removeFavorite(painter)"></div>
              </div>
            </div>
          </div>

          <div class="company-comment">{{ painter.catch_copy }}</div>

          <div class="row">
            <div class="col-4 type-col">
              <div class="type">
                <div class="name">施工事例数</div>
                <div class="number">{{ painter.examples_count }}<span class="unit"> 件</span></div>
              </div>
            </div>

            <div class="col-4 type-col">
              <div class="type">
                <div class="name">口コミ数</div>
                <div class="number">{{ painter.evaluations_count }}<span class="unit"> 件</span></div>
              </div>
            </div>

            <div class="col-4 type-col">
              <div class="type">
                <div class="name">コラム数</div>
                <div class="number">{{ painter.columns_count }}<span class="unit"> 件</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 d-flex justify-content-center" v-if="!firstLoading && painters.length == 0">
      <p>お気に入り業者が見つかりませんでした</p>
    </div>

    <div id="loading-area" v-if="firstLoading || hasNext">
      <Loading></Loading>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Loading from "js/components/Loading.vue";

export default {
  props: {
    click_painter: {
      type: Function,
      default: id => {},
    },
  },
  data() {
    return {
      scrollY: 0,
      height: 0,
      loadOffset: 0,
      firstLoading: true,
      loadable: true,
    }
  },
  watch: {
    scrollY(value) {
      if (this.loadable && this.windowBottom > this.loadOffset) {
        this.loadable = false;
        this.fetch();
      }
    },
  },
  computed: {
    ...mapGetters('Painter', [
      'painters',
      'hasNext',
    ]),
    ...mapGetters('Favorite', [
      'isFavorite',
    ]),
    windowBottom() {
      return this.scrollY + this.height;
    },
  },
  mounted() {
    const vm = this;
    this.$store.dispatch('Painter/searchFavorites', {}).then(() => {
      vm.firstLoading = false;

      if (vm.hasNext) {
        document.addEventListener('scroll', vm.scrollWatch);
      }
    });
  },
  methods: {
    scrollWatch() {
      this.scrollY = document.body.scrollTop || document.documentElement.scrollTop;
      this.height = window.innerHeight || document.documentElement.clientHeight;
      this.loadOffset = document.getElementById('loading-area').offsetTop;
    },
    fetch() {
      const vm = this;
      this.$store.dispatch('Painter/fetchFavorites').then(() => {
        vm.loadable = true;

        if (!vm.hasNext) {
          document.removeEventListener('scroll', vm.scrollWatch);
        }
      });
    },
    addFavorite(painter) {
      this.$store.dispatch('Favorite/addFavorite', painter.id).catch(error => {
        console.log(error);
      });
    },
    removeFavorite(painter) {
      this.$store.dispatch('Favorite/removeFavorite', painter.id).catch(error => {
        console.log(error);
      });
    },
  },
  components: {
    Loading,
  },
};
</script>