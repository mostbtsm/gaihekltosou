<template>
  <div id="chat-footer" class="chat-footer fixed-bottom">
    <div class="message-box">
      <div class="message-area">
        <textarea id="contents" @keyup="setHeight" @keydown="setHeight" v-model="contents" :style="styleObject" class="message"></textarea>
      </div>
      <img @click="sendMessage()" :disabled="!contentsExists" class="message-send-icon" src="/image/message-send.png">
      <pre id="char-message-prev">{{ contents }}</pre>
    </div>
  </div>
</template>

<script>
import { Api as UserApi } from "js/route/user.js";
import { Api as PainterApi } from "js/route/painter.js";

export default {
  props: {
    thread_id: {
      type: Number,
      required: true,
    },
    user_id: {
      type: Number,
      default: null,
    },
    painter_id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      contents: '',
      contentsHeight: 0,
      sendable: true,
    };
  },
  computed: {
    trimmedContents() {
      return this.contents.trim();
    },
    contentsExists() {
      return this.trimmedContents.length > 0;
    },
    styleObject() {
      return {
        height: this.contentsHeight + 'px',
      };
    },
  },
  methods: {
    clearMessage() {
      this.contents = '';

      setTimeout(() => {
        this.setHeight();
      }, 200)
    },
    setHeight() {
      this.contentsHeight = document.getElementById('char-message-prev')?.clientHeight ?? 0;
    },
    sendMessage() {
      if (!this.contentsExists || !this.sendable) {
        return;
      }

      this.sendable = false;

      const url = this.user_id != null ? UserApi.chat.message : PainterApi.chat.message;

      axios.post(url, {
        thread_id: this.thread_id,
        message: this.trimmedContents,
      }).then(response => {
        this.clearMessage();
        this.sendable = true;
      });
    },
  },
};
</script>