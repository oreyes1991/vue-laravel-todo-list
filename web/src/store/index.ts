import { createStore } from 'vuex'

type Task = {
  name: string;
  description: string;
  completed_at: string;
  id: number;
}
const defaultItems: Task[] = [];

export default createStore({
  state: {
    user: null,
    token: null,
    tasks: defaultItems,
  },
  getters: {
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
      if (!user) {
        localStorage.removeItem('user');
      } else {
        localStorage.setItem('user', user);
      }
    },
    setToken(state, token) {
      state.token = token;
      if (!token) {
        localStorage.removeItem('token');
      } else {
        localStorage.setItem('token', token);
      }
    },
    setTasks(state, tasks: Task[]) {
      state.tasks = tasks;
    }
  },
  actions: {
  },
  modules: {
  }
})
