<template>
  <div class="text-center">
    <v-dialog
      v-model="isOpen"
      width="auto"
      persistent
    >
      <v-card width="300px" style="padding: 16px 2em;">
        <v-form>
          <v-container v-if="!task">
            <v-row>
              <h4>Create a new task</h4>
            </v-row>
            <v-row>
              <v-text-field label="Name" v-model="name" type="text" />
            </v-row>
            <v-row>
              <v-text-field label="Description" v-model="description" type="text" />
            </v-row>
          </v-container>
          <v-container v-if="task">
            <v-row>
              <h4>Edita a task</h4>
            </v-row>
            <v-row>
              <v-text-field label="Name" v-model="task.name" type="text" />
            </v-row>
            <v-row>
              <v-text-field label="Description" v-model="task.description" type="text" />
            </v-row>
          </v-container>
        </v-form>
        <v-card-actions>
          <v-row>
            <v-col>
              <v-btn block @click="onClose">Cancel</v-btn>
            </v-col>
            <v-col>
              <v-btn type="submit" color="primary" block @click="createTask">Save</v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script lang="ts">
  import { defineComponent, PropType } from 'vue';

  type Task = {
    name: string;
    description: string;
    completed_at: string;
    id: number;
  };

  export default defineComponent({
    props: {
      onClose: { type: Function },
      task: { type: Object as PropType<Task> },
      isOpen: { type: Boolean },
    },
    data() {
      return {
        name: '',
        description: '',
      }
    },
    methods: {
      async createTask() {
        const token = localStorage.getItem('token');
        const baseURL = 'http://localhost:80/api/task';
        if (!this.task) {
          const rawResponse = await fetch(baseURL, {
            method: "POST",
            headers: { 
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
              name: this.name,
              description: this.description,
            })
          });
          const { data } = await rawResponse.json();
        } else {
          const rawResponse = await fetch(`${baseURL}/${this.task.id}`, {
            method: "PATCH",
            headers: { 
              "Content-Type": "application/json",
              Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify({
              name: this.task.name,
              description: this.task.description,
            })
          });
          const { data } = await rawResponse.json();
          //console.log(data);
          
        }
        
        this.onClose?.();
        // TODO: handle data
      }
    }
  });
</script>