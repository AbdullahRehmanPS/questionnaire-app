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
    currentQuestionnaires: {
      loading: false,
      data: {}
    },
    questionnaires: {
      loading: false,
      data: []
    },
    questionTypes: ['text', 'textarea', 'select', 'radio'],
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
      //commit("setCurrentSurveyLoading", true);
      return axiosClient
        .get(`/auth/questionnaire/${id}`)
        .then((res) => {
          commit("setCurrentQuestionnaire", res.data);
          //commit("setCurrentSurveyLoading", false);
          return res;
        })
        .catch((err) => {
          //commit("setCurrentSurveyLoading", false);
          throw err;
        });
    },
    getQuestionnaires({commit}) {
      //commit("setCurrentSurveyLoading", true);
      return axiosClient
        .get('/auth/questionnaire')
        .then((res) => {
          //commit("setCurrentSurveyLoading", false);
          commit('setQuestionnaires', res.data)
        })
    },
    deleteQuestionnaire({}, id) {
      return axiosClient
        .delete(`/auth/questionnaire/${id}`);
    },
    getQuestionnaireBySlug() {

    },
    saveQuestionnaireAnswer({commit}, {questionnaireId, answers}) {
      return axiosClient
        .post(`/auth/questionnaire/${questionnaireId}/answer`, {answers})
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
          return res;
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
    setQuestionnaires: (state, questionnaires) => {
      state.questionnaires.data = questionnaires.data
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
    }
  }
});
export default store;
