<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getColumns">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;">ID</th>
                <th style="width:280px;">業者名</th>
                <th style="width:350px;">タイトル</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="column in columns" :key="column.id">
                <td><p>{{ column.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ column.name }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ column.title }}</p></td>
                <td><p>{{ column.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailColumn(column.id)">詳細確認</a>
                    <a v-if="column.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deleteColumn(column.id)">削除する</a>
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
        columns: [],
        args: '',
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailColumn: function(id) {
        var w = 480;
        var h = 900;
        var left = window.innerWidth / 2 - (w / 2);
        var top = window.innerHeight / 2 - (h / 2);
        var opt = 'top=' + top + ',left=' + left + ',width=' + w + ',height=' + h;

        // window.open('/admin/column_detail/' + id, 'column_detail', opt);
      },
      deleteColumn: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'のコラムを削除します。よろしいですか？')) {
          axios.delete('/admin/column_del/' + id).then(function(response) {
            self.getColumns();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getColumns();
      },
      getColumns: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'page=' + this.current_page;

        axios.get(encodeURI('/admin/columns?' + param)).then(function(response) {
          self.columns = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getColumns();
    }
  };
</script>