export const state = {
  thread: {},
  messages: [],
  params: {},
};

export const getters = {
  thread: state => state.thread,
  messages: state => state.messages,
  params: state => state.params,

  findMessage: state => message_id => {
    return state.messages.find(message => message.id === message_id);
  },
  lastMessageId: state => state.messages.length > 0 ? state.messages[state.messages.length - 1].id : '',
};

export const mutations = {
  thread(state, value) {
    state.thread = value;
  },
  messages(state, value) {
    state.messages = value;
  },
  pushMessages(state, value) {
    state.messages = state.messages.concat(value);
  },
  params(state, value) {
    state.params = value;
  },
};