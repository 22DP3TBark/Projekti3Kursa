<script setup>

import { ref } from "vue";
import axiosClient from "../../axiosClient";
import router from "@/router";

const name = ref("");
const lastname = ref("");
const username = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const phone = ref("");
const message = ref("");

const register = async () => {
  const payload = {
    name: name.value,
    lastname: lastname.value,
    username: username.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    phone: phone.value,
  };

  try {
    const response = await axiosClient.post("/register", payload);

    if (response && response.data) {
      if (response.data.token && response.data.user) {
        localStorage.setItem("ACCESS_TOKEN", response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data.user));
        message.value = "Registration successful!";

        router.push("/login");
      } else {
        message.value = "Unexpected response formating";
      }
    } else {
      message.value = "Unexpected response format";
    }
  } catch (error) {
    if (error.response && error.response.data) {
      message.value = error.response.data.message;
    } else {
      message.value = "An error occurred";
    }
  }
};
</script>
<template>
 <main class="main-container">
    <div class="container">
    
      <div class="form">
        This loogo
        <h1>Create your account</h1>
        <div class="form-content">
          <form @submit.prevent="register" class="form-container" action="">

            <div class="form-group">
              <label for="name">Name</label>
              <input v-model="name" type="text" id="name" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input v-model="lastname" type="text" id="lastname" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input v-model="username" type="text" id="username" required>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input v-model="email" type="email" id="email" required>
            </div>

            <div class="form-group">
              <label for="phone">Phone</label>
              <input v-model="phone" type="text" id="phone" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="password" type="password" id="password" required>
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input v-model="password_confirmation" type="password" id="password_confirmation" required>
            </div>

            
              
            <!-- Move the button below all input fields -->
            <div class="form-group full-width">
              <p>By clicking Register, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>

      <p v-if="message">{{ message }}</p>
              <button class="btn-register" type="submit">Register</button>
            </div>
            <p class="auth-link">
        Already have an account?
        <router-link to="/login">Login</router-link>
        </p>
          </form>
          
        </div>
      </div>
      <div class="img"><img src="" alt=""></div>
    </div>
 </main>
</template>

<style scoped>
@import '../assets/Register.css';
</style>