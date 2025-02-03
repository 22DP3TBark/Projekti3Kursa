<script setup>

import { ref } from "vue";
import api from "@/Plugins/VUEapi";

const name = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const message = ref("");

const register = async () => {
  try {
    const response = await api.post("http://127.0.0.1:8000/api/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });

    message.value = "Registration successful!";

    console.log(response.data);
  } catch (error){
    message.value = error.response?.data?.errors || "An error occurred";
    console.error(error);
  }
};

</script>

<template>
    <div class="auth-container">
      <form @submit.prevent="register"  class="auth-form">
        <h2>Register</h2>

          <div class="form-group">
            <label for="name">Name</label>
            <input v-model="name" type="text" id="name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input v-model="email" type="email" id="email" required>
          </div>
  
          <div class="form-group">
            <label for="password">Password</label>
            <input v-model="password" type="password" id="password" required>
          </div>
    
          <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input v-model="password_confirmation" type="password" id="confirm-password" required>
          </div>
  
        <button type="submit">Register</button>
          
        <p v-if="message">{{ message }}</p>

          <p class="auth-link">
          Already have an account? 
          <router-link to="/login">Login</router-link>
        </p>
      </form>
    </div>
  </template>
  
<style scoped>
  @import '../assets/Register.css';
</style>