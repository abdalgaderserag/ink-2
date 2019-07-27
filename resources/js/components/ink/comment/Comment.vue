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
                <div>
                    <div @click="deleteComment">()</div>
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

            },
            deleteComment: function () {
                axios.delete('/api/comment/' + this.comment.id)
                    .then(response => {
                        this.$el.innerHTML = '';
                        this.$el.outerHTML = '';
                    });
            }
        }
    }
</script>

<style scoped>

</style>