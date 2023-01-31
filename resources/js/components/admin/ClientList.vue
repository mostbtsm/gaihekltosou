<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getUsers">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;"><a href="javascript:void(0)" @click="dataSort">ID</a></th>
                <th style="width:230px;">メールアドレス</th>
                <th style="width:200px;">氏名</th>
                <th style="width:200px;">ニックネーム</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td><p>{{ user.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ user.email }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ user.name1 }}　{{ user.name2 }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ user.nickname }}</p></td>
                <td><p>{{ user.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailUser(user.id)">詳細確認</a>
                    <a v-if="user.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deleteUser(user.id)">削除する</a>
                    <a v-else href="javascript:void(0)" style="margin-left:5px;" @click="restoreUser(user.id)">削除復活</a>
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
        users: [],
        args: '',
        order: 0,
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailUser: function(id) {
        var w = 480;
        var h = 900;
        var left = window.innerWidth / 2 - (w / 2);
        var top = window.innerHeight / 2 - (h / 2);
        var opt = 'top=' + top + ',left=' + left + ',width=' + w + ',height=' + h;

        // window.open('/admin/user_detail/' + id, 'user_detail', opt);
      },
      deleteUser: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の個人会員を削除します。よろしいですか？')) {
          axios.delete('/admin/user_del/' + id).then(function(response) {
            self.getUsers();
          });
        }
      },
      restoreUser: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の個人会員を復活します。よろしいですか？')) {
          axios.put('/admin/user_restore/' + id).then(function(response) {
            self.getUsers();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getUsers();
      },
      dataSort: function() {
        this.order = this.order == 0 ? 1 : 0;

        this.getUsers();
      },
      getUsers: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'order=' + this.order + '&page=' + this.current_page;

        axios.get(encodeURI('/admin/users?' + param)).then(function(response) {
          self.users = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getUsers();
    }
  };
</script>