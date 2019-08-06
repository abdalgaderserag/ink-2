<template>
    <div>
        <div v-for="notifications as notification">
            {{ getNotification(notification) }}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Notifications",
        data() {
            return {
                notifications: [],
            }
        },
        methods: {
            getNotification: function (notification) {
                return notification;
            }
        }
    }
</script>

<style scoped>

</style>