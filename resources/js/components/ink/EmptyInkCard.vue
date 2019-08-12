<template>
    <div class="ink-card">
        <br>
        <div class="flex-box">
            <!--user avatar and text-->
            <div style="position: fixed;" class="flex-box card-header">
                <div class="ink-avatar" style="border-radius:50%;width: 64px;height: 64px;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5);margin: 0 0px 0 16px;">
                    <!--<img class="ink-avatar-img" src="/images/ink/empty.svg" alt="">-->
                </div>
                <div>
                    <div class="ink-user-name" style="padding: 0 0 0 8px">
                        <div style="width: 120px;height: 20px;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5);"></div>
                        <!--<img src="/images/ink/empty.svg" alt="">-->
                    </div>
                </div>
            </div>
            <div style="width: 100%;margin: 32px 0 0 0" class="card-body">
                <div class="media">
                    <!--<img style="width: 100%;height: 200px" src="/images/ink/empty.svg" alt="">-->
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
                    <div style="width: 100%;height: 20px;margin:8px 0;background: linear-gradient(90deg,#f5f5f5,#afafaf,#f5f5f5,#afafaf,#f5f5f5,#afafaf);"></div>
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

</style>