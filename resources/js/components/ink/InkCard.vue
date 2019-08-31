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
            <div v-if="$root.user && ink.user.id == $root.user.id">
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
                <span style="font-size: 4vh" v-if="ink.media.text" v-html="getHashTag(ink.media.text)"></span>
                <div v-if="ink.media.media.length != 0" class="media-view" style="padding: 4%;">
                    <img v-for="(media,index) in ink.media.media" style="object-fit: cover" v-if="index<4"
                         :src=" '/' + media"
                         alt="">
                </div>
            </div>
            <div class="card-footer flex-box">
                <div class="flex-box">
                    <div class="card-interact">
                        <img ref="like" @click="liked" src="/images/ink/hard-fill.svg" alt="">
                        <span class="like-span">{{ ink.like }}</span>
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
            }
        },
        props: {
            ink: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            if (this.ink.media.media.length != 0)
                this.reSizeImages();
            if (this.ink.isLiked == 1)
                this.$refs.like.attributes.src.value = '/images/ink/hard-fill-color.svg';
            else
                this.$refs.like.attributes.src.value = '/images/ink/hard-fill.svg';
            this.listen()
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
                    out = out + `<a href="/search?hash=${splited[0]}" class="hash-tag">${'#' + splited[0]}</a> ${textArray[i].slice(splited[0].length, textArray[i].length)}`;
                }

                //split the all the text to array the first element won't contain any hash tag
                textArray = out.split('@');

                //save the first element to the out put var (out)
                out = textArray[0];

                //loop thowght all the hashes and instert the # sgin with the a HTML tag
                //it's start from the second element why? see the prev comments
                for (let i = 1; i < textArray.length; i++) {

                    //splite the hash from the rest text by space the hash will stored in the splited[0]
                    let splited = textArray[i].split(' ', 1);
                    // bind the new hash to the old if avil
                    // it will add the hash to the old out var text
                    // remove from the loop text the hash by slice() function
                    out = out + `<a href="/search?slug=${splited[0]}" class="hash-tag">${splited[0]}</a> ${textArray[i].slice(splited[0].length, textArray[i].length)}`;
                }

                return out;
            },

            // show the edit delete menu
            cardMenu: function (e) {
                let card = this.$el.getElementsByClassName('card-menu')[0];
                card.style.display = 'block';
                card.style.left = (e.clientX - card.offsetWidth) + 'px';
                card.style.top = (e.clientY + 6) + 'px';
            },

            // resize images by count
            reSizeImages: function () {
                let mediaEle = this.$el.getElementsByClassName('media-view')[0];
                let height = mediaEle.offsetWidth / (1.75 * 2);
                let rad = '12px';
                let overflow = false;
                let count = mediaEle.children.length;
                if (count > 4) {
                    count = 4;
                    overflow = true;
                }

                for (let i = 0; i < count; i++) {
                    let ele = mediaEle.children[i];
                    let eles = mediaEle.children;
                    ele.style.width = '50%';
                    ele.style.height = height + 'px';
                    if (i === 0) {
                        ele.style.borderRadius = rad;
                        ele.style.width = '100%';
                        ele.style.marginBottom = '-5px';
                    } else if (i === 1) {
                        ele.style.marginBottom = '-5px';

                        eles[0].style.borderTopRightRadius = '0';
                        eles[0].style.borderBottomRightRadius = '0';
                        eles[0].style.width = '50%';

                        eles[1].style.borderTopRightRadius = rad;
                        eles[1].style.borderBottomRightRadius = rad;
                    } else if (i === 2) {
                        ele.style.borderTopLeftRadius = '0';
                        ele.style.borderTopRightRadius = '0';
                        ele.style.borderBottomRightRadius = rad;
                        ele.style.borderBottomLeftRadius = rad;
                        ele.style.width = '100%';

                        eles[0].style.borderBottomLeftRadius = '0';
                        eles[1].style.borderBottomRightRadius = '0';
                    } else if (i === 3) {
                        ele.style.borderBottomRightRadius = rad;

                        eles[2].style.width = '50%';
                        eles[2].style.borderBottomRightRadius = '0';
                    }
                }

                if (overflow)
                    for (let i = 4; i < count; i++)
                        mediaEle.children[i].remove();
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

                    let meds = document.getElementById('images-edit');
                    let media = [];

                    if (meds.childElementCount != 0)
                        for (let i = 0; i < meds.childElementCount; i++) {
                            media[i] = meds.children[i].children[0].attributes.src.value;
                        }

                    axios.put('/api/ink/' + id, {
                        text: text.value,
                        media: media,
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
                            this.mediaPath = [];
                            this.ink.comment++;
                        });
            },

            // like button requests
            liked: function (e) {
                axios.post('/api/like', {
                    ink_id: this.ink.id,
                }).then((response) => {
                    let like = this.$el.getElementsByClassName('like-span')[0];
                    if (response.data == "") {
                        this.ink.like--;
                        like.innerText = Number.parseInt(like.innerText) - 1;
                        this.$refs.like.attributes.src.value = '/images/ink/hard-fill.svg';
                    } else {
                        this.ink.like++;
                        like.innerText = Number.parseInt(like.innerText) + 1;
                        this.animateLike(e);
                        this.$refs.like.attributes.src.value = '/images/ink/hard-fill-color.svg';
                    }
                });
            },
            animateLike: function (e) {
                let animationTime = 200;
                e.target.style.animation = `scale-h ${animationTime}ms ease-out 0s 1 normal none running`;
                setTimeout(() => {
                    e.target.style.animation = '';
                }, animationTime);
            },
            listen: function () {
                //Likes
                Echo.channel('likes.ink.' + this.ink.id).listen('LikesEvent', (e) => {
                    let number = 0;
                    e.op ? number++ : number--;
                    let like = this.$el.getElementsByClassName('like-span')[0];
                    if (e.user != this.$root.user.id)
                        like.innerText = Number.parseInt(like.innerText) + number;
                });

                Echo.channel('comments.ink.' + this.ink.id).listen('CommentsEvent', (e) => {
                    if (e.comment.user_id != this.$root.user.id) {
                        let comment = e.comment;
                        comment.like = 0;
                        comment.media = e.comment.media;
                        comment.comment = 0;
                        comment.isLike = 0;
                        comment.user = e.comment.user;
                        this.ink.comment++;
                        this.comments.unshift(comment);
                    }
                });

            }
        }
    }
</script>

<style scoped>

</style>