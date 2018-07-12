import History from './components/History';
import Future from './components/Future';
import Destination from './components/Destination';
import Today from './components/Today';

export const routes = [
    { path: '/', component: Today, name: 'Today' },
    { path: '/history', component: History, name: 'History' },
    { path: '/future', component: Future, name: 'Future' },
    { path: '/destination', component: Destination, name: 'Destination' }
];