<template>
    <div>
        <div @click="showMessage">
            {{ chat.user.name }}
        </div>


        <div class="chat-box" style="display: none">
            <div class="chat-box-order flex-box">
                <div>
                    <div class="flex-box" style="width: 100%;background-color: #f98835;justify-content: flex-start">
                        <img src="/images/avatars/b2c4312d-d08f-40f8-9f7b-5e4c6f213e0a.png"
                             style="margin:4px 0 4px 7px;width: 32px;height: 32px;border-radius: 50%;border: 2px solid #fff;">
                        <div style="padding: 11px 0 0 9px;color:#fff">
                            {{ chat.user.name }}
                        </div>
                    </div>
                    <div v-for="message in messages"
                         :class="{'user-message': displayMessage(message),'message':true}">
                        {{ message.data.text }}
                    </div>
                </div>
                <div class="flex-box">
                    <input type="text" v-model="text" style="width: 60%;border-width: 1px 0">
                    <button style="width: 20%;border: 1px solid #878787">img</button>
                    <button style="width: 20%;border: 1px solid #878787" @click="sendMessage()" @submit="sendMessage()">
                        send
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatCard",
        data() {
            return {
                messages: [],

                text: '',
                media: [],

                called: false,
            }
        },
        props: {
            chat: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            this.$el.getElementsByClassName('chat-box')[0].style.height = (height * 0.7) + 'px';
        },
        methods: {
            showMessage: function () {
                let chats = document.getElementsByClassName('chat-box');
                for (let i = 0; i < chats.length; i++)
                    chats[i].style.display = 'none';
                if (!this.called)
                    this.getMessage();
            },
            getMessage: function () {
                axios.get('/api/chat/' + this.chat.id).then(response => {
                    /*let data;
                    let hasNext = true;
                    for (let i = 0; i < response.data.length; i++) {
                        let count = 0;
                        while (hasNext) {
                            hasNext = false;
                            data[count] = response.data[i].data;
                            if (i + 1 > response.data.length)
                                break;
                            else if (data[count].user_id == response.data[i + 1].data) {
                                hasNext = true;
                                count++;
                                i++;
                            }
                        }
                        this.messages[i] = data;
                    }*/
                    this.messages = response.data;
                    this.$el.getElementsByClassName('chat-box')[0].style.display = 'block';
                    this.called = true;
                });
            },
            sendMessage: function () {
                if (this.text != '' || this.media != []) {
                    axios.put('/api/chat/' + this.chat.id, {
                        text: this.text,
                        media: this.media,
                    }).then(response => {
                        this.messages[this.messages.length] = {
                            data: {
                                media: this.media,
                                text: this.text,
                                user_id: this.$root.user.id,
                            }
                        };
                        this.text = '';
                        this.media = [];
                    })
                }
            },
            displayMessage: function (id) {
                return (id.data.user_id != this.$root.user.id);
            }
        }
    }
</script>

<style scoped>
    .chat-box {
        background-color: white;
        position: fixed;
        bottom: 0;
        width: 25%;
        border: 1px solid #878787;
        overflow-y: auto;
    }

    .chat-box-order {
        flex-direction: column;
        justify-content: space-between;
    }

    .message {
        width: max-content;
        max-width: 75%;
        border-radius: 8px;
        padding: 4px 6px;
    }

    .user-message {
        margin: 1px 0;
        color: white;
        float: right;
        background-color: #f98835;
    }
</style>