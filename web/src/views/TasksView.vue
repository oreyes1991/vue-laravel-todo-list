
<template>
  <v-container class="bg-surface-variant">
    <v-row align="center">
      <v-col>
        <h1>Welcome {{ user }}</h1>
      </v-col>
      <v-col cols="4" />
      <v-col cols="2">
        <v-btn variant="outlined" @click="setFormOpen">
          add new task
        </v-btn>
      </v-col>
      <v-col cols="2">
        <v-btn variant="outlined" :onclick="logout">
          sign out
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
  <TaskList />
  <TaskFormModal :task="getSelectedTask()" :is-open="!!getIsFormOpen()" :on-close="closeForm" />
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapMutations, mapGetters } from "vuex";
  import TaskList from '../components/TaskList.vue';
  import TaskFormModal from '../components/TaskFormModal.vue';

  type Task = {
    name: string;
    description: string;
    completed_at: string;
    id: number;
  };


  export default defineComponent({
    name: 'TaskView',
    computed: {
      user() {
        const userInCache = localStorage.getItem('user');
        return userInCache ?? '';
      } 
    },
    methods: {
      ...mapMutations(["setUser", "setToken", "setFormOpen", "setFormClose"]),
      ...mapGetters(['getIsFormOpen', 'getSelectedTask']),
      logout() {
        this.setToken(null);
        this.setUser(null);
        this.$router.push('/login');
      },
      closeForm() {
        this.setFormClose();
      },
    },
    components: {
      TaskList,
      TaskFormModal,
    }
  })
</script>