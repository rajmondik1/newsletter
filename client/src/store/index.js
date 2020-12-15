import Vue from 'vue';
import Vuex from "vuex";
import Subscription from './modules/subscription';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Subscription
    }
});
