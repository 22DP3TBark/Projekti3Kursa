<script setup>
import PropertyCard from '../components/PropertyCard.vue';

const properties = [
   {
      id: 1,
    title: 'Modern Downtown Apartment',
    price: 599000,
    bedrooms: 2,
    bathrooms: 2,
    sqft: 1200,
    address: '123 Main St, Downtown, City',
    image: 'https://static.vecteezy.com/system/resources/thumbnails/023/307/449/small_2x/ai-generative-exterior-of-modern-luxury-house-with-garden-and-beautiful-sky-photo.jpg'
  }
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