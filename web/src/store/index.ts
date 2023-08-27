import { createStore } from 'vuex'
import { Task } from '../commons/common';

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
    },
    getTodoTasks(state) {
      return state.tasks.filter((t) => !t.completed_at);
    },
    getCompletedTasks(state) {
      return state.tasks.filter((t) => !!t.completed_at);
    },
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
      return state;
    },
    removeTask(state, id: number) {
      state.tasks = state.tasks.filter((t) => t.id !== id);
    },
    addTask(state, task: Task) {
      state.tasks.push(task);
    },
    updateTask(state, task: Task) {
      state.tasks = state.tasks.map((t) => {
        if (t.id === task.id) {
          return task;
        }
        return t;
      })
    }
  },
  actions: {
  },
  modules: {
  }
})
