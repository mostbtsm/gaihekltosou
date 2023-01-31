<template>
  <div class="column-list-all">
    <div class="list-header">
      <p class="list-header-sub-txt">すべての記事&nbsp;( {{ columns.length }} )</p>
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
  </div>
</template>

<script>
import { Web } from "js/route/user.js";
import { mapGetters } from 'vuex';

export default {
  props: {
    painter_id: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapGetters('Column', [
      'columns',
    ]),
  },
  created() {
    this.$store.dispatch('Column/loadPainterColumns', this.painter_id).catch(error => {
      console.log(error);
    });
  },
  methods: {
    click(column) {
      location.href = Web.column.id(column.id);
    },
  },
};
</script>