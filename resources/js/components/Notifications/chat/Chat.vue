<template>
    <div class="chat-content">
        <div v-for="chat in chats">
            <chat-card :chat="getChat(chat)"></chat-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Chat",
        data() {
            return {
                chats: []
            }
        },
        mounted() {
            this.getChats();
        },
        methods: {
            getChats: function () {
                axios.get('/api/chat').then(response => {
                    this.chats = response.data;
                });
            },
            getChat: function (chat) {
                let user = this.$root.user;
                let data = {};
                data.id = chat.id;
                if (chat.first.id == user.id)
                    data.user = chat.second;
                else if (chat.second.id == user.id)
                    data.user = chat.first;
                return data;
            }
        }
    }
</script>

<style scoped>
    .chat-content {
        padding: 18px 2%;
    }
</style>