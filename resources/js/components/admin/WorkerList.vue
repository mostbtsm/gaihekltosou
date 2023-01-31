<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getPainters">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;"><a href="javascript:void(0)" @click="dataSort">ID</a></th>
                <th style="width:230px;">会社メールアドレス</th>
                <th style="width:230px;">事業者名</th>
                <th style="width:120px;">代表者名</th>
                <th style="width:50px;">ランク</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="painter in painters" :key="painter.id">
                <td><p>{{ painter.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ painter.email }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ painter.name }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ painter.ceo_name }}</p></td>
                <td><p>{{ painter.rank }}</p></td>
                <td><p>{{ painter.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailPainter(painter.id)">詳細確認</a>
                    <a v-if="painter.rank === 0" href="javascript:void(0)" style="margin-left:5px;" @click="approvePainter(painter.id)">承認する</a>
                    <a v-else-if="painter.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deletePainter(painter.id)">削除する</a>
                    <a v-else href="javascript:void(0)" style="margin-left:5px;" @click="restorePainter(painter.id)">削除復活</a>
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
        painters: [],
        args: '',
        order: 0,
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailPainter: function(id) {
        var w = 480;
        var h = 900;
        var left = window.innerWidth / 2 - (w / 2);
        var top = window.innerHeight / 2 - (h / 2);
        var opt = 'top=' + top + ',left=' + left + ',width=' + w + ',height=' + h;

        // window.open('/admin/painter_detail/' + id, 'painter_detail', opt);
      },
      approvePainter: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の業者会員を承認します。よろしいですか？')) {
          axios.put('/admin/painter_approve/' + id).then(function(response) {
            self.getPainters();
          });
        }
      },
      deletePainter: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の業者会員を削除します。よろしいですか？')) {
          axios.delete('/admin/painter_del/' + id).then(function(response) {
            self.getPainters();
          });
        }
      },
      restorePainter: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の業者会員を復活します。よろしいですか？')) {
          axios.put('/admin/painter_restore/' + id).then(function(response) {
            self.getPainters();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getPainters();
      },
      dataSort: function() {
        this.order = this.order == 0 ? 1 : 0;

        this.getPainters();
      },
      getPainters: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'order=' + this.order + '&page=' + this.current_page;

        axios.get(encodeURI('/admin/painters?' + param)).then(function(response) {
          self.painters = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getPainters();
    }
  };
</script>