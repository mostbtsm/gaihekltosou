<template>

<div>

    <form id="searchForm" class="search-form" onSubmit="return false;">
        <div class='search' style="margin-bottom:10px;">
            <div class='search_box'>
                <img src="/image/search.svg" alt="" class="searchImage" />
                <input v-model.lazy="args" id="search_input" value="" class="search_text" name="search_keyword" />
            </div>
            <button class="search-btn" @click="getEvaluations">検索</button>
        </div>
    </form>

    <div style="height:500px;width:100%;vertical-align:top;overflow:auto;margin-bottom:10px;">
        <table class="trader-table" style="width:940px;table-layout:fixed;white-space:nowrap;margin-top:10px;margin-bottom:0;">
            <tr>
                <th style="width:40px;">ID</th>
                <th style="width:280px;">業者名</th>
                <th style="width:350px;">お客様氏名</th>
                <th style="width:90px;">ステータス</th>
                <th style="width:180px;">機能</th>
            </tr>
            <tr v-for="evaluation in evaluations" :key="evaluation.id">
                <td><p>{{ evaluation.id }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ evaluation.name }}</p></td>
                <td style="text-align:left;padding-left:2px;overflow:hidden;"><p>{{ evaluation.name1 }}　{{ evaluation.name2 }}</p></td>
                <td><p>{{ evaluation.deleted_at ? '削除済' : '' }}</p></td>
                <td>
                    <a href="javascript:void(0)" @click="detailEvaluation(evaluation.id)">詳細確認</a>
                    <a v-if="evaluation.deleted_at === null" href="javascript:void(0)" style="margin-left:5px;" @click="deleteEvaluation(evaluation.id)">削除する</a>
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
        evaluations: [],
        args: '',
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
      detailEvaluation: function(id) {
        var w = 480;
        var h = 900;
        var left = window.innerWidth / 2 - (w / 2);
        var top = window.innerHeight / 2 - (h / 2);
        var opt = 'top=' + top + ',left=' + left + ',width=' + w + ',height=' + h;

        // window.open('/evaluation/detail/' + id, 'evaluation_detail', opt);
      },
      deleteEvaluation: function(id) {
        var self = this;

        if (confirm('ID:' + id + 'の評価データを削除します。よろしいですか？')) {
          axios.delete('/admin/evaluation_del/' + id).then(function(response) {
            self.getEvaluations();
          });
        }
      },
      change: function(page) {
        this.current_page = page;

        this.getEvaluations();
      },
      getEvaluations: function() {
        var self = this;
        var param = (this.args == '' ? '' : 'args=' + this.args + '&') + 'page=' + this.current_page;

        axios.get(encodeURI('/admin/evaluations?' + param)).then(function(response) {
          self.evaluations = response.data.data;
          self.current_page = response.data.current_page;
          self.last_page = response.data.last_page;
        });
      }
    },
    mounted() {
      this.getEvaluations();
    }
  };
</script>