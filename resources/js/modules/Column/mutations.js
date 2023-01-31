export const state = {
  columns: [],
  params: {},
  total: 0,
  page: 0,
};

export const getters = {
  columns: state => state.columns,
  params: state => state.params,
  total: state => state.total,
  page: state => state.page,

  findColumn: state => column_id => {
    return state.columns.find(column => column.id === column_id);
  },
  hasNext: state => state.columns.length < state.total,
};

export const mutations = {
  columns(state, value) {
    state.columns = value;
  },
  pushColumns(state, value) {
    state.columns = state.columns.concat(value);
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