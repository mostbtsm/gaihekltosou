<template>
<div>

    <div v-if="input" key="input">
        <div class="row justify-content-center">
            <notice-input @confirm="confirm" :notice="notice"></notice-input>
        </div>
    </div>
 
    <div v-else-if="conf" key="conf">
        <div class="row justify-content-center">
            <notice-conf @back="back" :notice="notice" :flg="0"></notice-conf>
        </div>
    </div>

</div>
</template>

<script>
  import NoticeInput from 'js/components/admin/NoticeInput.vue';
  import NoticeConf from 'js/components/admin/NoticeConf.vue';

  export default {
    components: {
      NoticeInput,
      NoticeConf
    },
    data: function() {
      return {
        input: true,
        conf: false,
        notice: {id: 0, kbn: 0, subject: '', contents: '', contents_nl2br: ''}
      };
    },
    methods: {
      back: function (data) {
        this.notice = data;
        this.input = true;
        this.conf = false;
      },
      confirm: function (data) {
        this.notice = data;
        this.input = false;
        this.conf = true;
      }
    }
  }
</script>