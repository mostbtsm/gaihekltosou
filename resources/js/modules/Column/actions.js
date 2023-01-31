import axios from 'axios';
import { Api as UserApi } from "js/route/user.js";
import { Api as PainterApi } from "js/route/painter.js";

export default {
  async loadMyColumns({ commit }) {
    await axios.get(PainterApi.column.index).then(response => {
      commit('columns', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async loadMyColumn({ commit }, id) {
    await axios.get(PainterApi.column.id(id)).then(response => {
      commit('columns', [response.data]);
    }).catch(e => {
      throw e;
    });
  },

  async loadPainterColumns({ commit }, id) {
    await axios.get(UserApi.column.painter(id)).then(response => {
      commit('columns', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async loadColumn({ commit }, id) {
    await axios.get(UserApi.column.id(id)).then(response => {
      commit('columns', [response.data]);
    }).catch(e => {
      throw e;
    });
  },

  async search({ commit }, params) {
    commit('params', params);

    await axios.get(UserApi.column.index, { params: params }).then(response => {
      commit('columns', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },

  async fetch({ commit, getters }) {
    await axios.get(UserApi.column.index, { params: Object.assign(getters.params, { page: getters.page + 1 }) }).then(response => {
      commit('pushColumns', response.data.data);
      commit('total', response.data.total);
      commit('page', response.data.current_page);
    }).catch(e => {
      throw e;
    });
  },
};