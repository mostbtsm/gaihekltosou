<template>
  <div>
    <div class="row mt-3 mb-3">
      <h3 class="col-md-10">物件情報</h3>
      <div v-if="is_edit" class="col-md-2 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" @click="toggleEdit">戻る</button>
      </div>
    </div>

    <div v-if="!is_edit" class="row">
      <div v-for="(property, key) in properties" :key="key" class="col-md-4 mb-5" @click="update(property.id)">
        <div class="card">
          <div class="card-body mypage-property-image d-flex align-items-end" :style="{ backgroundImage: 'url(' + property.image1 + ')' }">
            <div class="mypage-property-title">
              <h5>{{ property.name }}</h5>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-5 col-property-image">
        <div class="card text-center" @click="create">
          <div class="card-body d-flex justify-content-center align-items-center mypage-property-image">
            <h5>+</h5>
          </div>
        </div>
      </div>
    </div>
    <PropertyForm v-else :property_id="edit_property_id" :edit_complete="editComplete"></PropertyForm>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import PropertyForm from "js/components/user/PropertyForm.vue";

export default {
  data() {
    return {
      is_edit: false,
      edit_property_id: null,
    };
  },
  computed: {
    ...mapGetters('Property', [
      'properties',
    ]),
  },
  mounted() {
    this.reload();
  },
  methods: {
    toggleEdit() {
      this.is_edit = !this.is_edit;
    },
    create() {
      this.edit_property_id = null;
      this.is_edit = true;
    },
    update(id) {
      this.edit_property_id = id;
      this.is_edit = true;
    },
    reload() {
      this.$store.dispatch('Property/loadUserProperties').then(() => {
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