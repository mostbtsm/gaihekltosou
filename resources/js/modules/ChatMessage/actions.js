import axios from 'axios';
const apiUrl = '/api/' + process.env.MIX_API_VER + '/chat';

export default {
  async search({ commit }, params) {
    commit('params', params);

    await axios.get(apiUrl, { params: params }).then(response => {
      commit('thread', response.data.thread);
      commit('messages', response.data.messages);
    }).catch(e => {
      throw e;
    });
  },

  async fetch({ commit, getters }) {
    await axios.get(apiUrl, { params: Object.assign(getters.params, { message_id: getters.lastMessageId }) }).then(response => {
      commit('thread', response.data.thread);
      commit('pushMessages', response.data.messages);
    }).catch(e => {
      throw e;
    });
  },
};