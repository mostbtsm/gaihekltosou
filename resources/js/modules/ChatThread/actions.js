import axios from 'axios';
import { Api as UserApi } from "js/route/user.js";
import { Api as PainterApi } from "js/route/painter.js";

export default {
  async searchUserThreads({ commit }, params) {
    commit('params', params);

    await axios.get(UserApi.chat.index, { params: params }).then(response => {
      commit('threads', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async searchPainterThreads({ commit }, params) {
    commit('params', params);

    await axios.get(PainterApi.chat.index, { params: params }).then(response => {
      commit('threads', response.data);
    }).catch(e => {
      throw e;
    });
  },
};