<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuth } from "../stores/useAuth";

const router = useRouter();
const { isAuthenticated, user, logout, checkAuth, isAdmin } = useAuth();
  
// Check auth on mount
onMounted(() => {
  checkAuth(); // Ensure this updates isAdmin correctly
});

console.log(user.value)
</script>

<template>
  <header>
    <nav class="navbar">
      <div class="navbar-container">
          <div class="logo">
            Kaspar
          </div>

          <!-- Navigation Links -->
      <ul class="nav-links">
        <li class="button-33"><router-link to="/home">Home</router-link></li>
        <li class="button-33"><router-link  to="/list">Listings</router-link></li>
        <li class="button-33" v-if="isAdmin"><router-link to="/admindash">Dashboard </router-link></li>
        <li class="button-33" v-if="isAuthenticated"><router-link to="/userprop">Property </router-link></li>
       
      </ul>
      </div>
      <div class="user-profile">
      <router-link to="/profile"><a href="" class="" v-if="isAuthenticated">{{ user?.name }} {{ user.lastname }}</a></router-link>
      <li class="button-33" v-if="isAuthenticated" @click="logout()">Logout</li>
      </div>

      <!-- Authentication Actions -->
      <div class="auth-actions">
        <template v-if="!isAuthenticated">
          <router-link to="/login" class="button-33">Login</router-link>
          <router-link to="/register" class="button-33">Register</router-link>
        </template>
      </div>
    </nav>
  </header>
</template>

<style scoped>
@import '../assets/Navbar.css';
</style>