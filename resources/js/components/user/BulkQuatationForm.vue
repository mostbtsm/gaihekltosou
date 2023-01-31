<template>
<div>

    <div class=" form-container quote-section ">
        <div class="section-title">施工内容</div>
        <div class="section-content">
            <div class="notice">*複数選択可</div>
            <div v-for="(item, index) in categories.options" class="row">
                <div v-for="n in 2" class="col-6">
                    <a v-if="item[n - 1] != ''" @click="selectCategory(index * 2 + n - 1)" :id="'category_' + (index * 2 + n - 1)" href="javascript:void(0)" class="btn btn-quotation" role="button" aria-disabled="true">{{ item[n - 1] }}</a>
                    <input v-model="category_id" type="checkbox" v-if="item[n - 1] != ''" name="category[]" :id="'category_chk_' + (index * 2 + n - 1)" :value="index * 2 + n - 1" style="display:none;" />
                </div>
            </div>
        </div>
    </div>

    <div class="form-container quote-section">
        <div class="section-title">工事に求める物</div>
        <div class="section-content">
            <div class="notice">*複数選択可</div>
            <div class="row">
                <div v-for="(item, index) in priorities.options" class="col-12">
                    <a @click="selectPriority(index)" :id="'priority_' + index" href="javascript:void(0)" class="btn btn-quotation" role="button" aria-disabled="true">{{ item }}</a>
                    <input v-model="priority_id" type="checkbox" name="priority[]" :id="'priority_chk_' + index" :value="index" style="display:none;" />
                </div>
            </div>
        </div>
    </div>

    <div class="form-container quote-section">
        <div class="section-title">工期予定</div>
        <div class="section-content">
            <div class="row">
                <div v-for="(item, index) in periods.options" class="col-12">
                    <a @click="selectPeriod(index)" :id="'period_' + index" href="javascript:void(0)" class="btn btn-quotation" role="button" aria-disabled="true">{{ item }}</a>
                    <input v-model="period_id" type="radio" name="period" :id="'period_chk_' + index" :value="index" style="display:none;" />
                </div>
            </div>
        </div>
    </div>

   <div class="form-container quote-section">
        <div class="section-title">建物について</div>
        <div class="section-content">
            <div class="row">
                <div class="col-4 pl-5">
                    <label>登録済物件</label>
                </div>
                <div v-if="property_data.length !== 0" class="col-8">
                    <div class="select-area">
                        <select v-model="property_id" name="property_id" @change="selectProperty()" class="w-100">
                            <option v-for="data in property_data" :key="data.id" :value="data.id">{{ data.name ? data.name : '物件ID：' + data.id }}</option>
                        </select>
                    </div>
                </div>
                <div v-else class="col-8">
                    <label style="color:red">物件が１件も登録されていません。</label>
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    <label>タイプ</label>
                </div>
                <div class="col-4">
                    <div class="select-area">
                        <select v-model="type" name="type" id="type" @change="numDisabled()" class="w-100">
                            <option v-for="(item, index) in properties.options" :value="index">{{ item }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" v-model="num" name="num" id="num" size="8" style="ime-mode: disabled;text-align: right;" disabled="disabled" />
                    戸
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    階数
                </div>
                <div class="col-8">
                    <input type="text" v-model="floors" name="floors" size="8" style="ime-mode: disabled;text-align: right;" />
                    階
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    築年数
                </div>
                <div class="col-8">
                    <input type="text" v-model="age" name="age" size="8" style="ime-mode: disabled;text-align: right;" />
                    年
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    敷地面積
                </div>
                <div class="col-8">
                    <input type="text" v-model="area" name="area" size="8" style="ime-mode: disabled;text-align: right;" />
                    ㎡
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    建坪
                </div>
                <div class="col-8">
                    <input type="text" v-model="area_b" name="area_b" size="8" style="ime-mode: disabled;text-align: right;" />
                    ㎡
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    屋根形状
                </div>
                <div class="col-8">
                   <div class="select-area">
                        <select v-model="type_roof" name="type_roof" class="w-100">
                            <option v-for="(item, index) in roofs.options" :value="index">{{ item }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    外壁形状
                </div>
                <div class="col-8">
                    <div class="select-area">
                        <select v-model="type_wall" name="type_wall" class="w-100">
                            <option v-for="(item, index) in walls.options" :value="index">{{ item }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 pl-5">
                    工事予算
                </div>
                <div class="col-8">
                    <input type="text" v-model="budget" name="budget" size="8" style="ime-mode: disabled;text-align: right;" />
                    万円
                </div>
            </div>
            <div class="row">
                <div class="col-12"><br /><br /></div>
            </div>
        </div>
    </div>

    <div class="form-container quote-section">
        <div class="section-title">工事内容に関して</div>
        <div class="section-content">
            <div class="row">
                <div class="col-12">
                    <textarea v-model="memo" name="memo"></textarea>
                </div>
<!--
                <div class="col-12" style="margin-bottom:50px">
                    <a @click="formSubmit()" class="btn btn-confirm" role="button" href="javascript:void(0)">確認する</a>
                </div>
-->
            </div>
        </div>
    </div>

    <div class="form-container quote-section">
        <div class="section-title">業者選択</div>
        <div class="section-content">
            <div v-if="favorites.length !== 0" class="row">
                <div v-for="favorite in favorites" :key="favorite.id" class="col-12">
                    <label><input v-model="painter_id" name="painter_id[]" type="checkbox" :value="favorite.painter_id" />{{ favorite.name }}</label>
                </div>
            </div>
            <div v-else class="row">
                <div class="col-12">
                    <label style="color:red">お気に入りに業者が１件も登録されていません。</label>
                </div>
            </div>
            <div class="row" style="margin-bottom:50px">
                <div v-if="getStatus()" class="col-12">
                    <a @click="formSubmit()" class="btn btn-confirm" role="button" href="javascript:void(0)">確認する</a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container quote-section" style="margin-bottom:50px">
        <div class="section-content">
            <div class="row" style="margin-bottom:50px">
                <div class="col-12"><br /><br /></div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
import { Api } from "js/route/user.js";
import { mapGetters } from 'vuex';

export default {
    props: ['userId'],
    data() {
        return {
            categories: {
                options: [],
            },
            priorities: {
                options: [],
            },
            periods: {
                options: [],
            },
            properties: {
                options: [],
            },
            roofs: {
                options: [],
            },
            walls: {
                options: [],
            },
            category_id: [],
            priority_id: [],
            period_id: -1,
            property_data: {},
            property_id: 0,
            type: -1,
            num: null,
            floors: null,
            age: null,
            area: null,
            area_b: null,
            type_roof: -1,
            type_wall: -1,
            budget: null,
            memo: '',
            favorites: {},
            painter_id: [],
        };
    },
    computed: {
        ...mapGetters('Config', [
            'category',
            'priority',
            'period',
            'property',
            'roof',
            'wall',
        ]),
    },
    mounted() {
        this.$store.dispatch('Config/load').then(() => {
            var arr = this.category;

            if (arr.length % 2 === 1) {
                arr.push('');
            }

            for (var i = 0; i < arr.length; i+= 2) {
                this.categories.options.push([arr[i], arr[i + 1]]);
            }

            this.priorities.options = this.priority;
            this.periods.options = this.period;
            this.properties.options = this.property;
            this.roofs.options = this.roof;
            this.walls.options = this.wall;
        });

        axios.get('/api/properties/0/' + this.userId).then(response => {
            this.property_data = response.data;
        });

        axios.get('/api/favorites/' + this.userId).then(response => {
            this.favorites = response.data;

            for (var i = 0; i < this.favorites.length; i++) {
                this.painter_id.push(this.favorites[i].painter_id);
            }
        });
    },
    methods: {
        selectCategory: function(id) {
            var class_org = 'btn btn-quotation';
            var flg = false;

            for (var i = 0; i < this.category_id.length; i++) {
                if (this.category_id[i] == id) {
                    document.getElementById('category_' + id).className = class_org;
                    document.getElementById('category_chk_' + id).checked = false;
                    this.category_id.splice(i, 1);
                    flg = true;
                    break;
                }
            }

            if (!flg) {
                document.getElementById('category_' + id).className = class_org + ' btn-green';
                document.getElementById('category_chk_' + id).checked = true;

                this.category_id.push(id);
            }
        },
        selectPriority: function(id) {
            var class_org = 'btn btn-quotation';
            var flg = false;

            for (var i = 0; i < this.priority_id.length; i++) {
                if (this.priority_id[i] == id) {
                    document.getElementById('priority_' + id).className = class_org;
                    document.getElementById('priority_chk_' + id).checked = false;
                    this.priority_id.splice(i, 1);
                    flg = true;
                    break;
                }
            }

            if (!flg) {
                document.getElementById('priority_' + id).className = class_org + ' btn-green';
                document.getElementById('priority_chk_' + id).checked = true;

                this.priority_id.push(id);
            }
        },
        selectPeriod: function(id) {
            var class_org = 'btn btn-quotation';

            if (id != this.period_id) {
                document.getElementById('period_' + id).className = class_org + ' btn-green';
                document.getElementById('period_chk_' + id).checked = true;

                if (this.period_id >= 0) {
                    document.getElementById('period_' + this.period_id).className = class_org;
                }

                this.period_id = id;
            }
        },
        selectProperty: function() {
            for (var i = 0; i < this.property_data.length; i++) {
                var data = this.property_data[i];

                if (data.id == this.property_id) {
                    this.type = data.type;
                    this.floors = data.floors;
                    this.age = data.age;
                    this.area = data.area;
                    this.area_b = data.area_b;
                    this.type_roof = data.type_roof;
                    this.type_wall = data.type_wall;
                    break;
                }
            }
        },
        numDisabled: function() {
            document.getElementById('num').disabled = this.type != 1 && this.type != 2;
        },
        formSubmit: function() {
            document.forms[0].submit();
        },
        getStatus: function() {
            return this.property_data.length !== 0 && this.favorites.length !== 0;
         },
    },
    components: {
    },
};
</script>