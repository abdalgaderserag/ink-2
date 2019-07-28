<template>
    <div>
        <div v-if="comments.length != 0" v-for="comment in comments">
            <comment :comment="getComment(comment)"></comment>
        </div>
        <div v-else>
            <h1>No Comments</h1>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Comments",
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
                    }catch (e) {
                    }
                }
                return comment;
            }
        }
    }
</script>

<style scoped>

</style>