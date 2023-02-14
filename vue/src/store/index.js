import {createStore} from "vuex";
import axiosClient from "../axios.js";

// const tmpQuestionnaires = [
//   {
//     id: 100,
//     title: "This is my Questionnaires",
//     slug: "This is my Questionnaires",
//     status: "draft",
//     description: "my name is abdullah",
//     created_at: "2021-21-20 18:00:00",
//     updated_at: "2021-21-20 18:00:00",
//     expire_date: "2021-21-31 18:00:00",
//     questions: [
//       {
//         id: 1,
//         type: "select",
//         question: "From which country are you from?",
//         description: null,
//         data: {
//           options: [
//             {uuid: "03928e52-e96c-4f0f-ac6e-3a60c446d3ec", text: "USA"},
//             {uuid: "3be4e8c5-d7a0-4622-9fa0-dec2cb5c6065", text: "India"},
//             {uuid: "7465bd9c-9c13-4f7b-97d8-c8e37168c45f", text: "Pakistan"},
//             {uuid: "69a5123f-c218-407d-b9bd-602d1533558d", text: "Australia"},
//           ],
//         },
//       },
//       {
//         id: 2,
//         type: "checkbox",
//         question: "From which city you are from?",
//         description: "Description is null",
//         data: {
//           options: [
//             {uuid: "8715f6b9-7f49-4ecb-b85f-7e1c559be418", text: "Lahore"},
//             {uuid: "74e446d5-0b27-46d6-be57-a354e2253e5d", text: "Karachi"},
//             {uuid: "c2c9be94-d8ef-4f98-9f80-b32f56604ecb", text: "Faisalabad"},
//             {uuid: "32390f62-daec-4a4e-b4a0-25715baefa86", text: "Multan"},
//           ],
//         },
//       },
//       {
//         id: 3,
//         type: "radio",
//         question: "From which planet you are from?",
//         description: "Description is also null",
//         data: {
//           options: [
//             {uuid: "8715f6b9-7f49-4ecb-b85f-7e1c559be418", text: "Earth"},
//             {uuid: "74e446d5-0b27-46d6-be57-a354e2253e5d", text: "Mercury"},
//             {uuid: "c2c9be94-d8ef-4f98-9f80-b32f56604ecb", text: "Faisalabad"},
//             {uuid: "32390f62-daec-4a4e-b4a0-25715baefa86", text: "Venus"},
//           ],
//         },
//       },
//       {
//         id: 4,
//         type: "text",
//         question: "You favourite channel?",
//         description: null,
//         data: {},
//       },
//       {
//         id: 5,
//         type: "textarea",
//         question: "You favourite park?",
//         description: "write honest opinion",
//         data: {},
//       },
//     ],
//   },
//   {
//     id: 200,
//     title: "This is your Questionnaires",
//     slug: "This is your Questionnaires",
//     status: "active",
//     description: "your name is ashar",
//     created_at: "2021-21-20 17:00:00",
//     updated_at: "2021-21-20 17:00:00",
//     expire_date: "2021-21-31 17:00:00",
//     questions: [],
//   },
//   {
//     id: 900,
//     title: "This is your Questionnaires",
//     slug: "This is your Questionnaires",
//     status: "active",
//     description: "your name is ashar",
//     created_at: "2021-21-20 17:00:00",
//     updated_at: "2021-21-20 17:00:00",
//     expire_date: "2021-21-31 17:00:00",
//     questions: [],
//   },
//   {
//     id: 6600,
//     title: "This is your Questionnaires",
//     slug: "This is your Questionnaires",
//     status: "active",
//     description: "your name is ashar",
//     created_at: "2021-21-20 17:00:00",
//     updated_at: "2021-21-20 17:00:00",
//     expire_date: "2021-21-31 17:00:00",
//     questions: [],
//   },
// ];

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
    currentQuestionnaires: {
      loading: false,
      data: {}
    },
    //questionnaires: [...tmpQuestionnaires],
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
          // console.log(store.state.user.token)
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
    }
  },
  mutations: {
    logout: state => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem('TOKEN');
    },
    setUser: (state, userData) => {
      state.user.data = userData;
      state.user.token = userData.token;
      sessionStorage.setItem('TOKEN', userData.token);
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
    }
  }
});
export default store;
