<template>
  <div class="column-list-all">
    <div v-show="!firstLoading" class="list-header">
      <p class="list-header-sub-txt">すべての記事&nbsp;( {{ total }} )</p>
    </div>

    <div v-for="column in columns" :key="column.id">
      <div class="part" @click="click(column)">
        <div class="part-left">
          <div class="part-date">
            <p>{{ column.updated_at }}</p>
          </div>
          <p class="part-title">{{ column.title }}</p>
        </div>

        <div v-if="column.image_file1" class="part-right" :style="{ backgroundImage: 'url(' + column.image_file1 + ')' }"></div>
      </div>
    </div>

    <div id="loading-area" v-if="firstLoading || hasNext">
      <Loading></Loading>
    </div>
  </div>
</template>

<script>
import { Web } from "js/route/user.js";
import { mapGetters } from 'vuex';
import Loading from "js/components/Loading.vue";

export default {
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
    windowBottom() {
      return this.scrollY + this.height;
    },
  },
  computed: {
    ...mapGetters('Column', [
      'columns',
      'total',
      'hasNext',
    ]),
  },
  mounted() {
    const vm = this;
    this.$store.dispatch('Column/search', {}).then(() => {
      vm.firstLoading = false;

      if (vm.hasNext) {
        document.addEventListener('scroll', vm.scrollWatch);
      }
    });
  },
  methods: {
    click(column) {
      location.href = Web.column.id(column.id);
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
    Loading,
  },
};
</script>