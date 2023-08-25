
<template>
  <v-container class="bg-surface-variant">
    <v-row align="center">
      <v-col>
        <h1>Welcome {{ user }}</h1>
      </v-col>
      <v-col cols="3" />
      <v-col cols="3" />
      <v-col cols="2">
        <v-btn variant="outlined" :onclick="logout">
          sign out
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
  <TaskList />
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapMutations } from "vuex";
  import TaskList from '../components/TaskList.vue';

  export default defineComponent({
    name: 'TaskView',
    computed: {
      user() {
        const userInCache = localStorage.getItem('user');
        return userInCache ?? '';
      } 
    },
    methods: {
      ...mapMutations(["setUser", "setToken"]),
      logout() {
        this.setToken(null);
        this.setUser(null);
        this.$router.push('/login');
      },
    },
    components: {
      TaskList,
    }
  })
</script>