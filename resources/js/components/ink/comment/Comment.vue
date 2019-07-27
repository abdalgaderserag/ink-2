<template>
    <div>
        {{ comment }}
    </div>
</template>

<script>
    export default {
        name: "Comment",
        props: {
            text: {
                type: Object,
                required: true,
            }
        }
    }
</script>

<style scoped>

</style>