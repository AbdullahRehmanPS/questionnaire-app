import {createStore} from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
  },
  getters: {},
  actions: {
    register({ commit }, user) {
      return axiosClient.post('/auth/register', user)
        .then( ({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },

    login({ commit }, user) {
      return axiosClient.post('/auth/login', user)
        .then( ({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },
    logout({ commit }) {
      return axiosClient.post('/auth/logout')
        .then(response => {
          commit('logout');
          // console.log(store.state.user.token)
          return response;
        })
    },
  },
  mutations: {
    logout: state => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem('TOKEN');
    },
    setUser: (state, userData) => {
      state.user.data =  userData;
      // state.user.token = userData.token;
      // sessionStorage.setItem('TOKEN', userData.token);
    },
    setToken: (state, token) => {
      state.user.token = token;
      sessionStorage.setItem('TOKEN', token);
    },
  }
});
export default store;
