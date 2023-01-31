<template>
  <Detail v-if="inner_painter_id != null" :painter_id="inner_painter_id">
    <template v-slot:btn_consul>
      <a :href="consulLink" class="btn-confirm">相談する</a>
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
import { mapGetters } from 'vuex';
import Detail from "js/components/painter/Detail.vue";

export default {
  props: {
    painter_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      inner_painter_id: null,
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
    consulLink() {
      return Web.chat.create(this.painter_id);
    },
  },
  created() {
    this.$store.dispatch('Favorite/loadFavorites');

    this.$store.dispatch('Painter/LoadPainter', this.painter_id).then(() => {
      this.inner_painter_id = this.findPainter(this.painter_id).id;

      this.$store.dispatch('Example/loadPainterExamples', this.painter_id);
      this.$store.dispatch('Column/loadPainterColumns', this.painter_id);
    });
  },
  methods: {
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
    Detail,
  },
};
</script>