<script setup>
import {useAuthStore} from '@/stores/Auth';
import { computed, onMounted } from "vue";

const authStore = useAuthStore();

// load user on page refresh passing@192
onMounted(() => {
  authStore.loaduser();
});

const user = computed(() => authStore.user);


</script>

<template>
  <nav class="navbar">
    <div class="navbar-menu" >
      <p>SkyLine</p>
      <router-link to="/home" class="nav-link">Home</router-link>
      <router-link to="/list" class="nav-link">Listings</router-link>
      <router-link to="/Props" class="nav-link">Search</router-link>
      <a v-if="user" href="">Sludinajums</a>
      <router-link v-if="user" to="/userdash" class="nav-link">User</router-link>
      
      <div class="topnav-right">
      <router-link v-if="!user" to="/login" class="nav-link">Login</router-link>
      <router-link v-if="!user" to="/Register" class="nav-link">Register</router-link>
      </div>  

      <div v-if="user" class="userLog">
        
        <span class="UserName">Welcom,{{ user.name }}</span>
        <button class="Logout-btn" @click="authStore.logout">Logout</button>
      </div>
     
      
    </div>
  </nav>
</template>

<style scoped>
@import '../assets/Navbar.css';
</style>