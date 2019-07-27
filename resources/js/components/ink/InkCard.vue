<template>
    <div class="ink-card">
        <br>
        <div class="flex-box card-header">
            <div class="ink-avatar">
                <img class="ink-avatar-img" :src="ink.user.avatar" alt="">
            </div>
            <div>
                <div class="ink-user-name">{{ ink.user.name }}</div>
            </div>
        </div>
        <div class="card-body">
            <div @click="hideEvent" class="media">
                <span style="font-size: 4vh">{{ ink.media.text }}</span>
            </div>
            <div class="card-footer flex-box">
                <div class="flex-box">
                    <div class="card-interact">
                        <img src="/images/ink/hard-fill-color.svg" alt="">
                        <span>{{ ink.like }}</span>
                    </div>
                    <div class="card-interact">
                        <img src="/images/ink/comment.svg" alt="">
                        <span>{{ ink.like }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="onlyVis" class="flex-box new-comment">
            <input class="comment-text" type="text" v-model="commentText">
            <img class="comment-icon" src="/images/ink/comment.svg" alt="">
            <input class="comment-button" @click="storeComment()" @submit="storeComment()" type="button"
                   value="Comment">
        </div>
        <comments v-if="showComments" :comments="comments"></comments>
    </div>
</template>

<script>
    export default {
        name: "InkCard",
        data() {
            return {
                onlyVis: false,
                commentText: '',
                comments: [],
                showComments: false,
            }
        },
        props: {
            ink: {
                type: Object,
                required: true,
            }
        },
        methods: {
            getComments: function () {
                axios.get('/api/comment?ink=' + this.ink.id)
                    .then(response => {
                        console.log(response.data);
                        this.comments.push(response.data);
                        this.showComments = true;
                    });
            },
            hideEvent: function () {
                let type;
                if (this.onlyVis) {
                    type = 'block';
                    this.onlyVis = false;
                } else {
                    type = 'none';
                    this.onlyVis = true;
                    this.getComments();
                }
                let inks = document.getElementsByClassName('ink-card');
                for (let i = 0; i < inks.length; i++) {
                    inks[i].style.display = type;
                }
                this.$el.style.display = 'block';
            },
            storeComment: function () {
                let data = {
                    ink_id: this.ink.id,
                    text: this.commentText,
                };

                if (this.commentText.length != 0)
                    axios.post('/api/comment', data)
                        .then(response => {
                            this.commentText = '';
                        });
            }
        }
    }
</script>

<style scoped>

</style>