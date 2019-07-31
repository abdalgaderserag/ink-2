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
                <div @click="getReplies">{{ comment.media.text }}</div>


                <div>
                <span style="padding: 0 10px">
                    <div class="card-menu" style="display:none;">
                        <div>share</div>
                        <div @click="editComment()">edit</div>
                        <div @click="deleteComment()">delete</div>
                        <div>report</div>
                    </div>
                    <svg @click="cardMenu" class="arrow"
                         viewBox="-300.7 388.6 10.1 17.4" id="arrow" width="100%" height="100%">
                        <path d="M-290.6,404.6l-1.4,1.4l-8-8l-0.7-0.7l0.7-0.7l8-8l1.4,1.4l-7.3,7.3L-290.6,404.6z"></path>
                    </svg>
                </span>
                </div>


                <div v-for="image in comment.media.media">
                    <img style="max-width: 120px;" :src="image">
                </div>
                <div class="flex-box" style="justify-content: flex-start">
                    <div>
                        <img @click="liked()" :src="'/images/ink/' + likeUrl" style="width: 24px" alt="">
                        <span>{{ comment.like }}</span>
                    </div>
                    <div>
                        <img src="/images/ink/comment.svg" style="width: 24px" alt="">
                        <span>{{ comment.comment }}</span>
                    </div>
                </div>
                <div class="flex-box new-comment">
                    <input class="comment-text" type="text" v-model="commentText">
                    <input style="display: none" type="file" @change="upload" name="" id="upload">
                    <img class="comment-icon" onclick="document.getElementById('upload').click()"
                         src="/images/ink/attachment.svg">
                    <input class="comment-button" @click="storeComment()" @submit="storeComment()" type="button"
                           value="Comment">
                </div>
                <replies v-if="showRp" :comments="comments"></replies>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Comment",
        data() {
            return {
                likeUrl: '',
                comments: [],
                showRp: false,

                //vars for inputs
                commentText: '',


                mediaPath: [],
                mediaSrc: [],
            }
        },
        props: {
            comment: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            console.log(this.comment);
            if (this.comment.isLiked == 0)
                this.likeUrl = 'hard-fill.svg';
            else if (this.comment.isLiked == 1)
                this.likeUrl = 'hard-fill-color.svg';
        },
        methods: {
            upload: function (e) {
                let read = new FileReader();
                read.readAsDataURL(e.target.files[0]);
                read.onload = () => {
                    axios.post('/api/upload', {result: read.result})
                        .then(response => {
                            this.mediaPath.push(response.data.path);
                            this.mediaSrc.push(read.result);
                        });
                }
            },
            storeComment: function () {
                let data = {
                    comment_id: this.comment.id,
                    text: this.commentText,
                    media: this.mediaPath,
                };
                if (this.commentText.length != 0)
                    axios.post('/api/comment', data)
                        .then(response => {
                            let comment;
                            comment = response.data[0];
                            comment.media = response.data[1];
                            comment.user = this.$root.user;
                            this.comments.unshift(comment);
                            this.commentText = '';
                            this.ink.comment++;
                        });
            },
            cardMenu: function (e) {
                let card = this.$el.getElementsByClassName('card-menu')[0];
                card.style.display = 'block';
                card.style.left = (e.clientX - card.offsetWidth) + 'px';
                card.style.top = (e.clientY + 6) + 'px';
            },
            getReplies: function () {
                axios.get('/api/comment/?comment=' + this.comment.id)
                    .then((response) => {
                        for (let i = 0; i < response.data[0].length; i++) {
                            this.comments[i] = response.data[0][i];
                            this.comments[i].like = response.data[1][i].like;
                            this.comments[i].isLiked = response.data[1][i].isLiked;
                            this.comments[i].comment = response.data[1][i].comment;
                            this.showRp = true;
                        }
                    });
            },
            editComment: function () {
                mediaTemp = {
                    text: this.comment.media.text,
                    media: this.comment.media.media,
                };
                pop();
                let text = document.getElementById('pop-text');
                text.value = text.value.slice(0, text.value.length - 1);
                let id = this.comment.id;
                let save = document.getElementById('save');
                save.onclick = () => {
                    if (text.value == '')
                        return;
                    axios.put('/api/comment/' + id, {
                        text: text.value,
                        media: mediaTemp.media,
                    });
                    this.comment.media.text = text.value;
                    this.comment.media.media = mediaTemp.media;
                    text.value = '';
                    mediaTemp.media = [];
                    mediaTemp.text = '';
                    document.getElementById('pop-up').style.display = 'none';
                };
            },
            deleteComment: function () {
                axios.delete('/api/comment/' + this.comment.id)
                    .then(response => {
                        // this.$el.innerHTML = '';
                        // this.$el.outerHTML = '';
                        let par = this.$parent.$parent;
                        for (let i = 0; i < par.comments.length; i++) {
                            let comment = par.comments[i];
                            if (comment.id == this.comment.id) {
                                par.comments.splice(i, 1);
                            }
                        }
                        par.ink.comment--;
                    });
            },
            liked: function () {
                axios.post('/api/like', {
                    comment_id: this.comment.id,
                }).then((response) => {
                    if (response.data == "") {
                        this.likeUrl = 'hard-fill.svg';
                        this.comment.like--;
                    } else if (response.data == 1) {
                        this.likeUrl = 'hard-fill-color.svg';
                        this.comment.like++;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>