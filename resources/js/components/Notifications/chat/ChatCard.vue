<template>
    <div>
        <div @click="showMessage">
            {{ chat.user.name }}
        </div>
        <div></div>
    </div>
</template>

<script>
    export default {
        name: "ChatCard",
        data() {
            return {
                messages: [],
            }
        },
        props: {
            chat: {
                type: Object,
                required: true,
            }
        }, methods: {
            showMessage: function () {
                axios.get('/api/chat/' + this.chat.id).then(response => {
                    // let data;
                    // let hasNext = true;
                    // for (let i = 0; i < response.data.length; i++) {
                    //     let count = 0;
                    //     while (hasNext) {
                    //         hasNext = false;
                    //         data[count] = response.data[i].data;
                    //         if (i + 1 > response.data.length)
                    //             break;
                    //         else if (data[count].user_id == response.data[i + 1].data) {
                    //             hasNext = true;
                    //             count++;
                    //             i++;
                    //         }
                    //     }
                    //     this.messages[i] = data;
                    // }
                    this.messages = response.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>