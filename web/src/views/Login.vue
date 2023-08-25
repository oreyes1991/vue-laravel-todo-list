<template>
  <v-responsive
  class="mx-auto"
  max-width="344"
  >
    <h2>Task list app</h2>
    <v-form @submit.prevent="login">
      <v-text-field v-model="email" label="Email" type="email"></v-text-field>
      <v-text-field
      label="Password"
      type="password"
      v-model="password"
      hint="Enter your password to access this website"
      ></v-text-field>
      <v-btn type="submit" variant="outlined">Sign In</v-btn>
    </v-form>
  </v-responsive>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapMutations } from "vuex";

  export default defineComponent({
    name: 'LoginView',
    data: () => {
      return {
        email: "",
        password: "",
      }
    },
    methods: {
      ...mapMutations(["setUser", "setToken"]),
      async login() {
        // TODO: add this to env vars
        const rawResponse = await fetch('http://localhost:80/api/login', {
          method: 'POST',
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        })
        const parsedResponse = await rawResponse.json();
        if (!parsedResponse.success) {
          // TODO: error message for wrong credentials
          return;
        }
        const { name, token } = parsedResponse.data;
        console.log(name, token);
        
        this.setUser(name);
        this.setToken(token);
        this.$router.push("/");
      }
    }
  });
</script>