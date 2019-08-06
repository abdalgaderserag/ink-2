<template>
    <div class="notification">
        <div @click="markAllAsRead">mark all as read</div>
        <div @click="deleteReadNotifications">delete readed notifications</div>
        <div v-for="notification in notifications">
            <span @click="markAsRead(notification.id)">
                {{ accessNotification(notification) }}
            </span>
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
        mounted() {
            this.getNotifications();
        },
        methods: {
            accessNotification: function (notification) {
                notification = notification.data.text;
                return notification;
            },
            //Notifications routes
            getNotifications: function () {
                axios.get('/api/notifications')
                    .then(response => {
                        this.notifications = response.data;
                    });
            },
            markAsRead: function (uuid) {
                axios.get(`/api/notifications/mark-as-read/${uuid}`)
            },
            getUnreadNotifications: function () {
                axios.get('/api/notifications/unread')
                    .then(response => {
                        this.notifications = response.data;
                    });
            },
            deleteReadNotifications: function () {
                axios.delete('/api/notifications/delete-read')
            },
            markAllAsRead: function () {
                axios.get('/api/notifications/mark-all-as-read')
            }
            //
        }
    }
</script>

<style scoped>
    .notification {
        background-color: white;
    }

    .notification div {
        width: 100%;
        border-bottom: 1px solid gray;
        padding: 4px 0;
    }
</style>