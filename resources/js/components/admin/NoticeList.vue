<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getNotices">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;">ID</th>
                <th style="width:200px;">タイプ</th>
                <th style="width:430px;">内容</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="notice in notices" :key="notice.id">
                <td><p>{{ notice.id }}</p></td>
                <td><p>{{ (notice.type === 0 ? '共通' : (notice.type === 1 ? '個人会員' : '業者会員')) }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ notice.contents === null ? '' : notice.contents.substring(0, 30) }}</p></td>
                <td><p>{{ (notice.deleted_at ? '削除済' : (notice.send_flg === 1 ? '送信済' : '')) }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailNotice(notice.id)">詳細確認</a>
                    <a v-if="notice.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deleteNotice(notice.id)">削除する</a>
                </td>
            </tr>      
        </table>
    </div>

    <pagination @page-click="change" :current="current_page" :last="last_page"></pagination>

</div>
</template>

<script>
  import { mdbContainer, mdbCol, mdbRow, mdbIcon, mdbTabs, mdbJumbotron, mdbView, mdbMask, mdbBtn, mdbTextarea, mdbInput } from 'mdbvue';
  import Pagination from 'js/components/admin/Pagination.vue';

  export default {
    name: 'TabPage',
    components: {
      mdbContainer,
      mdbCol,
      mdbRow,
      mdbIcon,
      mdbTabs,
      mdbJumbotron,
      mdbView,
      mdbMask,
      mdbBtn,
      mdbTextarea,
      mdbInput,
      Pagination
    },
    data: function() {
      return {
        notices: [],
        args: '',
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailNotice: function(id) {
        location.href = '/notice/' + id;
      },
      deleteNotice: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'のお知らせを削除します。よろしいですか？')) {
          axios.delete('/notice/' + id).then(function(response) {
            self.getNotices();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getNotices();
      },
      getNotices: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'page=' + this.current_page;

        axios.get(encodeURI('/notice?' + param)).then(function(response) {
          self.notices = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getNotices();
    }
  };
</script>