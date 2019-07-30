<template>
    <div class="ink-main">

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
            axios.get('/api/ink')
                .then(response => {
                    this.inks = response.data[0];
                    this.interact = response.data[1];
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
            }
        }
    }
</script>
