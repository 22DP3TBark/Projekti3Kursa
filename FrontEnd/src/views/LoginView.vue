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

  // Call validateForm and stop if invalid
  if (!validateForm()) {
    return;
  }

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

const errorss = ref({
  email: "",
  password: "",
})

const validateForm = () => {
  let valid = true;

  errorss.value = {
    email: "",
    password: "",
  };

  // Email verification
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email.value.trim()) {
    errorss.value.email = "Email is required"; // Update errorss, not errors
    valid = false;
  } else if (!emailPattern.test(email.value)) {
    errorss.value.email = "Invalid email format"; // Update errorss, not errors
    valid = false;
  }

  return valid;
};
</script>

<template>
  <main class="main-container">
      <div class="container">
        <div class="form">
        
          <form class="form-container" @submit.prevent="login">
            <h1>Login</h1>
            
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" v-model="email" required />
              <p v-if="errorss.email" class="error">{{ errorss.email }}</p>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" v-model="password" required />
            </div>
            <router-link to="/forgotPassword"><button type="button" class="forgot-password" @click="forgotPassword">Forgot Password?</button></router-link>

            <button type="submit" class="btn-login">Login</button>
            
            

            <p class="auth-link">
        Don't have an account? 
        <router-link to="/register">Register</router-link>
      </p>
          </form>
          
          <p v-if="errors" class="error">{{ errors }}</p>
        </div>
        <div class="image"><img src="" alt=""></div>        
      </div>
  </main>
</template>

<style scoped>
@import '../assets/Login.css';
</style>