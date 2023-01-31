export const state = {
  examples: [],
  params: {},
  total: 0,
  page: 0,
};

export const getters = {
  examples: state => state.examples,
  params: state => state.params,
  total: state => state.total,
  page: state => state.page,

  findExample: state => example_id => {
    return state.examples.find(example => example.id === example_id);
  },
  hasNext: state => state.examples.length < state.total,
};

export const mutations = {
  examples(state, value) {
    state.examples = value;
  },
  pushExamples(state, value) {
    state.examples = state.examples.concat(value);
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