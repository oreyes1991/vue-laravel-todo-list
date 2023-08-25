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
        <v-list-item
          :title="item.name + item.id"
          :subtitle="item.description"
        >
          <template v-slot:prepend>
            <v-checkbox></v-checkbox>
          </template>

          <template v-slot:append>
            <v-btn
              icon="mdi-pencil"
              size="x-small"
              variant="tonal"
            ></v-btn>
          </template>
        </v-list-item>
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
        <v-list-item
          :title="item.name"
          :subtitle="item.description"
        >
          <template v-slot:prepend>
            <v-icon class="bg-primary">mdi-account</v-icon>
          </template>

          <template v-slot:append>
            <v-btn
              icon="mdi-pencil"
              size="x-small"
              variant="tonal"
            ></v-btn>
          </template>
        </v-list-item>
      </template>
    </v-virtual-scroll>
  </v-card>
</template>

<script lang="ts">
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
        headers: { Authorization: `Bearer ${token}` }
      });
      const { data } = await rawResponse.json();
      this.items = data;
    }
  }
</script>