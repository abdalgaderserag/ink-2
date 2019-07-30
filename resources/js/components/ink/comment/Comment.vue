<template>
    <div>
        <div class="flex-box" style="justify-content: flex-start">
            <div>
                <img style="height: 48px;border-radius: 50%;" :src="comment.user.avatar" alt="">
            </div>
            <div>
                <div>
                    <span><a href="/profile" class="link-clear"
                             style="font-size: 2vh;">{{ comment.user.name }}</a></span>
                </div>
                <div>{{ comment.media.text }}</div>
                <div v-for="image in comment.media.media">
                    <img style="max-width: 120px;" :src="image">
                </div>
                <div>
                    <div @click="editComment">()</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Comment",
        props: {
            comment: {
                type: Object,
                required: true,
            }
        },
        methods: {
            editComment: function () {
                mediaTemp = {
                    text: this.comment.media.text,
                    media: this.comment.media.media,
                };
                pop();
                let text = document.getElementById('pop-text');
                text.value = text.value.slice(0, text.value.length - 1);
                let id = this.comment.id;
                let save = document.getElementById('save');
                save.onclick = () => {
                    if (text.value == '')
                        return;
                    axios.put('/api/comment/' + id, {
                        text: text.value,
                        media: mediaTemp.media,
                    });
                    this.comment.media.text = text.value;
                    this.comment.media.media = mediaTemp.media;
                    text.value = '';
                    mediaTemp.media = [];
                    mediaTemp.text = '';
                    document.getElementById('pop-up').style.display = 'none';
                };
            },
            deleteComment: function () {
                axios.delete('/api/comment/' + this.comment.id)
                    .then(response => {
                        this.$el.innerHTML = '';
                        this.$el.outerHTML = '';
                    });
            },
        }
    }
</script>

<style scoped>

</style>