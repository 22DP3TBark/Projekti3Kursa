<script setup >
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/Auth";

const authStore = useAuthStore();
const email = ref("");
const password = ref("");
const errorMessage = ref("");
const router = useRouter();

const loginUser = async () => {
  try {
    const response = await axios.post("http://127.0.0.1:8000/api/login", {
      email: email.value,
      password: password.value,
    });

    localStorage.setItem("token", response.data.token);
    localStorage.setItem("user", JSON.stringify(response.data.user));

    //Updates pinia imidiatly
    authStore.setUser(response.data.user);

    console.log(response.data);
    router.push("home"); // Redirect to user page after login
  } catch (error) {
    
  }
};


</script>

<template>
  <div class="auth-container">
    <img src="" alt="" class="LoginIMG" >
    <form @submit.prevent="loginUser" class="auth-form">
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