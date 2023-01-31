import axios from 'axios';
import { Api  } from "js/route/user.js";

export default {
  async loadFavorites({ commit }) {
    await axios.get(Api.favorite.index).then(response => {
      commit('favorites', response.data);
    }).catch(e => {
      throw e;
    });
  },

  async addFavorite({ commit }, id) {
    axios.post(Api.favorite.index, { id: id }).then(response => {
      commit('pushFavorites', [{ painter_id: id }]); // 仮のオブジェクトを挿入しておく
    }).catch(e => {
      throw e;
    });
  },

  async removeFavorite({ commit }, id) {
    axios.delete(Api.favorite.id(id)).then(response => {
      commit('removeFavorites', id);
    }).catch(e => {
      throw e;
    });
  },
};