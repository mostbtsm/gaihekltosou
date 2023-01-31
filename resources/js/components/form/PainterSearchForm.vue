<template>
  <div class="create-form">
    <form id="form" @submit.prevent="submitForm" method="post">
      <div class="form-div" v-for="(param, key) in form_params" :key="key">
        <label :for="param.name">{{param.label}}</label>
          <FormInput 
            :id="param.id"
            :name="param.name"
            :type="param.type"
            :title="param.title"
            :placeholder="param.placeholder"
            :errors="param.errors"
            v-model="param.value"
          ></FormInput>
      </div>
      <div class="btn-area">
        <a href="" class="btn-confirm" @click="">検索</a>
      </div>
    </form>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import { mapGetters } from 'vuex';
import FormInput from "js/components/form/FormInput.vue";

export default {
 data() {
    return {
      form_params: {
        area1: {
          id: "area",
          name: "area",
          type: "select",
          label: "施工地域",
          value: "",
          placeholder: "",
          errors: [],
        },
        area2: {
          id: "area",
          name: "area",
          type: "input",
          label: "",
          value: "",
          placeholder: "市区町村",
          errors: [],
        },
        details: {
          id: "details",
          name: "details",
          type: "select",
          label: "施工内容",
          value: "",
          placeholder: "",
          errors: [],
        },
        scale: {
          id: "scale",
          name: "scale",
          type: "select",
          label: "施工規模",
          value: "",
          placeholder: "",
          errors: [],
        },
        rank: {
          id: "rank",
          name: "rank",
          type: "select",
          label: "社格",
          value: "",
          placeholder: "",
          errors: [],
        },
        years: {
          id: "years",
          name: "years",
          type: "select",
          label: "会社設立年数",
          value: "",
          placeholder: "",
          errors: [],
        },
        accident: {
          id: "accident",
          name: "accident",
          type: "select",
          label: "労災保険",
          value: "",
          placeholder: "",
          errors: [],
        },
        salesman: {
          id: "salesman",
          name: "salesman",
          type: "select",
          label: "営業マン",
          value: "",
          placeholder: "",
          errors: [],
        },
        annual: {
          id: "annual",
          name: "annual",
          type: "select",
          label: "会社年間売上",
          value: "",
          placeholder: "",
          errors: [],
        },
        employees_num: {
          id: "employees_num",
          name: "employees_num",
          type: "select",
          label: "社員数",
          value: "",
          placeholder: "",
          errors: [],
        },
        qualification: {
          id: "qualification",
          name: "qualification",
          type: "select",
          label: "資格",
          value: "",
          placeholder: "",
          errors: [],
        },

        permit: {
          id: "permit",
          name: "permit",
          type: "text",
          label: "建設業許可",
          value: "",
          placeholder: "無",
          errors: [],
        },
        results: {
          id: "results",
          name: "results",
          type: "text",
          label: "施工実績",
          value: "",
          placeholder: "000",
          errors: [],
        },
        column: {
          id: "column",
          name: "column",
          type: "select",
          label: "口コミ",
          value: "",
          placeholder: "",
          errors: [],
        },
        evaluation: {
          id: "evaluation",
          name: "evaluation",
          type: "select",
          label: "評価",
          value: "",
          placeholder: "",
          errors: [],
        },
      }
    };
  },  
  methods: {

  },

  components: {
    FormInput,
  },
};
</script>