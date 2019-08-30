<template>
    <div class="ink-main">

        <div @click="createInk()"
             style="background: linear-gradient(to left, #FC4027, #f98835);border-radius: 50%;height:60px;position: fixed;right: 36px;bottom: 38px;box-shadow: 1px 1px 10px #919191a8;">
            <img src="/images/ink/ink.png" alt="">
        </div>

        <div class="temp-ink">
            <empty-ink-card></empty-ink-card>
            <empty-ink-card></empty-ink-card>
            <empty-ink-card></empty-ink-card>
            <empty-ink-card></empty-ink-card>
            <empty-ink-card></empty-ink-card>
        </div>

        <div v-if="nullInks" v-for="(ink,index) in inks">
            <ink-card :ink="getInk(ink,index)"></ink-card>
        </div>
        <div v-else>
            <h1>NO Inks</h1>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InkMain",
        data() {
            return {
                inks: [],
                interact: [],
            }
        },
        mounted() {
            //
            // Echo.channel('chat').whisper('typing', {name: "it work"});
            Echo.channel('chat').listenForWhisper('typing', (e) => {
                console.log(e);
            });
            //
            let url;
            if (document.location.pathname == '/profile')
                url = '/api/ink ';
            else if (document.location.pathname == '/')
                url = '/api/main';
            else
                url = '/api/profile/ink?slug=' + document.location.pathname.split('/').pop();

            axios.get(url)
                .then(response => {
                    this.inks = response.data[0];
                    this.interact = response.data[1];
                    document.getElementsByClassName('temp-ink')[0].remove();
                })
                .catch(error => {
                    this.$root.message = 'problem while loading inks try refresh or try an other time.';
                });

            let cardMenu = document.getElementsByClassName('card-menu');
            document.getElementsByClassName('main-section')[0].addEventListener('scroll', () => {
                for (let i = 0; i < cardMenu.length; i++) {
                    cardMenu[i].style.display = 'none';
                }
            });
        },
        computed: {
            nullInks: function () {
                return this.inks.length != 0;
            }
        },
        methods: {
            getInk: function (ink, index) {
                ink.like = this.interact[index].like;
                ink.comment = this.interact[index].comment;
                ink.isLiked = this.interact[index].isLiked;
                if (ink.media.media) {
                    let media = ink.media.media;
                    try {
                        media = media.split(',').slice(0, -1);
                        ink.media.media = media;
                    } catch (e) {
                    }
                }
                return ink;
            },
            createInk: function () {
                mediaTemp = {
                    text: '',
                    media: [],
                };
                pop();
                let text = document.getElementById('pop-text');
                text.value = text.value.slice(0, text.value.length - 1);
                let save = document.getElementById('save');
                save.onclick = () => {

                    let meds = document.getElementById('images-edit');
                    let media = [];

                    if (meds.childElementCount != 0)
                        for (let i = 0; i < meds.childElementCount; i++) {
                            media[i] = meds.children[i].children[0].attributes.src.value;
                        }

                    axios.post('/api/ink', {
                        text: text.value,
                        media: media,
                    });
                    text.value = '';
                    mediaTemp.media = [];
                    mediaTemp.text = '';
                    document.getElementById('pop-up').style.display = 'none';
                };
            }
        }
    }
</script>
