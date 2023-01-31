export const state = {
  painters: [],
  params: {},
  total: 0,
  page: 0,
};

export const getters = {
  painters: state => state.painters,
  params: state => state.params,
  total: state => state.total,
  page: state => state.page,

  findPainter: state => painter_id => {
    return state.painters.find(painter => painter.id === painter_id);
  },
  hasNext: state => state.painters.length < state.total,
};

export const mutations = {
  painters(state, value) {
    state.painters = value;
  },
  pushPainters(state, value) {
    state.painters = state.painters.concat(value);
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