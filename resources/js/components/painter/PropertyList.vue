<template>
  <div>
    <div class="row mt-3 mb-3">
      <h3 class="col-md-10">登録画像</h3>
      <div v-if="is_edit" class="col-md-2 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" @click="toggleEdit">戻る</button>
      </div>
    </div>

    <div v-if="!is_edit" class="row">
      <div v-for="(property, key) in properties" :key="key" class="col-md-4 mb-5">
        <div class="card">
          <div class="card-body mypage-property-image" :style="{ backgroundImage: 'url(' + property.image1 + ')' }">
            <h5 class="card-title">{{ property.name }}</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-5 col-property-image">
        <div class="card text-center" @click="toggleEdit">
          <div class="card-body d-flex justify-content-center align-items-center mypage-property-image">
            <h5 class="card-title">+</h5>
          </div>
        </div>
      </div>
    </div>
    <PropertyForm v-else :edit_complete="editComplete"></PropertyForm>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import PropertyForm from "js/components/painter/PropertyForm.vue";

export default {
  data() {
    return {
      is_edit: false,
      properties: [],
    };
  },
  mounted() {
    this.reload();
  },
  methods: {
    toggleEdit() {
      this.is_edit = !this.is_edit;
    },
    reload() {
      axios.get(Api.properties).then(response => {
        if (response.data) {
          this.properties = response.data;
        }
      }).catch(error => {
        console.log(error);
      });
    },
    editComplete() {
      this.toggleEdit();
      this.reload();
    },
  },
  components: {
    PropertyForm,
  },
};
</script>