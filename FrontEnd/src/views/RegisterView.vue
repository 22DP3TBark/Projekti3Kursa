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
  // Call validateForm and stop if invalid
  if (!validateForm()) {
    return;
  }

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
        message.value = "Unexpected response formatting";
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

// Validation errors object
const errors = ref({
  name: "",
  lastname: "",
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
  phone: "",
});

const validateForm = () =>{
  let valid = true;

  // Reset errors
  errors.value = {
    name: "",
    lastname: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    phone: "",
  };

  if(!name.value.trim()){
    errors.value.name = "Name is required";
    valid = false;
  }

  if(!lastname.value.trim()){
    errors.value.lastname = "Lastname is required";
    valid = false;
  }
  if(!username.value.trim()){
    errors.value.username = "Username is required";
    valid = false;
  } else if(username.value.length < 4){
    errors.value.username = "Username must be at least 4 characters long";
    valid = false;
  }

  // email varifivation 

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email.value.trim()) {
    errors.value.email = "Email is required";
    valid = false;
  } else if (!emailPattern.test(email.value)) {
    errors.value.email = "Invalid email format";
    valid = false;
  }

  // phone number verification

  const phonePattern = /^[0-9]{10}$/;
  if (!phone.value.trim()) {
    errors.value.phone = "Phone number is required";
    valid = false;
  } else if (!phonePattern.test(phone.value)) {
    errors.value.phone = "Phone number must be exactly 10 digits";
    valid = false;
  }

  // Password validation
  if (!password.value.trim()) {
    errors.value.password = "Password is required";
    valid = false;
  } else if (password.value.length < 8) {
    errors.value.password = "Password must be at least 8 characters long";
    valid = false;
  } else if (!/[A-Z]/.test(password.value) || !/[a-z]/.test(password.value) || !/[0-9]/.test(password.value) || !/[\W]/.test(password.value)) {
    errors.value.password = "Password must contain uppercase, lowercase, number, and special character";
    valid = false;
  }
  // Password confirmation validation
  if (!password_confirmation.value.trim()) {
    errors.value.password_confirmation = "Confirm password is required";
    valid = false;
  } else if (password_confirmation.value !== password.value) {
    errors.value.password_confirmation = "Passwords do not match";
    valid = false;
  }

  return valid;
}
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
              <p v-if="errors.name" class="error">{{ errors.name }}</p>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input v-model="lastname" type="text" id="lastname" required>
              <p v-if="errors.lastname" class="error">{{ errors.lastname }}</p>
              
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input v-model="username" type="text" id="username" required>
              <p v-if="errors.username" class="error">{{ errors.username }}</p>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input v-model="email" type="email" id="email" required>
              <p v-if="errors.email" class="error">{{ errors.email }}</p>
            </div>

            <div class="form-group">
              <label for="phone">Phone</label>
              <input v-model="phone" type="text" id="phone" required>
              <p v-if="errors.phone" class="error">{{ errors.phone }}</p>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="password" type="password" id="password" required>
              <p v-if="errors.password" class="error">{{ errors.password }}</p>
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input v-model="password_confirmation" type="password" id="password_confirmation" required>
              <p v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation }}</p>
            </div>

            
              
            <!-- Move the button below all input fields -->
            <div class="form-group full-width">
              <p>By clicking Register, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>

      <p v-if="message">{{ message }}</p>
              <button class="btn-register" type="submit">Register</button>
              <p class="auth-link">
              Already have an account?
              <span style="font-weight: bold;"><router-link to="/login">Login</router-link></span>
            </p>
            </div>
            
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