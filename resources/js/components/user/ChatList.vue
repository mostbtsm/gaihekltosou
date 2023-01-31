<template>
  <div v-show="loaded" class="chat-list mt-3">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="consultation-tab" data-toggle="tab" href="#consultation" role="tab" aria-controls="consultation" aria-selected="true">相談中</a>
      </li>
    </ul>

    <div class="tab-content">
      <div id="consultation" class="tab-pane show active">
        <template v-if="threads.length > 0">
          <div class="chat-list-item" v-for="(thread, index) in threads" :key="index" @click="click(thread)">
            <div class="data">
              <div class="data-img">
                <img class="card-img-top" :src="thread.painter_profile_image" />
              </div>
              <div class="data-body">
                <div class="data-name">
                  <div class="data-name-text">
                    {{ thread.painter.name }}
                  </div>
                  <div class="data-date">
                    {{ thread.recent_message_time }}
                  </div>
                </div>
                <div class="data-content">
                  <div class="data-content-text">
                    {{ thread.recent_message }}
                  </div>
                  <a v-if="thread.user_unread_count > 0" href="#">{{ thread.user_unread_count }}</a>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="chat-list-item">
            <div class="data">
              <div class="data-body">
                <div class="data-name">相談中の業者は存在しません</div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import { Web } from "js/route/user.js";
import { mapGetters } from 'vuex';

export default {
  data() {
    return {
      loaded: false,
    };
  },
  computed: {
    ...mapGetters('ChatThread', [
      'threads',
    ]),
  },
  created() {
    this.$store.dispatch('ChatThread/searchUserThreads', {}).then(() => {
      this.loaded = true;
    });
  },
  methods: {
    click(thread) {
      location.href = Web.chat.id(thread.id);
    },
  },
};
</script>