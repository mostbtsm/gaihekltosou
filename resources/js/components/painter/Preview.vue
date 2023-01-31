<template>
  <Detail v-if="loaded" :painter_id="painter_id">
    <template v-slot:btn_consul>
      <a href="#" class="btn-confirm">相談する</a>
    </template>

    <template v-slot:btn_favorite>
      <div class="favorite-box" v-if="!is_favorite">
        <p class="favorite-label">お気に入り登録</p>
        <div id="fav-icon" class="favorite-icon" @click="clickFavorite()"></div>
      </div>
      <div class="favorite-box" v-else>
        <p class="favorite-label">お気に入り解除</p>
        <div id="fav-icon" class="favorite-icon active" @click="clickFavorite()"></div>
      </div>
    </template>
  </Detail>
</template>

<script>
import { mapGetters } from "vuex";
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
      loaded: false,
      is_favorite: false,
    };
  },
  computed: {
    ...mapGetters("Painter", [
      "findPainter",
    ]),
  },
  created() {
    this.$store.dispatch('Painter/loadPreview').then(() => {
      this.loaded = true;
      this.$store.dispatch('Example/loadMyExamples');
      this.$store.dispatch('Column/loadMyColumns');
    }).catch(error => {
      console.log(error);
    });
  },
  methods: {
    clickFavorite() {
      this.is_favorite = !this.is_favorite;
    },
  },
  components: {
    Detail,
  },
};
</script>