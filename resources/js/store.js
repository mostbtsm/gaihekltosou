import Vue from 'vue';
import Vuex from 'vuex';

import Config from 'js/modules/Config/index.js';
import Painter from 'js/modules/Painter/index.js';
import Property from 'js/modules/Property/index.js';
import Column from 'js/modules/Column/index.js';
import Example from 'js/modules/Example/index.js';
import Favorite from 'js/modules/Favorite/index.js';
import ChatThread from 'js/modules/ChatThread/index.js';
import ChatMessage from 'js/modules/ChatMessage/index.js';

require('es6-promise/auto');

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    Config,
    Painter,
    Property,
    Column,
    Example,
    Favorite,
    ChatThread,
    ChatMessage,
  }
});