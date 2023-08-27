<template>
  <v-responsive
    class="mx-auto"
    width="100%"
    content-class="auth-content"
    height="100vh"
  >
    <section class="container-center">
      <h2>Register:</h2>
      <v-form @submit.prevent="register">
        <v-text-field v-model="name" label="Name" type="text"></v-text-field>
        <v-text-field v-model="email" label="Email" type="email"></v-text-field>
        <v-text-field
        label="Password"
        type="password"
        v-model="password"
        ></v-text-field>
        <v-btn type="submit" variant="outlined">Sign Up</v-btn>
      </v-form>
    </section>
  </v-responsive>
</template>

<script lang="ts">
  import { defineComponent } from 'vue';
  import { mapMutations } from "vuex";

  export default defineComponent({
    name: 'RegisterView',
    data: () => {
      return {
        name: "",
        email: "",
        password: "",
      }
    },
    methods: {
      ...mapMutations(["setUser", "setToken"]),
      async register() {
        // TODO: add this to env vars
        const rawResponse = await fetch('http://localhost:80/api/register', {
          method: 'POST',
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            name: this.name,
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
        this.setUser(name);
        this.setToken(token);
        this.$router.push("/");
      }
    }
  });
</script>