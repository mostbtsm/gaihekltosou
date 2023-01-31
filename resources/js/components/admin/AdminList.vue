<template>

<div>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;">ID</th>
                <th style="width:630px;">管理者名</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="administrator in administrators" :key="administrator.id">
                <td><p>{{ administrator.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ administrator.username }}</p></td>
                <td><p>{{ administrator.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a v-if="administrator.deleted_at === null" href="javascript:void(0)" @click="deleteAdministrator(administrator.id)">削除する</a>
                    <a v-else href="javascript:void(0)" @click="restoreAdministrator(administrator.id)">削除復活</a>
                </td>
            </tr>      
        </table>
    </div>

    <pagination v-on:page-click="change" :current="current_page" :last="last_page"></pagination>

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
        administrators : [],
        current_page : 1,
        last_page : 1
      }
    },
    methods: {
      deleteAdministrator: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の管理者を削除します。よろしいですか？')) {
          axios.delete('/admin/' + id).then(function(response) {
            self.getAdministrators();
          });
        }
      },
      restoreAdministrator: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の管理者を復活します。よろしいですか？')) {
          axios.put('/admin/administrator_restore/' + id).then(function(response) {
            self.getAdministrators();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        console.log('current_page:' + this.current_page);

        this.getAdministrators();
      },
      getAdministrators: function() {
        var self = this;

        axios.get('/admin?page=' + this.current_page).then(function(response) {
          self.administrators = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
          console.log('current_page:' + self.current_page + ' last_page' + self.last_page);
        });
      }
    },
    mounted() {
      this.getAdministrators();
    }
  };
</script>