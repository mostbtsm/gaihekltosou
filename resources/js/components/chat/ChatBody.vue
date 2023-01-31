<template>
  <div class="chat-body" :style="styleObject">
    <div v-for="message in messages" :key="message.id" class="chat-row" :class="message.is_my_message ? 'my-message' : ''">
      <div v-if="message.is_my_message" class="message my-message">
        <div class="message-header">{{ message.messaged_at }}</div>
        <div class="message-body">
          <div class="message-text">{{ message.contents }}</div>
        </div>
      </div>

      <div v-else class="message">
        <div class="message-header">{{ message.messaged_at }}</div>
        <div class="message-body">
          <div class="message-text">{{ message.contents }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  props: {
    thread_id: {
      type: Number,
      required: true,
    },
    thread_hash: {
      type: String,
      required: true,
    },
  },
  data(){
    return {
      margin: 0,
    };
  },
  computed: {
    ...mapGetters('ChatMessage', [
      'messages',
    ]),
    styleObject() {
      return {
        marginBottom: this.margin + 'px',
      };
    }
  },
  created() {

  },
  mounted() {
    const _channel = "message-channel-" + this.thread_hash;

    Echo.channel(_channel).listen("MessageSent", e => {
      this.$store.dispatch('ChatMessage/fetch').then(() => {
        this.keepBottom();
      });
    });

    this.$store.dispatch('ChatMessage/search', { thread_id: this.thread_id }).then(() => {
      this.keepBottom();

      window.addEventListener('keyup', () => {
        this.setMargin();
      });
    });
  },
  methods: {
    keepBottom() {
      this.setMargin().then(() => this.scrollToBottom());
    },
    async setMargin() {
      this.margin = (document.getElementById('chat-footer')?.clientHeight ?? 0);
    },
    scrollToBottom() {
      window.scroll(0, document.documentElement.scrollHeight - document.documentElement.clientHeight);
    },
  },
};
</script>