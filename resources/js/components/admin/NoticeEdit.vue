<template>
<div>

    <div v-if="input" key="input">
        <div class="row justify-content-center">
            <notice-input @confirm="confirm" :notice="notice_arr"></notice-input>
        </div>
    </div>
 
    <div v-else-if="conf" key="conf">
        <div class="row justify-content-center">
            <notice-conf @back="back" :notice="notice_arr" :flg="0"></notice-conf>
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
    props: [
      'notice'
    ],
    data: function() {
      return {
        input: true,
        conf: false,
        notice_arr: {id: 0, kbn: 0, subject: '', contents: '', contents_nl2br: ''}
      };
    },
    methods: {
      back: function (data) {
        this.notice_arr = data;
        this.input = true;
        this.conf = false;
      },
      confirm: function (data) {
        this.notice_arr = data;
        this.input = false;
        this.conf = true;
      }
    },
    mounted() {
      this.notice_arr.id = this.notice.id;
      this.notice_arr.kbn = this.notice.type;
      this.notice_arr.subject = this.notice.subject;
      this.notice_arr.contents = this.notice.contents;
      this.notice_arr.contents_nl2br = this.notice.contents.replace(/\r?\n/g, '<br>');
    }
  }
</script>