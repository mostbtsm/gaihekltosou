export const state = {
  favorites: [],
};

export const getters = {
  favorites: state => state.favorites,

  isFavorite: state => painter_id => {
    return state.favorites.some(favorite => favorite.painter_id === painter_id);
  },
};

export const mutations = {
  favorites(state, value) {
    state.favorites = value;
  },
  pushFavorites(state, value) {
    state.favorites = state.favorites.concat(value);
  },
  removeFavorites(state, value) {
    state.favorites = state.favorites.filter(favorite => favorite.painter_id !== value);
  },
};