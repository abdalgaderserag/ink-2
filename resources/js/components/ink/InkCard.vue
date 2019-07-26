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
            <input class="comment-text" type="text">
            <img class="comment-icon" src="/images/ink/comment.svg" alt="">
            <input class="comment-button" type="button" value="Comment">
        </div>
    </div>
</template>

<script>
    export default {
        name: "InkCard",
        data() {
            return {
                onlyVis: false,
            }
        },
        props: {
            ink: {
                type: Object,
                required: true,
            }
        },
        methods: {
            hideEvent: function (e) {
                let type;
                if (this.onlyVis) {
                    type = 'block';
                    this.onlyVis = false;
                } else {
                    type = 'none';
                    this.onlyVis = true;
                }
                let inks = document.getElementsByClassName('ink-card');
                for (let i = 0; i < inks.length; i++) {
                    inks[i].style.display = type;
                }
                this.$el.style.display = 'block';

            },
            getInkCardEle: function (target) {
                let ink = target;
                while (ink.className != 'ink-card') {

                }
            }
        }
    }
</script>

<style scoped>

</style>