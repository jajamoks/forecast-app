<template>
    <div class="card d-inline-block mb-2" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title text-center">{{ date }}</h5>
            <p class="text-center">
                <i :class="icon"></i>
            </p>
        </div>
        <div class="card-body">
            <p class="text-center">
                {{ this.forecast.summary }} <br />
                <span class="tempMin">{{ this.forecast.temperatureLow }}° Min</span> /
                <span class="tempHigh">{{ this.forecast.temperatureHigh }}° High</span>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ForecastCard",
        props: ['forecast'],
        computed: {
            date() {
                var d = new Date(this.forecast.time*1000);
                return d.getDate() + ' '+ (d.toLocaleString("en-us", { month: "long" })) + ' ' + d.getFullYear();
            },
            icon() {
                return "wi wi-"+this.forecast.icon;
            }
        }
    }
</script>

<style scoped>
    .tempMin {
        color: #005cbf;
    }
    .tempHigh {
        color: #c69500;
    }
</style>