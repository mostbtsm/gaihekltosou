<template>
  <div class="form-container section">
    <div class="col text-blue sub-title">お知らせの対象会員</div>
    <div class="col text-gray sub-content">{{ (notice.kbn === 0 ? '共通' : (notice.kbn === 1 ? '個人' : '業者')) }}</div>

    <div class="col text-blue sub-title">メール件名</div>
    <div class="col text-gray sub-content">{{ notice.subject }}</div>

    <div class="col text-blue sub-title">内容</div>
    <div class="col text-gray sub-content" v-html="notice.contents_nl2br"></div>

    <div v-if="flg === 0" class="btn-area" style="text-align:right;">
      <button class="btn-detail" @click="back">戻る</button>
      <button class="btn-detail" @click="submit">登録</button>
    </div>
    <div v-else-if="flg !== 3" class="btn-area" style="text-align:right;">
      <button class="btn-detail" @click="edit">編集</button>
      <button v-if="flg === 1" class="btn-detail" style="width:100px;" @click="send">メール送信</button>
    </div>
  </div>
</template>
<script>
  export default {
    props: [
      'notice',
      'flg'
    ],
    methods: {
      back: function() {
        this.$emit('back', this.notice);
      },
      submit: function() {
        var data = {type: this.notice.kbn, subject: this.notice.subject, contents: this.notice.contents};

        if (this.notice.id == 0) {
          axios.post('/notice', data).then(function() {
            location.href = '/admin/notice_list';
          });
        } else {
          axios.put('/notice/' + this.notice.id, data).then(function() {
            location.href = '/admin/notice_list';
          });
        }
      },
      edit: function() {
        location.href = '/notice/' + this.notice.id + '/edit';
      },
      send: function() {
        var data = {id: this.notice.id, type: this.notice.kbn, subject: this.notice.subject, contents: this.notice.contents};

        axios.post('/notice/send', data).then(function() {
          location.href = '/admin/notice_list';
        });
      }
    }
  }
</script>