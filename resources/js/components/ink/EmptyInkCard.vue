<template>
    <div class="ink-card">
        <br>
        <div class="flex-box">
            <!--user avatar and text-->
            <div style="position: fixed;" class="flex-box card-header">
                <div class="ink-avatar holder"
                     style="border-radius:50%;width: 64px;height: 64px;margin: 0 0px 0 16px;">
                </div>
                <div>
                    <div class="ink-user-name" style="padding: 0 0 0 8px">
                        <div class="holder" style="width: 120px;height: 20px;"></div>
                    </div>
                </div>
            </div>
            <div style="width: 100%;margin: 32px 0 0 0" class="card-body">
                <div class="media">
                    <div class="holder"></div>
                    <div class="holder"></div>
                    <div class="holder"></div>
                    <div class="holder"></div>
                    <div class="holder"></div>
                    <div class="holder"></div>
                </div>
                <div class="card-footer flex-box">
                    <div class="flex-box">
                        <div class="card-interact">
                            <img src="/images/ink/hard-fill.svg" alt="">
                            <!--<img src="/images/ink/empty.svg" alt="">-->
                        </div>
                        <div class="card-interact">
                            <img src="/images/ink/comment.svg" alt="">
                            <!--<img src="/images/ink/empty.svg" alt="">-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EmptyInkCard",
    }
</script>

<style scoped>
    .holder {
        width: 100%;
        height: 20px;
        margin: 8px 0;
        animation-name: holder;
        animation-duration: 2s;
        animation-iteration-count: infinite;
    }

    .holder:first-child {
        width: 90%;
    }

    .holder:last-child {
        width: 66%;
    }

    @keyframes holder {
        0% {
            background-color: #f5f5f5;
        }
        50% {
            background-color: #e6e6e6;
        }
        100% {
            background-color: #f5f5f5;
        }
    }
</style>