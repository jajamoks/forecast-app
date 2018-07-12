<template>
    <div>
        <p v-if="destination">
            You are looking at {{ destination.country }}, {{ destination.locality }} forecast.
        </p>

        <h3 v-if="destination">Change destination: </h3>
        <h1 v-else>Select destination: </h1>
        <vue-google-autocomplete
             id="map"
             classname="form-control"
             placeholder="Type your city ..."
             v-on:placechanged="setAddressData"
             types="(cities)"
        >
        </vue-google-autocomplete>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';

    export default {
        name: "Destination",
        computed: {
            ...mapState(['destination'])
        },
        methods: {
            ...mapMutations(['setDestination']),
            setAddressData(data) {
                this.setDestination(data)

                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>

</style>