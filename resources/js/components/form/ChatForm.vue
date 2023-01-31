<template>
    <div>
        <form class="form-changes chat-form">             
            <div class="form-body chat-body" :class = "addItem ? 'form-body chat-body add-new-item':'form-body chat-body'">
                <div v-for="message in messages" :key="message.id">
                    <div class="chat-date">{{ message.m_date }} {{ message.m_time }}</div>                 
                    <div v-if="message.flg">
                        <div class="message my-message"> 
                            <div class="message-body">
                                <div v-if="message.type === 'IMG'">
                                    <div class="message-text"><img width="160" height="120" :src="message.contents" /></div>
                                </div>
                                <div v-else-if="message.type === 'PDF'">
                                    <div class="message-text"><a :href="message.contents" target="_blank">PDFファイルを表示</a></div>
                                </div>
                                <div v-else>
                                    <div class="message-text">{{ message.contents }}</div>
                                </div>
                            </div>
                            <!-- <div class="avatar">{{message.name.length>2?message.name.substring(1, 2):""}}</div> -->
                            <br>
                        </div>           
                    </div>
                    <div v-else>
                        <div class="message"> 
                            <div class="message-body">
                                <div v-if="message.type === 'IMG'">
                                    <div class="message-text"><img width="160" height="120" :src="message.contents" /></div>
                                </div>
                                <div v-else-if="message.type === 'PDF'">
                                    <div class="message-text"><a :href="message.contents" target="_blank">PDFファイルを表示</a></div>
                                </div>
                                <div v-else>
                                    <div class="message-text">{{ message.contents }}</div>
                                </div>
                            </div>
                            <div class="avatar">{{ message.name?message.name.substring(1, 2):""}}</div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-footer" style="border-top: 1px solid black">
                <div class="message-box">
                    <img @click="onAddItem()" class="cancel-icon" :src="addItem ? '/image/cross.png' : '/image/plus.png'">
                    <img class="message-icon" src="/image/message.png">
                    <div class="message-area">
                        <span @keyup="setMessage()" id="contents" class="textarea message" role="textbox" contenteditable></span>
                        <!-- <textarea class="message" style="width: 100%; height: 100%;outline: none;"></textarea> -->
                    </div>
                   <img @click="sendMessage()" :disabled="contentsExists" class="message-send-icon" src="/image/message-send.png">
                </div>
                <div v-if="addItem" class="message-item-list">
                    <div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="" >
                                
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
<!--
        <div>
            <p><input type="file" ref="image" @change="fileSelected()" /></p>
            <button @click="fileUpload()" :disabled="fileExists">アップロード</button>
        </div>
-->
    </div>
</template>

<script>
    export default {
        props: ['userId', 'painterId', 'requestId', 'messageKey'],
        data() {
            return {
                addItem:false,
                contents: '',
                image: null,
                messages: {}
            };
        },
        methods: {
            getMessage: function() {
                var self = this;
                var data = new FormData();

                data.append('user_id', this.userId);
                data.append('painter_id', this.painterId);
                data.append('request_id', this.requestId);
                data.append('message_key', this.messageKey);

                axios.post('/api/message', data).then(function(response) {
                    self.messages = response.data;
                    var elm = document.getElementsByClassName('chat-body')[0];
                    elm.scrollTop = elm.scrollHeight;
                });
            },
            fileSelected: function() {
                this.image = null;

                if (this.$refs.image && this.$refs.image.value) {
                    this.image = this.$refs.image.files[0];
                }
            },
            fileUpload: function() {
                var self = this;
                var data = new FormData();

                data.append('user_id', this.userId);
                data.append('painter_id', this.painterId);
                data.append('request_id', this.requestId);
                data.append('image', this.image);
                data.append('message_key', this.messageKey);

                axios.put('/api/message', data, {headers: {'Content-Type': 'multipart/form-data'}}).then(function() {
                    self.clearMessage();
                    self.getMessage();
                });
            },
            setMessage: function() {
                this.contents = document.getElementById('contents').textContent;
            },
            clearMessage: function() {
                document.getElementById('contents').textContent = '';
                this.contents = '';
            },
            sendMessage: function() {
                var self = this;
                var data = {user_id: this.userId, painter_id: this.painterId, request_id: this.requestId, contents: this.contents, message_key: this.messageKey};

                axios.put('/api/message', data).then(function() {
                    self.clearMessage();
                    self.getMessage();
                });
            },
            onAddItem:function(){
                this.addItem=!this.addItem;
            }
        },
        computed: {
            contentsExists() {
                return this.contents.length == 0;
            },
            fileExists() {
                return this.image == null;
            }
        },
        mounted() {
            this.getMessage();

            var _channel = "message-channel-" + this.requestId + "-" + this.painterId;
            var self = this;

            Echo.channel(_channel).listen("MessageSent", function(e) {
                self.getMessage();
            });
        }
    };
</script>
