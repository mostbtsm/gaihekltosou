<template>
  <mdb-pagination>
    <p @click="change(current - 1)"><mdb-page-item :disabled="current <= 1">前</mdb-page-item></p>
    <template v-for="page in pages">
    <p @click="change(page)"><mdb-page-item :active="page === current">{{ page }}</mdb-page-item></p>
    </template>
    <p @click="change(current + 1)"><mdb-page-item :disabled="current >= last">次</mdb-page-item></p>
  </mdb-pagination>
</template>
<script>
  import { mdbPagination, mdbPageItem, mdbPageNav } from 'mdbvue';
  export default {
    name: 'PageLoader',
    components: {
      mdbPagination,
      mdbPageItem,
      mdbPageNav
    },
    props: {
      current: Number,
      last: Number
    },
    computed: {
      pages: function() {
        var s = Math.max(this.current - 2, 1);
        var e = Math.min(s + 5, this.last + 1);
        s = Math.max(e - 5, 1);

        var l = Math.max((e - s), 0);
        var range = Array(l);

        for (var i = 0; i < l; i++) {
            range[i] = s++;
        }

        return range;
      }
    },
    methods: {
      change: function(p) {
        if (p >= 1 && p <= this.last) {
          this.$emit('page-click', p);
        }
      }
    }
  }
</script>