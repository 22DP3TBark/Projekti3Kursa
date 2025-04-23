<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useAuth } from "../stores/useAuth";

const router = useRouter();
const { isAuthenticated, user, logout, checkAuth, isAdmin } = useAuth();
const isScrolled = ref(false);

// Check auth on mount
onMounted(() => {
  checkAuth(); // Ensure this updates isAdmin correctly

  const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
  };

  window.addEventListener("scroll", handleScroll);

  onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
  });
});
</script>

<template>
  <header>
    <nav :class="['navbar', { 'scrolled': isScrolled }]">
      <div class="navbar-container">
        <div class="logo">Kaspar</div>

        <!-- Navigation Links -->
        <ul class="nav-links">
          <li class="button-33"><router-link to="/home">Home</router-link></li>
          <li class="button-33"><router-link to="/list">Listings</router-link></li>
          <li class="button-33" v-if="isAdmin"><router-link to="/admindash">Dashboard</router-link></li>
         
          <li class="button-33" v-if="isAuthenticated"><router-link to="/property-submission">Prop Sub</router-link></li>
        </ul>
      </div>
      <div class="user-profile">
        <router-link to="/profile">
          <a href="" class="user-name" v-if="isAuthenticated">{{ user?.name }}</a>
        </router-link>
        <li class="logout-btn" v-if="isAuthenticated" @click="logout()">Logout</li>
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