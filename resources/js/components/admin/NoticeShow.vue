<template>

    <div class="row justify-content-center">
        <notice-conf :notice="notice_arr" :flg="flg"></notice-conf>
    </div>

</template>

<script>
  import NoticeConf from 'js/components/admin/NoticeConf.vue';

  export default {
    components: {
      NoticeConf
    },
    props: [
      'notice'
    ],
    data: function() {
      return {
        notice_arr: {id: 0, kbn: 0, subject: '', contents: '', contents_nl2br: ''},
        flg: 1
      };
    },
    mounted() {
      this.notice_arr.id = this.notice.id;
      this.notice_arr.kbn = this.notice.type;
      this.notice_arr.subject = this.notice.subject;
      this.notice_arr.contents = this.notice.contents;
      this.notice_arr.contents_nl2br = this.notice.contents.replace(/\r?\n/g, '<br>');
      // 削除済又は送信済の場合は編集・送信不可、未送信かつ件名が設定されている場合は編集・送信可、それ以外は編集のみ可
      this.flg = (this.notice.deleted_at || this.notice.send_flg == 1 ? 3 : (this.notice.subject ? 1 : 2));
    }
  }
</script>