<script setup>
import { ref, onMounted } from "vue";
import axiosClient from "../../axiosClient";


const properties = ref([]);

const fetchProperties = async () => {
  try {
    const response = await axiosClient.get('/properties');
    properties.value = response.data.properties; // Ensure this matches API response
    console.log("Fetched properties:", properties.value); // Debugging
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
};

onMounted(fetchProperties);
</script>

<template> 
<div class="property-list">
    <h1>Property Listings</h1>

    <div v-if="properties.length === 0" class="no-properties">
      <p>No properties available.</p>
    </div>

    <div v-else class="grid-container">
      <div v-for="property in properties" :key="property.id" class="property-card">
        <img :src="property.main_image" alt="Property Image" class="property-image" v-if="property.main_image" />
        <div class="property-info">
          <h3>{{ property.title }}</h3>
          <p class="description">{{ property.description }}</p>
          <p class="price">Price: {{ property.price }} {{ property.currency }}</p>
          <p class="location">{{ property.city }}, {{ property.country }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.property-list {
  text-align: center;
  padding: 20px;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  padding: 20px;
}

.property-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease-in-out;
}

.property-card:hover {
  transform: scale(1.05);
}

.property-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.property-info {
  padding: 15px;
}

h3 {
  margin: 10px 0;
  font-size: 1.2rem;
}

.description {
  font-size: 0.9rem;
  color: #555;
}

.price {
  font-weight: bold;
  color: #2c3e50;
}

.location {
  font-size: 0.9rem;
  color: #777;
}

.no-properties {
  font-size: 1.2rem;
  color: red;
  font-weight: bold;
}
</style>