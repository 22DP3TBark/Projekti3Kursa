<script setup>
import PropertyCard from '../components/PropertyCard.vue';

const properties = [
  
];

</script>

<template>
   <div class="container">
    <header>
      <h1>Featured Properties</h1>
      <p>Find your dream home from our selected properties</p>
    </header>
    
    <div class="properties-grid">
      <PropertyCard 
      />
    </div>
  </div>

</template>

<style scoped>
@import '../assets/Listings.css';
</style>