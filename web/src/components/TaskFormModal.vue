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
  import { mapMutations } from 'vuex';
  import { Task, apiURL } from '../commons/common';

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
      ...mapMutations(['addTask', 'updateTask']),
      async createTask() {
        const token = localStorage.getItem('token');
        const url = `${apiURL}/task`;
        if (!this.task) {
          const rawResponse = await fetch(url, {
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
          this.addTask(data);
        } else {
          const rawResponse = await fetch(`${url}/${this.task.id}`, {
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
          this.updateTask(data);
        }
        this.onClose?.();
      }
    }
  });
</script>