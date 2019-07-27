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
            this.$refs.inksCards = this.$children;
        },
        computed: {
            nullInks: function () {
                return this.inks.length != 0;
            }
        },
        methods: {
            getInk: function (ink, index) {
                ink.like = this.interact[index].like[0];
                ink.comment = this.interact[index].comment[0];
                return ink;
            }
        }
    }
</script>
