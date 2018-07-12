<template>
    <div class="container text-center">
        <div class="loading" v-if="loading">
            Loading...
        </div>
        <div v-else-if="todayForecast">
            <h1>Today</h1>
            <forecast-card v-if="todayForecast" v-bind:forecast="todayForecast.data"></forecast-card>
        </div>
        <div v-else>Please <router-link to="/destination">select a destination</router-link></div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';

    export default {
        name: "Today",
        data() {
            return {
                loading: false
            };
        },
        computed: {
            ...mapState(['todayForecast', 'destination'])
        },
        methods: {
            ...mapMutations(['loadTodayForecast']),
            loaded() {
                this.loading = false;
            }
        },
        mounted() {
            if (this.destination && !this.todayForecast) {
                this.loading = true;
                this.loadTodayForecast(this.loaded);
            }
        }
    }
</script>

<style scoped>

</style>