import { createStore } from 'vuex'

type Task = {
  name: string;
  description: string;
  completed_at: string;
  id: number;
}
const defaultItems: Task[] = [];
const defaultSelectedTask = undefined as Task | undefined;

export default createStore({
  state: {
    user: null,
    token: null,
    tasks: defaultItems,
    isFormOpen: false,
    selectedTask: defaultSelectedTask,
  },
  getters: {
    getSelectedTask(state) {
      return state.selectedTask;
    },
    getIsFormOpen(state) {
      return state.isFormOpen;
    }
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
      return state.tasks = tasks;
    },
    setFormOpen(state) {
      return state.isFormOpen = true;
    },
    setFormClose(state) {
      state.selectedTask = undefined;
      state.isFormOpen = false;
    },
    setSelectedTask(state, task: Task) {
      state.isFormOpen = true;
      state.selectedTask = task;
      console.log(task);
      
      return state;
    }
  },
  actions: {
  },
  modules: {
  }
})
