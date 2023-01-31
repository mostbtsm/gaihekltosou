import axios from 'axios';
import { Api as UserApi } from "js/route/user.js";
import { Api as PainterApi } from "js/route/painter.js";

export default {
  async loadMyExamples({ commit }) {
    await axios.get(PainterApi.example.index).then(response => {
      commit('examples', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async loadMyExample({ commit }, id) {
    await axios.get(PainterApi.example.id(id)).then(response => {
      commit('examples', [response.data]);
    }).catch(e => {
      throw e;
    });
  },

  async loadPainterExamples({ commit }, id) {
    await axios.get(UserApi.example.painter(id)).then(response => {
      commit('examples', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async loadExample({ commit }, id) {
    await axios.get(UserApi.example.id(id)).then(response => {
      commit('examples', [response.data]);
    }).catch(e => {
      throw e;
    });
  },

  async search({ commit }, params) {
    commit('params', params);

    await axios.get(UserApi.example.index, { params: params }).then(response => {
      commit('examples', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },

  async fetch({ commit, getters }) {
    await axios.get(UserApi.example.index, { params: Object.assign(getters.params, { page: getters.page + 1 }) }).then(response => {
      commit('pushExamples', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },
};