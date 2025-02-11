<script setup lang="ts">


</script>

<template>
  <nav class="navbar">
    
    <div class="navbar-menu" >
      <p>SkyLine</p>
      <router-link to="/home" class="nav-link">Home</router-link>
      <router-link to="/list" class="nav-link">Listings</router-link>
      <router-link to="/Props" class="nav-link">Search</router-link>
      
      <div class="topnav-right">
      <router-link to="/login" class="nav-link">Login</router-link>
      <router-link to="/Register" class="nav-link">Register</router-link>
      </div>  
     
      
    </div>
  </nav>
</template>

<style scoped>
@import '../assets/Navbar.css';
</style>