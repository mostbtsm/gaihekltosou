<template>
  <div class="chat-footer fixed-bottom">
    <div class="message-box">
      <div class="message-area">
        <textarea v-model="contents" :rows="contentsRows" class="message"></textarea>
      </div>
      <img @click="sendMessage()" :disabled="!contentsExists" class="message-send-icon" src="/image/message-send.png">
    </div>
  </div>
</template>

<script>
import { Api } from "js/route/user.js";

export default {
  props: {
    painter_id: {
      type: Number,
    },
  },
  data() {
    return {
      contents: '',
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
    contentsRows() {
      const num = this.contents.split("\n").length;
      return (num > 1) ? num : 1;
    },
  },
  methods: {
    sendMessage() {
      if (!this.contentsExists || !this.sendable) {
        return;
      }

      this.sendable = false;

      axios.post(Api.chat.index, {
        painter_id: this.painter_id,
        message: this.trimmedContents,
      }).then(response => {
        location.href = response.data.next;
      });
    },
  },
};
</script>