export const state = {
  loaded: false,
  config: {},
};

export const getters = {
  loaded: state => state.loaded,
  select: state => state.config?.['select'] ?? [],
  image: state => state.config?.['image'] ?? [],

  prefecture: (state, getters) => getters.select?.['prefecture'] ?? [],
  sales: (state, getters) => getters.select?.['sales'] ?? [],
  category: (state, getters) => getters.select?.['category'] ?? [],
  property: (state, getters) => getters.select?.['property'] ?? [],
  roof: (state, getters) => getters.select?.['roof'] ?? [],
  wall: (state, getters) => getters.select?.['wall'] ?? [],
  column: (state, getters) => getters.select?.['column'] ?? [],
  priority: (state, getters) => getters.select?.['priority'] ?? [],
  period: (state, getters) => getters.select?.['period'] ?? [],
  warranty: (state, getters) => getters.select?.['warranty'] ?? [],
  amount: (state, getters) => getters.select?.['amount'] ?? [],
  construction_period: (state, getters) => getters.select?.['construction_period'] ?? [],
};

export const mutations = {
  loaded(state, value) {
    state.loaded = value;
  },
  config(state, value) {
    state.config = value;
  },
};