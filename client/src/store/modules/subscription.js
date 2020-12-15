import axios from 'axios';

const state = {
    email: '',
    category: '',
    inputValid: false,
    categories: [],
    loading: false,
    successMsg: false
};
const getters = {
    getEmail: () => state.email,
    getCategory: () => state.category,
    getCategories: () => state.categories,
    isValid: () => {
        return state.inputValid && state.category.length > 1;
    },
    getLoading: () => state.loading,
    getSuccessMsg: () => state.successMsg,
};

const actions = {
    async fetchCategories({commit}) {
        const response = await axios.get('http://localhost/categories');
        commit('setCategories', response.data);
    },
    async modifyEmail({commit}, email) {
        commit('setEmail', email);
    },
    async modifyCategory({commit}, email) {
        commit('setCategory', email);
    },
    async modifyValid({commit}, valid) {
        commit('setValid', valid);
    },
    async subscribe({commit}) {
        commit('setLoading', true);
        await axios.post('http://localhost', {email: state.email, category: state.category});
        commit('setEmail', null);
        commit('setCategory', null);
        commit('setValid', null);
        commit('setLoading', false);
    },
    setLoading({commit}, bool) {
        commit('setLoading', bool);
    },
    setSuccessMsg({commit}, bool) {
        commit('setSuccessMsg', bool);
    }
};
const mutations = {
    setCategory: (state, category) => (state.category = category),
    setCategories: (state, categories) => (state.categories = categories),
    setEmail: (state, email) => (state.email = email),
    setValid: (state, valid) => (state.inputValid = valid),
    setLoading: (state, bool) => (state.loading = bool),
    setSuccessMsg: (state, bool) => (state.successMsg = bool),
};

export default {
    state,
    getters,
    actions,
    mutations
};