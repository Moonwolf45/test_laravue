import Vue from 'vue';
import Vuex from 'vuex';
import section from './section';
import user from './user';
import shared from './shared';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        section,
        user,
        shared
    }
})
