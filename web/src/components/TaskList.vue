<template>
  <v-card
    class="mx-auto"
    max-width="500"
  >
    <v-card-title>TODOs:</v-card-title>
    <v-divider></v-divider>
    <v-virtual-scroll
      :items="(getTodoTasks() as Task[])"
      height="320"
      item-height="48"
    >
      <template v-slot:default="{ item }">
       <task-item
          :name="item.name"
          :description="item.description"
          :id="item.id"
          :completed_at="item.completed_at"
        />
      </template>
    </v-virtual-scroll>
    <v-card-title>Completed:</v-card-title>
    <v-divider></v-divider>
    <v-virtual-scroll
      :items="(getCompletedTasks() as Task[])"
      height="320"
      item-height="48"
    >
      <template v-slot:default="{ item }">
        <task-item
          :name="item.name"
          :description="item.description"
          :id="item.id"
          :completed_at="item.completed_at"
        />
      </template>
    </v-virtual-scroll>
  </v-card>
</template>

<script lang="ts">
  import TaskItem from './TaskItem.vue';
  import { defineComponent } from 'vue';
  import { mapMutations, mapGetters } from 'vuex';
  import { Task, apiURL } from '../commons/common';
  export default defineComponent({
    methods: {
      ...mapMutations(['setTasks']),
      ...mapGetters(['getTodoTasks', 'getCompletedTasks'])
    },
    async mounted() {
      const token = localStorage.getItem('token');
      const rawResponse = await fetch(`${apiURL}/task`, {
        method: "GET",
        headers: { 
          Authorization: `Bearer ${token}`,
        }
      });
      const { data } = await rawResponse.json();
      this.setTasks(data);
    },
    components: {
      TaskItem,
    }
  });
</script>