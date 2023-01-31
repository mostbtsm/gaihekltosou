export const state = {
  threads: [],
  params: {},
  total: 0,
  page: 0,
};

export const getters = {
  threads: state => state.threads,
  params: state => state.params,
  total: state => state.total,
  page: state => state.page,

  findThread: state => thread_id => {
    return state.threads.find(thread => thread.id === thread_id);
  },
  hasNext: state => state.threads.length < state.total,
};

export const mutations = {
  threads(state, value) {
    state.threads = value;
  },
  pushThreads(state, value) {
    state.threads = state.threads.concat(value);
  },
  params(state, value) {
    state.params = value;
  },
  total(state, value) {
    state.total = value;
  },
  page(state, value) {
    state.page = value;
  },
};