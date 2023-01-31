<template>
    <div class="sidebar bg-dark">
        <div class="side_title">
            株式会社七色
        </div>
       <div class="menu">
            <div @click="activate(0)"><div class="menu_title" :class="{ active : active_el == 0 }">管理者一覧管理</div></div>
            <div @click="activate(1)"><div class="menu_title" :class="{ active : active_el == 1 }">業者一覧管理</div></div>
            <div @click="activate(2)"><div class="menu_title" :class="{ active : active_el == 2 }">お客様一覧管理</div></div>
            <div @click="activate(3)"><div class="menu_title" :class="{ active : active_el == 3 }">コラム一覧管理</div></div>
            <div @click="activate(4)"><div class="menu_title" :class="{ active : active_el == 4 }">施工事例一覧管理</div></div>
            <div @click="activate(5)"><div class="menu_title" :class="{ active : active_el == 5 }">口コミ・評価一覧管理</div></div>
            <div @click="activate(6)"><div class="menu_title" :class="{ active : active_el == 6 }">お知らせ管理</div></div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    kind: Number
  },
  methods: {
    activate: function(el){
        location.href = '/admin/' + this.url[el];
    }
  },
  data: function() {
    return {
        url: ['administrator_list', 'painter_list', 'user_list', 'column_list', 'example_list', 'evaluation_list', 'notice_list'],
        active_el: 1
    };
  },
  mounted() {
    this.active_el = this.kind;
  }
};
</script>