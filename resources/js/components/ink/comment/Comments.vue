<template>
    <div>
        <div v-if="comments.length != 0" v-for="comment in comments">
            <!--{{ comment[0] }}-->
            <comment :comment="comment"></comment>
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
    }
</script>

<style scoped>

</style>