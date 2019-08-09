<template>
    <div>
        <!--<div v-if="comments.length != 0">-->
        <div v-for="comment in comments">
            <reply :comment="getComment(comment)"></reply>
        </div>
        <!--</div>-->
    </div>
</template>

<script>
    export default {
        name: "Replies",
        props: {
            comments: {
                type: Array,
                required: true,
            }
        },
        methods: {
            getComment: function (comment) {
                if (comment.media.media) {
                    let media = comment.media.media;
                    try {
                        media = media.split(',').slice(0, -1);
                        comment.media.media = media;
                    } catch (e) {
                    }
                }
                return comment;
            }
        }
    }
</script>

<style scoped>

</style>