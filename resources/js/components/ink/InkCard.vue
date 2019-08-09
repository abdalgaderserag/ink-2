<template>
    <div class="ink-card">
        <br>
        <div class="flex-box">
            <!--user avatar and text-->
            <div class="flex-box card-header">
                <div class="ink-avatar">
                    <img class="ink-avatar-img" :src="ink.user.avatar" alt="">
                </div>
                <div>
                    <div class="ink-user-name">
                        <a :href="`/profile/${ ink.user.slug }`" class="link-clear">{{ ink.user.name }}</a>
                    </div>
                </div>
            </div>

            <!--edit delete menu-->
            <div v-if="ink.user.id == $root.user.id">
                <span style="padding: 0 10px">
                    <div class="card-menu" style="display:none;">
                        <div>share</div>
                        <div @click="editInk()">edit</div>
                        <div @click="deleteInk()">delete</div>
                        <div>report</div>
                    </div>
                    <svg @click="cardMenu" class="arrow"
                         viewBox="-300.7 388.6 10.1 17.4" id="arrow" width="100%" height="100%">
                        <path d="M-290.6,404.6l-1.4,1.4l-8-8l-0.7-0.7l0.7-0.7l8-8l1.4,1.4l-7.3,7.3L-290.6,404.6z"></path>
                    </svg>
                </span>
            </div>
        </div>
        <div class="card-body">
            <div @click="hideEvent" class="media">
                <span style="font-size: 4vh" v-html="getHashTag(ink.media.text)"></span>
                <div v-if="ink.media.media" class="media-view" style="padding: 4%">
                    <img v-for="(media,index) in ink.media.media" v-if="index<4" :src="media" alt="">
                </div>
            </div>
            <div class="card-footer flex-box">
                <div class="flex-box">
                    <div class="card-interact">
                        <img @click="liked()" :src="'/images/ink/' + like" alt="">
                        <span>{{ ink.like }}</span>
                    </div>
                    <div class="card-interact">
                        <img src="/images/ink/comment.svg" alt="">
                        <span>{{ ink.comment }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!--comments section-->
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
                // used to hide the other cards and comments
                onlyVis: false,
                commentText: '',

                // the comments card
                commentsLoaded: false,
                comments: [],
                showComments: false,
                mediaPath: [],
                mediaSrc: [],

                // like
                like: '',
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
            if (this.ink.isLiked == 1)
                this.like = 'hard-fill-color.svg';
            else
                this.like = 'hard-fill.svg';
        },
        methods: {

            // add the hash tag to the inks
            getHashTag: function (text) {
                //split the all the text to array the first element won't contain any hash tag
                let textArray = text.split('#');

                //save the first element to the out put var (out)
                let out = textArray[0];

                //loop thowght all the hashes and instert the # sgin with the a HTML tag
                //it's start from the second element why? see the prev comments
                for (let i = 1; i < textArray.length; i++) {

                    //splite the hash from the rest text by space the hash will stored in the splited[0]
                    let splited = textArray[i].split(' ', 1);
                    // bind the new hash to the old if avil
                    // it will add the hash to the old out var text
                    // remove from the loop text the hash by slice() function
                    out = out + `<a href="/search?hash=${splited[0]}" class="hash-tag">${ '#' + splited[0]}</a> ${textArray[i].slice(splited[0].length, textArray[i].length)}`;
                }

                return out;
            },

            // show the edit delete menue
            cardMenu: function (e) {
                let card = this.$el.getElementsByClassName('card-menu')[0];
                card.style.display = 'block';
                card.style.left = (e.clientX - card.offsetWidth) + 'px';
                card.style.top = (e.clientY + 6) + 'px';
            },

            // resize images by count
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

            // upload comment images
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

            // get the ink comments
            getComments: function () {
                if (!this.commentsLoaded)
                    axios.get('/api/comment?ink=' + this.ink.id)
                        .then(response => {
                            // this.comments = response.data[0];
                            for (let i = 0; i < response.data[0].length; i++) {
                                this.comments[i] = response.data[0][i];
                                this.comments[i].like = response.data[1][i].like;
                                this.comments[i].isLiked = response.data[1][i].isLiked;
                                this.comments[i].comment = response.data[1][i].comment;
                            }
                            this.showComments = true;
                            this.commentsLoaded = true;
                        });
            },

            // hide or show the other inks
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

            // edit the ink
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

            // remove the ink
            deleteInk: function () {
                axios.delete('/api/ink/' + this.ink.id)
                    .then(response => {
                        this.$el.innerHTML = '';
                        this.$el.outerHTML = '';
                        if (this.onlyVis)
                            this.hideEvent();
                    })
            },

            // save new comment
            storeComment: function () {

                let data = {
                    ink_id: this.ink.id,
                    text: this.commentText,
                    media: this.mediaPath,
                };
                if (data.text.length != 0 || data.media.length != 0)
                    axios.post('/api/comment', data)
                        .then(response => {
                            let comment;
                            comment = response.data[0];
                            comment.media = response.data[1];
                            comment.like = response.data[2].like;
                            comment.comment = response.data[2].comment;
                            comment.isLike = response.data[2].isLiked;
                            comment.user = this.$root.user;
                            this.comments.unshift(comment);
                            this.commentText = '';
                            this.ink.comment++;
                        });
            },

            // like button requests
            liked: function () {
                axios.post('/api/like', {
                    ink_id: this.ink.id,
                }).then((response) => {
                    if (response.data == "") {
                        this.like = 'hard-fill.svg';
                        this.ink.like--;
                    } else {
                        this.like = 'hard-fill-color.svg';
                        this.ink.like++;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>