<template>
  <v-responsive
    class="mx-auto"
    height="100vh"
    content-class="auth-content"
  >
    <section class="container-center">
      <h2>Login</h2>
      <v-form @submit.prevent="login">
        <v-text-field v-model="email" label="Email" type="email"></v-text-field>
        <v-text-field
        label="Password"
        type="password"
        v-model="password"
        hint="Enter your password to access this website"
        ></v-text-field>
        <v-btn type="submit" variant="outlined">Sign In</v-btn>
        <v-btn @click="$router.push('/register')" variant="outlined">Register</v-btn>
      </v-form>
    </section>
  </v-responsive>
</template>

<script lang="ts">
  import { apiURL } from '@/commons/common';
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
        const rawResponse = await fetch(`${apiURL}/login`, {
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
        this.setUser(name);
        this.setToken(token);
        this.$router.push("/");
      }
    }
  });
</script>

<style lang="scss">
  .container-center {
    display: grid;
    place-self: center;
    gap: 1em;
    justify-items: center;
    & form {
      min-width: 350px;
      display: grid;
      gap: .5em;
    }
  }
  .auth-content {
    display: grid;
  }
</style>