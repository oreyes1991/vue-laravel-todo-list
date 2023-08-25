<template>
  <v-card
    class="mx-auto"
    max-width="500"
  >
    <v-card-title>TODOs:</v-card-title>
    <v-divider></v-divider>
    <v-virtual-scroll
      :items="todo"
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
      :items="completed"
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

  type Task = {
    name: string;
    description: string;
    completed_at: string;
    id: number;
  }
  const defaultItems: Task[] = [];
  export default {
    data: () => ({
      items: defaultItems,
    }),
    computed: {
      todo() {
        return this.items.filter((item) => !item.completed_at);
      },
      completed() {
        return this.items.filter((item) => !!item.completed_at);
      }
    },
    async mounted() {
      const token = localStorage.getItem('token');
      const rawResponse = await fetch('http://localhost:80/api/task', {
        method: "GET",
        headers: { 
          Authorization: `Bearer ${token}`,
        }
      });
      const { data } = await rawResponse.json();
      this.items = data;
    },
    components: {
      TaskItem,
    }
  }
</script>