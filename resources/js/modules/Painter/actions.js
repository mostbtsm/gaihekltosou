import axios from 'axios';
import { Api as UserApi } from "js/route/user.js";
import { Api as PainterApi } from "js/route/painter.js";

export default {
  async loadPreview({ commit }) {
    await axios.get(PainterApi.show).then(response => {
      commit('painters', [response.data]);
      commit('total', 1);
      commit('page', 1);
    }).catch(e => {
      throw e;
    });
  },

  async LoadPainter({ commit }, id) {
    await axios.get(UserApi.painter.id(id)).then(response => {
      commit('painters', [response.data]);
      commit('total', 1);
      commit('page', 1);
    }).catch(e => {
      throw e;
    });
  },

  async search({ commit }, params) {
    commit('params', params);

    await axios.get(UserApi.painter.index, { params: params }).then(response => {
      commit('painters', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },

  async fetch({ commit, getters }) {
    await axios.get(UserApi.painter.index, { params: Object.assign(getters.params, { page: getters.page + 1 }) }).then(response => {
      commit('pushPainters', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },

  async searchFavorites({ commit }, params) {
    commit('params', params);

    await axios.get(UserApi.painter.favorite, { params: params }).then(response => {
      commit('painters', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },

  async fetchFavorites({ commit, getters }) {
    await axios.get(UserApi.painter.favorite, { params: Object.assign(getters.params, { page: getters.page + 1 }) }).then(response => {
      commit('pushPainters', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },
};