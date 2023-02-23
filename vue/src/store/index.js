import {createStore} from "vuex";
import axiosClient from "../axios.js";

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
    dashboard: {
      loading: false,
      data: {}
    },
    response: {
      loading: false,
      data: {}
    },
    currentQuestionnaires: {
      loading: false,
      data: {}
    },
    questionnaires: {
      loading: false,
      data: []
    },
    questionTypes: [
      'text', 'textarea', 'select', 'radio'],
    notification: {
      show: false,
      type: null,
      message: null
    }
  },
  getters: {},
  actions: {
    register({commit}, user) {
      return axiosClient.post('/auth/register', user)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },
    login({commit}, user) {
      return axiosClient.post('/auth/login', user)
        .then(({data}) => {
          commit('setUser', data.user);
          commit('setToken', data.token)
          return data;
        })
    },
    logout({commit}) {
      return axiosClient.post('/auth/logout')
        .then(response => {
          commit('logout');
          return response;
        })
    },
    saveQuestionnaire({commit}, questionnaire) {
      let response;
      if (questionnaire.id) {
        response = axiosClient
          .put(`/auth/questionnaire/${questionnaire.id}`, questionnaire)
          .then((res) => {
            commit('setCurrentQuestionnaire', res.data) //updateCurrentQuestionnaire
            return res;
          });
      } else {
        response = axiosClient
          .post('/auth/questionnaire', questionnaire)
          .then((res) => {
            commit('setCurrentQuestionnaire', res.data) //setCurrentQuestionnaire
            return res;
          });
      }
      return response;
    },
    getQuestionnaire({commit}, id) {
      commit("setCurrentQuestionnaireLoading", true);
      return axiosClient
        .get(`/auth/questionnaire/${id}`)
        .then((res) => {
          commit("setCurrentQuestionnaire", res.data);
          commit("setCurrentQuestionnaireLoading", false);
          return res;
        })
        .catch((err) => {
          commit("setCurrentQuestionnaireLoading", false);
          throw err;
        });
    },
    getQuestionnaires({commit}) {
      commit("setQuestionnaireLoading", true);
      return axiosClient
        .get('/auth/questionnaire')
        .then((res) => {
          commit("setQuestionnaireLoading", false);
          commit('setQuestionnaires', res.data)
        })
    },
    deleteQuestionnaire({}, id) {
      return axiosClient
        .delete(`/auth/questionnaire/${id}`);
    },
    getQuestionnaireBySlug() {

    },
    saveQuestionnaireAnswer({commit}, {questionnaireId, answers, data}) {
      return axiosClient
        .post(`/auth/questionnaire/${questionnaireId}/answer`, {answers, data})
    },
    getResponses( {commit}, id) {
      commit('responseLoading', true)
      return axiosClient
        .get(`/auth/responses/${id}`)
        .then((res) => {
          commit('responseLoading', false)
          commit('setResponseData', res.data)
          return res
        })
        .catch(error => {
          commit('responseLoading', false)
          return error;
        })
    },
    getDashboardData({commit}) {
      commit('dashboardLoading', true)
      return axiosClient
        .get(`/auth/dashboard`)
        .then((res) => {
          commit('dashboardLoading', false)
          commit('setDashboardData', res.data)
          return res;
        })
        .catch(error => {
          commit('dashboardLoading', false)
          return error;
        })
    }
  },
  mutations: {
    logout: state => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.removeItem('TOKEN');
    },
    setUser: (state, userData) => {
      state.user.data = userData;
    },
    setToken: (state, token) => {
      state.user.token = token;
      sessionStorage.setItem('TOKEN', token);
    },
    setCurrentQuestionnaire: (state, questionnaire) => {
      state.currentQuestionnaires.data = questionnaire.data;
    },
    setCurrentQuestionnaireLoading: (state, loading) => {
      state.currentQuestionnaires.loading = loading;
    },
    setQuestionnaires: (state, questionnaires) => {
      state.questionnaires.data = questionnaires.data
    },
    setQuestionnaireLoading: (state, loading) => {
      state.questionnaires.loading = loading;
    },
    notify: (state, {type, message}) => {
      state.notification.show = true;
      state.notification.type = type;
      state.notification.message = message;
      setTimeout(() => {
        state.notification.show = false;
      }, 3000)
    },
    dashboardLoading: (state, loading) => {
      state.dashboard.loading = loading
    },
    setDashboardData: (state, data) => {
      state.dashboard.data = data
    },
    responseLoading: (state, loading) => {
      state.response.loading = loading
    },
    setResponseData: (state, data) => {
      state.response.data = data
    }
  }
});
export default store;
