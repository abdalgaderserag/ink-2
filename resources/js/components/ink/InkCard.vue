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
                <div class="media-view" style="padding: 4%">
                    <img v-for="(media,index) in ink.media.media" v-if="index<4" :src="media" alt="">
                </div>
            </div>
            <div class="card-footer flex-box">
                <div class="flex-box">
                    <div class="card-interact">
                        <img src="/images/ink/hard-fill-color.svg" alt="">
                        <span>{{ ink.like }}</span>
                    </div>
                    <div class="card-interact">
                        <img src="/images/ink/comment.svg" alt="">
                        <span>{{ ink.comment }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="onlyVis" class="flex-box new-comment">
            <input class="comment-text" type="text" v-model="commentText">
            <input style="display: none" type="file" @change="upload" name="" id="upload">
            <img class="comment-icon" onclick="document.getElementById('upload').click()"
                 src="/images/ink/attachment.svg">
            <input class="comment-button" @click="storeComment()" @submit="storeComment()" type="button"
                   value="Comment">
        </div>
        <comments v-if="showComments && onlyVis" :comments="comments"></comments>
    </div>
</template>

<script>
    export default {
        name: "InkCard",
        data() {
            return {
                //used to hide the other cards and comments
                onlyVis: false,
                commentText: '',

                //the comments card
                commentsLoaded: false,
                comments: [],
                showComments: false,
                mediaPath: [],
                mediaSrc: [],
            }
        },
        props: {
            ink: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            if (this.ink.media.media)
                this.reSizeImages();
        },
        methods: {
            reSizeImages: function () {
                let mediaEle = document.getElementsByClassName('media-view')[0];
                let height = mediaEle.offsetWidth / 1.75;
                let rad = '12px';
                if (this.ink.media.media.length > 1) {
                    for (let i = 0; i < this.ink.media.media.length; i++) {

                        switch (i) {
                            case 0:
                                mediaEle.children[i].style.borderTopLeftRadius = rad;
                                mediaEle.children[i].style.borderTopLeftRadius = rad;
                                break;
                            case 1:
                                mediaEle.children[i].style.borderTopRightRadius = rad;
                                mediaEle.children[i].style.borderBottomLeftRadius = rad;
                                break;
                            case 2:
                                mediaEle.children[i].style.borderBottomLeftRadius = rad;
                                mediaEle.children[0].style.borderBottomLeftRadius = 0;
                                break;
                            case 3:
                                mediaEle.children[i].style.borderBottomRightRadius = rad;
                                mediaEle.children[1].style.borderBottomLeftRadius = 0;
                                break;
                        }

                        mediaEle.children[i].style.width = '50%';
                        if (this.ink.media.media.length > 2) {
                            mediaEle.children[i].style.height = Math.trunc(height * 0.4) + 'px';
                        } else {
                            mediaEle.children[i].style.height = Math.trunc(height * 0.8) + 'px';
                        }
                    }
                }
            },
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
            getComments: function () {
                if (!this.commentsLoaded)
                    axios.get('/api/comment?ink=' + this.ink.id)
                        .then(response => {
                            this.comments = response.data;
                            this.showComments = true;
                            this.commentsLoaded = true;
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
            editInk: function () {
                mediaTemp = {
                    text: this.ink.media.text,
                    media: this.ink.media.media,
                };
                pop();
                let text = document.getElementById('pop-text');
                text.value = text.value.slice(0, text.value.length - 1);
                let id = this.ink.id;
                let save = document.getElementById('save');
                save.onclick = () => {
                    if (text.value == '')
                        return;
                    axios.put('/api/ink/' + id, {
                        text: text.value,
                        media: mediaTemp.media,
                    });
                    this.ink.media.text = text.value;
                    this.ink.media.media = mediaTemp.media;
                    text.value = '';
                    mediaTemp.media = [];
                    mediaTemp.text = '';
                    document.getElementById('pop-up').style.display = 'none';
                };
            },
            deleteInk: function () {
                axios.delete('/api/ink/' + this.ink.id)
                    .then(response => {
                        this.$el.innerHTML = '';
                        this.$el.outerHTML = '';
                    })
            },
            storeComment: function () {
                let data = {
                    ink_id: this.ink.id,
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
            }
            ,
        }
    }
</script>

<style scoped>

</style>