<template>
  <FavoriteList v-if="painter_id == null" :click_painter="setPainterId"></FavoriteList>

  <Detail v-else :painter_id="painter_id">
    <template v-slot:btn_consul>
      <a href="#" class="btn-confirm" @click="clickConsul()">相談する</a>
    </template>

    <template v-slot:btn_favorite="slotProps">
      <div class="favorite-box" v-if="!isFavorite(slotProps.painter.id)">
        <p class="favorite-label">お気に入り登録</p>
        <div id="fav-icon" class="favorite-icon" @click="addFavorite(slotProps.painter)"></div>
      </div>
      <div class="favorite-box" v-else>
        <p class="favorite-label">お気に入り解除</p>
        <div id="fav-icon" class="favorite-icon active" @click="removeFavorite(slotProps.painter)"></div>
      </div>
    </template>

    <template v-slot:btn_example>
      <a :href="exampleLink" class="show-btn">施工事例を見る</a>
    </template>

    <template v-slot:btn_column>
      <a :href="columnLink" class="show-btn">コラムを見る</a>
    </template>
  </Detail>
</template>

<script>
import { Web } from "js/route/user.js";
import { mapGetters, mapMutations } from 'vuex';
import FavoriteList from "js/components/user/FavoriteList.vue";
import Detail from "js/components/painter/Detail.vue";

export default {
  data() {
    return {
      painter_id: null,
    }
  },
  computed: {
    ...mapGetters('Painter', [
      'findPainter',
    ]),
    ...mapGetters('Favorite', [
      'isFavorite',
    ]),
    exampleLink() {
      return Web.example.painter(this.painter_id);
    },
    columnLink() {
      return Web.column.painter(this.painter_id);
    },
  },
  created() {
    this.$store.dispatch('Favorite/loadFavorites');
  },
  methods: {
    ...mapMutations('Example', [
      'examples',
    ]),
    ...mapMutations('Column', [
      'columns',
    ]),
    setPainterId(id) {
      const painter = this.findPainter(id);
      if (painter) {
        this.painter_id = painter.id;
        this.$store.dispatch('Example/loadPainterExamples', this.painter_id);
        this.$store.dispatch('Column/loadPainterColumns', this.painter_id);

        this.preventPopstate();
      }
    },
    unsetPainterId() {
      this.painter_id = null;
      this.examples([]);
      this.columns([]);
    },
    preventPopstate() {
      history.pushState(null, null, location.href);
      window.addEventListener('popstate', this.popstateEvent);
    },
    popstateEvent() {
      history.go(1);
      this.unsetPainterId();
      window.removeEventListener('popstate', this.popstateEvent);
    },
    clickConsul() {
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
    FavoriteList,
    Detail,
  },
};
</script>