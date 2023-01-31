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
import { Web } from "js/route/painter.js";
import { mapGetters } from 'vuex';

export default {
  computed: {
    ...mapGetters('Column', [
      'columns',
    ]),
  },
  mounted() {
    this.$store.dispatch('Column/loadMyColumns').catch(error => {
      console.log(error);
    });
  },
  methods: {
    click(column) {
      location.href = Web.column.edit(column.id);
    },
  },
};
</script>