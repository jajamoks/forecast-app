export const headers = {
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
    }
};

/**
 * VUEX - Store Obj.
 */
export default {
    state: {
        destination: null,
        todayForecast: null,
        historyForecast: null,
        futureForecast: null
    },
    mutations: {
        setDestination(state, newDestination) {
            state.destination = newDestination;
            state.todayForecast = null;
            state.historyForecast = null;
            state.futureForecast = null;
        },
        loadTodayForecast(state, success) {
            if (!state.destination) return;
            axios
                .get(apiUrl + 'today?lat=' + state.destination.latitude + '&lon=' + state.destination.longitude, headers)
                .then(response => {
                    state.todayForecast = response;
                    success();
                });
        },
        loadHistoryForecast(state, success) {
            if (!state.destination) return;
            axios
                .get(apiUrl + 'history?lat=' + state.destination.latitude + '&lon=' + state.destination.longitude, headers)
                .then(response => {
                    state.historyForecast = response;
                    success();
                });
        },
        loadFutureForecast(state, success) {
            if (!state.destination) return;
            axios
                .get(apiUrl + 'future?lat=' + state.destination.latitude + '&lon=' + state.destination.longitude, headers)
                .then(response => {
                    state.futureForecast = response;
                    success();
                });
        }
    },
    getters: {

    },
    actions: {}
}