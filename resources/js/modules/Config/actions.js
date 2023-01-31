import axios from 'axios';
import { Api } from "js/route/common.js";

export default {
  async load({ commit, getters }) {
    if (!getters.loaded) {
      await axios.get(Api.config).then((response) => {
        commit('config', response.data);
        commit('loaded', true);
      }).catch((e) => {
        throw e;
      });
    }
  },
};