<template>
    <div>
        <div class="flex-box" style="justify-content: flex-start">
            <div>
                <img style="height: 48px;border-radius: 50%;" :src="comment.user.avatar" alt="">
            </div>
            <div style="width: 90%">
                <div class="flex-box">
                    <span>
                        <a :href="`/profile/${comment.user.slug}`" class="link-clear"
                           style="font-size: 2vh;padding: 0 4px;color: #f98835">{{ comment.user.name }}</a>
                    </span>
                    <div style="padding: 0 10px">
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
                    </div>
                </div>

                <div @click="showReplies" style="padding: 8px 1%;">{{ comment.media.text }}</div>
                <div v-for="image in comment.media.media">
                    <img style="max-width: 120px;" :src="image">
                </div>


                <div class="flex-box" style="justify-content: flex-start;padding: 0 2%;">
                    <div>
                        <img @click="liked" ref="like" src="/images/ink/hard-fill.svg" style="width: 24px" alt="">
                        <span class="like-span">{{ comment.like }}</span>
                    </div>
                    <div>
                        <img src="/images/ink/comment.svg" style="width: 24px;margin: 0 0 0 12px" alt="">
                        <span>{{ comment.comment }}</span>
                    </div>
                </div>
                <div v-if="showRp" class="flex-box new-comment">
                    <input class="comment-text" type="text" v-model="commentText">
                    <input style="display: none" type="file" @change="upload" name="" id="upload">
                    <img class="comment-icon" onclick="document.getElementById('upload').click()"
                         src="/images/ink/attachment.svg">
                    <input class="comment-button" @click="storeComment()" @submit="storeComment()" type="button"
                           value="Comment">
                </div>
                <replies v-if="showRp && show" :comments="comments"></replies>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Comment",
        data() {
            return {
                like: 'hard-fill.svg',
                comments: [],
                show: false,
                showRp: false,
                firstTime: true,

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
            // if (this.comment.isLiked == 0)
            //     this.likeUrl = 'hard-fill.svg';
            // else
            //     this.likeUrl = 'hard-fill-color.svg';
            if (this.comment.isLiked == 1)
                this.$refs.like.attributes.src.value = '/images/ink/hard-fill-color.svg';
            else
                this.$refs.like.attributes.src.value = '/images/ink/hard-fill.svg';
            // this.likeUrl();
        },
        methods: {
            // likeUrl: function (url = '') {
            //     if (this.comment.isLiked == 0)
            //         url = 'hard-fill.svg';
            //     else
            //         url = 'hard-fill-color.svg';
            //     this.like = url;
            // },

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

            showReplies: function () {
                this.showRp = !this.showRp;

                if (this.firstTime)
                    this.getReplies();

                this.firstTime = false;

            },

            storeComment: function () {
                let data = {
                    comment_id: this.comment.id,
                    text: this.commentText,
                    media: this.mediaPath,
                };
                if (data.text.length != 0 || data.media.length != 0)
                    axios.post('/api/comment', data)
                        .then(response => {
                            let comment = response.data[0];
                            comment.media = response.data[1];
                            comment.like = response.data[2].like;
                            comment.comment = response.data[2].comment;
                            comment.isLike = response.data[2].isLiked;
                            comment.user = this.$root.user;
                            this.comments.unshift(comment);
                            this.commentText = '';
                            this.mediaPath = [];
                            this.comment.comment++;
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
                        }
                        this.show = true
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

                    let meds = document.getElementById('images-edit');
                    let media = [];

                    if (meds.childElementCount != 0)
                        for (let i = 0; i < meds.childElementCount; i++) {
                            media[i] = meds.children[i].children[0].attributes.src.value;
                        }

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

            liked: function (e) {
                axios.post('/api/like', {
                    comment_id: this.comment.id,
                }).then((response) => {
                    let like = this.$el.getElementsByClassName('like-span')[0];
                    if (response.data == "") {
                        like.innerText = Number.parseInt(like.innerText) - 1;
                        this.$refs.like.attributes.src.value = '/images/ink/hard-fill.svg';
                        this.comment.like--;
                    } else if (response.data == 1) {
                        like.innerText = Number.parseInt(like.innerText) + 1;
                        this.animateLike(e)
                        this.$refs.like.attributes.src.value = '/images/ink/hard-fill-color.svg';
                        this.comment.like++;
                    }
                });
            },
            animateLike: function (e) {
                let animationTime = 200;
                e.target.style.animation = `scale-h ${animationTime}ms ease-out 0s 1 normal none running`;
                setTimeout(() => {
                    e.target.style.animation = '';
                }, animationTime);
            }
        }
    }
</script>

<style scoped>

</style>