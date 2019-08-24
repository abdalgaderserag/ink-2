<template>
    <div></div>
</template>

<script>
    export default {
        name: "ChatView",
        data() {
            return {
                userId: this.$root.user.id,
            }
        },
        props: {
            messages: {
                type: Object,
            }
        }
    }
</script>

<style scoped>

</style>