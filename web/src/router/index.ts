import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import store from '@/store/';
import LoginView from '../views/Login.vue';
import TaskView from '../views/TasksView.vue';
import RegisterView from '../views/Register.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'task',
    component: TaskView,
    beforeEnter: (_, __, next) => {
      const isAuth = !!store.state.token
      const isTokenInCache = !!localStorage.getItem('token');
      if (isAuth || isTokenInCache) {
        next();
      } else {
        next('login');
      }
    }
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    beforeEnter: (_, __, next) => {
      const isAuth = !!store.state.token
      const isTokenInCache = !!localStorage.getItem('token');
      if (!isAuth && !isTokenInCache) {
        next();
      } else {
        next('/');
      }
    }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    beforeEnter: (_, __, next) => {
      const isAuth = !!store.state.token
      const isTokenInCache = !!localStorage.getItem('token');
      if (!isAuth && !isTokenInCache) {
        next();
      } else {
        next('/');
      }
    }
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
