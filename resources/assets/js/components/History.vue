<template>
    <div class="container text-center">
        <div class="loading" v-if="loading">
            Loading...
        </div>
        <div v-else-if="historyForecast">
            <h1>Past 30 days</h1>
            <carousel :perPageCustom="[[380, 1], [992, 2], [1024, 3]]" :navigationEnabled="true">
                <slide v-for="item in historyForecast.data" :key="item.time">
                    <forecast-card v-bind:forecast="item"></forecast-card>
                </slide>
            </carousel>
        </div>
        <div v-else>Please <router-link to="/destination">select a destination</router-link></div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';
    import { Carousel, Slide } from 'vue-carousel';

    export default {
        name: "History",
        data() {
            return {
                loading: false
            };
        },
        components: {
            Carousel,
            Slide
        },
        computed: {
            ...mapState(['historyForecast', 'destination'])
        },
        methods: {
            ...mapMutations(['loadHistoryForecast']),
            loaded() {
                this.loading = false;
            }
        },
        mounted() {
            if (this.destination && !this.historyForecast) {
                this.loading = true;
                this.loadHistoryForecast(this.loaded);
            }
        }
    }
</script>

<style scoped>

</style>