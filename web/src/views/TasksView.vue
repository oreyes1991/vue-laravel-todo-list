
<template>
  <header class="main-header bg-surface-variant">
    <h1>Welcome {{ user }}</h1>
    <div class="header-actions">
      <v-btn variant="outlined" @click="setFormOpen">
        add new task
      </v-btn>
      <v-btn variant="outlined" :onclick="logout">
        sign out
      </v-btn>
    </div>
  </header>
  <TaskList />
  <TaskFormModal :task="getSelectedTask()" :is-open="!!getIsFormOpen()" :on-close="closeForm" />
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapMutations, mapGetters } from "vuex";
  import TaskList from '../components/TaskList.vue';
  import TaskFormModal from '../components/TaskFormModal.vue';

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

<style lang="scss" scoped>
  .main-header {
    display: grid;
    padding: 0.5em 1em;
    grid-template-columns: 1fr;
    gap: 1em;
    & button {
      max-width: 180px;
    }
    & .header-actions {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1em;
    }
  }
  /* Desktop */
  @media only screen and (min-width: 800px) {
    .main-header {
      grid-template-columns: 1fr 1fr;
    }
  }
</style>