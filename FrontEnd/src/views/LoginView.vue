<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axiosClient from "../../axiosClient";
import {useAuth} from "../stores/useAuth";

const email = ref("");
const password = ref("");
const errors = ref(null);
const router = useRouter();
const {login: authLogin} = useAuth();

const login = async () => {
  errors.value = null;

  const payload = {
    email: email.value,
    password: password.value,
  };

  try {
    const response = await axiosClient.post("/login", payload);
    authLogin(response.data.token, response.data.user);

    router.push("/home"); // Redirect to home after login user@gmail.com userss123
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors || { email: [error.response.data.message] };
    }
  }
};
</script>

<template>
  <div class="auth-container">
    <img src="" alt="" class="LoginIMG" >
    <form @submit.prevent="login" class="auth-form">
      <h2>Login</h2>
        <div class="form-group">
          <label for="email" >Email</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password"required>
        </div>

      <button type="submit">Login</button>

      <p class="auth-link">
        Don't have an account? 
        <router-link to="/register">Register</router-link>
      </p>
    </form>
  </div>
</template>

<style scoped>
@import '../assets/Login.css';
</style>