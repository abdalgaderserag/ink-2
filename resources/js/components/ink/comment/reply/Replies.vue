<template>
    <div>
        <div>
            <div v-for="comment in comments">
                <reply :comment="comment"></reply>
            </div>
        </div>
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
    }
</script>

<style scoped>

</style>