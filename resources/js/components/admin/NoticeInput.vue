<template>
  <div class="create-form" style="width:750px">
    <form id="form" onSubmit="return false;" method="post">
      <div class="row" style="margin-bottom:10px;">
        <div class="col-4 pl-5">
          <label for="kbn">お知らせの対象会員</label>
        </div>
        <div class="col-8">
          <input type="radio" id="kbn_1" name="kbn" value="0" v-model="notice_arr.kbn" />共通
          <input type="radio" id="kbn_2" name="kbn" value="1" v-model="notice_arr.kbn" />個人
          <input type="radio" id="kbn_3" name="kbn" value="2" v-model="notice_arr.kbn" />業者
        </div>
      </div>

      <div class="row" style="margin-bottom:10px;">
        <div class="col-4 pl-5">
          <label for="subject">メール件名</label>
        </div>
        <div class="col-8">
          <input type="text" id="subject" name="subject" size="50" v-model="notice_arr.subject" />
        </div>
      </div>

      <div class="row" style="margin-bottom:10px;">
        <div class="col-4 pl-5">
          <label for="contents">内容</label>
        </div>
        <div class="col-8">
          <textarea id="contents" name="contents" cols="50" rows="15" v-model="notice_arr.contents" @input="nl2br"></textarea>
        </div>
      </div>

      <div class="row">
        <div class="col-12" style="text-align:right;">
          <button class="btn-detail" @click="conf">確認する</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
  export default {
    props: [
      'notice'
    ],
    data: function() {
      return {
        notice_arr: {id: 0, kbn: 0, subject: '', contents: '', contents_nl2br: ''}
      };
    },
    methods: {
      nl2br: function() {
        this.notice_arr.contents_nl2br = this.notice_arr.contents.replace(/\r?\n/g, '<br>');
      },
      conf: function() {
        if (this.notice_arr.contents == '') {
            alert('内容が入力されていません。');
            return;
        }

        this.$emit('confirm', this.notice_arr);
      }
    },
    mounted() {
      this.notice_arr = this.notice;
      this.notice_arr.contents_nl2br = this.notice_arr.contents.replace(/\r?\n/g, '<br>');
    }
  }
</script>