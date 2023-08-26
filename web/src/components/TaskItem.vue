<template>
  <v-list-item
    :title="name"
    :subtitle="description"
  >
    <template v-slot:prepend>
      <v-checkbox
        hide-details
        :disabled="!!completed_at"
        :model-value="!!completed_at"
        :onchange="complete"
      />
    </template>

    <template v-slot:append>
      <v-row>
        <v-col>
          <v-btn
            icon="mdi-pencil"
            size="x-small"
            variant="tonal"
            @click="editTask"
          ></v-btn>
        </v-col>
        <v-col>
          <v-btn
            icon="mdi-delete"
            size="x-small"
            variant="outlined"
            color="red.200"
            @click="deleteTask"
          ></v-btn>
        </v-col>
      </v-row>
    </template>
  </v-list-item>
</template>

<script lang="ts">
import format from 'date-fns/format';
import { defineComponent } from 'vue';
import { mapMutations } from "vuex";

  export default defineComponent({
    props: {
      name: { type: String },
      id: { type: Number },
      description: { type: String },
      completed_at: { type: String },
      onEdit: { type: Function },
    },
    data() {
        return {
          task: {
            name: this.name,
            description: this.description,
            id: this.id,
            completed_at: this.completed_at,
          }
        }
    },
    methods: {
      ...mapMutations(["setFormOpen", "setSelectedTask"]),
      async complete() {
        const token = localStorage.getItem('token');
         const rawResponse = await fetch(`http://localhost:80/api/task/${this.id}`, {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify({
            name: this.name,
            description: this.description,
            completed_at: format(new Date(), 'yyyy-MM-dd HH:mm:ss'),
          }),
        });
        // TODO: add this to the store
        const { data } = await rawResponse.json();
        console.log(data);
      },
      async deleteTask() {
        const token = localStorage.getItem('token');
        const rawResponse = await fetch(`http://localhost:80/api/task/${this.id}`, {
          method: "DELETE",
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        // TODO: add this to the store
        const { data } = await rawResponse.json();
        console.log(data);
      },
      editTask() {
        this.setSelectedTask(this.task);
      }
    }
  });
</script>