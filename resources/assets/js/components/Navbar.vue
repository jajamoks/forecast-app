<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Forecast</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link to="/"><a class="nav-link">Today</a></router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/history"><a class="nav-link">History</a></router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/future"><a class="nav-link">Future</a></router-link>
                </li>
                <li class="nav-item">
                    <span v-if="destination" class="nav-link">
                        {{ destination.country }}, {{ destination.locality }}
                        <router-link to="/destination">(change)</router-link>
                    </span>
                    <span class="nav-link" v-else><router-link to="/destination">Select Destination</router-link></span>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';

    export default {
        name: "Navbar",
        computed: {
            ...mapState(['destination'])
        }
    }
</script>

<style scoped>

</style>