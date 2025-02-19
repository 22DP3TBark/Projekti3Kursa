<script setup>
import { ref, provide } from 'vue';
import Navbar from '@/components/Navbar.vue';


</script>

<template>
  <Navbar />
  <div>
    <router-view/>
  </div>
  


</template>

<style scoped>
@import '@/assets/App.css';
</style>