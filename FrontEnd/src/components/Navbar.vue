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
</script>

<template>
  <nav class="navbar">
    <div class="navbar-menu">
      <p>SkyLine</p>
      <router-link to="/home" class="nav-link">Home</router-link>
      <router-link to="/list" class="nav-link">Listings</router-link>
      <router-link to="/userprop" class="nav-link" v-if="isAuthenticated">Property</router-link>
      <router-link to="/propertylist" v-if="isAuthenticated">NK</router-link>
      <router-link to="/admin" v-if="isAdmin">Admin Dashboard</router-link>
      

      <div class="topnav-right">
        <!-- Show Login/Register if NOT logged in -->
        <template v-if="!isAuthenticated">
          <RouterLink to="/login"  class="nav-link">Login</RouterLink>
          <RouterLink to="/register" class="nav-link">Register</RouterLink>
        </template>

        <!-- Show User name & Logout if logged in -->
        <template v-else>
          <router-link to="/profile"><span  class="UserName">Welcome, {{ user?.name }}</span></router-link>
          <button @click="logout" class="Logout-btn">Logout</button>
        </template>
      </div>
    </div>
  </nav>
</template>

<style scoped>
@import '../assets/Navbar.css';
</style>