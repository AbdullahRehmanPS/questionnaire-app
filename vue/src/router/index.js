import {createRouter, createWebHistory} from "vue-router";
import AuthLayout from "../components/AuthLayout.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import AdminDashboard from "../views/admin/Dashboard.vue";
import UserDashboard from "../views/user/Dashboard.vue";
import Questionnaires from "../views/Questionnaires.vue"
import AdminDefaultLayout from "../components/admin/DefaultLayout.vue"
import UserDefaultLayout from "../components/user/DefaultLayout.vue"
import QuestionnaireView from "../views/QuestionnaireView.vue"
import QuestionnairePublicView from "../views/user/QuestionnairePublicView.vue"

import store from "../store/index.js";

const routes = [
  {
    path: '/admin',
    redirect: '/dashboard',
    component: AdminDefaultLayout,
    meta: {requiresAuth: true},
    children: [
      { path: '/dashboard', name: 'AdminDashboard', component: AdminDashboard },
      { path: '/questionnaires', name: 'Questionnaires', component: Questionnaires },
      { path: '/questionnaires/create', name: 'QuestionnaireCreate', component: QuestionnaireView },
      { path: '/questionnaires/:id', name: 'QuestionnaireView', component: QuestionnaireView },
      { path: '/view/responses', name: 'Responses', component: QuestionnaireView },
      //{ path: '/register', name: 'Register', component: Register }
    ]
  },
  {
    path: '/view/questionnaire/:id',
    name: 'QuestionnairePublicView',
    component: QuestionnairePublicView
  },
  {
    path: '/auth',
    redirect: '/login',
    name: 'AuthLayout',
    component: AuthLayout,
    meta: {isGuest: true},
    children: [
      { path: '/login', name: 'Login', component: Login },
      { path: '/register', name: 'Register', component: Register }
    ]
  },
  {
    path: '/',
    component: UserDefaultLayout,
    children: [
      { path: '/', name: 'UserDashboard', component: UserDashboard },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'Login'})
  } else if (store.state.user.token && to.meta.isGuest){/*(to.name === 'Login' || to.name === 'Register'))*/
      next({name: 'AdminDashboard'})
  } else {
    next();
  }
})

export default router;
