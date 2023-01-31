<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getExamples">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;">ID</th>
                <th style="width:280px;">業者名</th>
                <th style="width:350px;">件名</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="example in examples" :key="example.id">
                <td><p>{{ example.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ example.painter_name }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ example.property_name }}</p></td>
                <td><p>{{ example.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailExample(example.id)">詳細確認</a>
                    <a v-if="example.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deleteExample(example.id)">削除する</a>
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
        examples: [],
        args: '',
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailExample: function(id) {
        var w = 480;
        var h = 900;
        var left = window.innerWidth / 2 - (w / 2);
        var top = window.innerHeight / 2 - (h / 2);
        var opt = 'top=' + top + ',left=' + left + ',width=' + w + ',height=' + h;

        // window.open('/admin/example_detail/' + id, 'example_detail', opt);
      },
      deleteExample: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の施工事例を削除します。よろしいですか？')) {
          axios.delete('/admin/example_del/' + id).then(function(response) {
            self.getExamples();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getExamples();
      },
      getExamples: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'page=' + this.current_page;

        axios.get(encodeURI('/admin/examples?' + param)).then(function(response) {
          self.examples = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getExamples();
    }
  };
</script>