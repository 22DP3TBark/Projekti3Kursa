<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axiosClient from '../../axiosClient';

const route = useRoute();
const property = ref(null);
const errorMessage = ref(null);

const fetchProperty = async () => {
  try {
    const response = await axiosClient.get(`/properties/${route.params.id}`);
    property.value = response.data.property;
  } catch (error) {
    console.error("Error fetching property:", error);
    errorMessage.value = "Could not load property details.";
  }
};

onMounted(fetchProperty);
</script>

<template>
  <main class="property-details-container" v-if="property">
    <div class="main-content">
      <!-- Left Side - Image -->
      <div class="image-gallery">
        <img :src="property.main_image || '/assets/placeholder.jpg'" alt="Main Property" />
        <div class="thumbnails">
          <img v-for="(img, index) in property.gallery || []" :key="index" :src="img" alt="Gallery" />
        </div>
      </div>

      <!-- Right Side - Info -->
      <div class="info-card">
        <h1>{{ property.title }}</h1>
        <p class="address">{{ property.address }}</p>
        <p class="price">${{ property.price.toLocaleString() }}</p>

        <div class="basic-info">
          <span><i class="fas fa-bed"></i> {{ property.bedrooms }} beds</span>
          <span><i class="fas fa-bath"></i> {{ property.bathrooms }} baths</span>
          <span><i class="fas fa-ruler-combined"></i> {{ property.size }} sq. ft.</span>
        </div>

        <section class="section">
          <h3>Description</h3>
          <p>{{ property.description }}</p>
        </section>

        <section class="section">
          <h3>Closer Location</h3>
          <ul>
            <li><i class="fas fa-map-marker-alt"></i> Park - 0.5 miles</li>
            <li><i class="fas fa-map-marker-alt"></i> View Point - 1.5 miles</li>
            <li><i class="fas fa-map-marker-alt"></i> School - 2.5 miles</li>
          </ul>
        </section>

        <section class="section">
          <h3>Key Features</h3>
          <ul>
            <li>Available cooling</li>
            <li>Detached garage</li>
            <li>Picnic area</li>
            <li>Sauna</li>
            <li>Swimming pool</li>
            <li>Dishwasher</li>
            <li>Cable TV ready</li>
          </ul>
        </section>
      </div>
    </div>

    <!-- Agent Section -->
    <div class="agent-box">
      <div class="agent-info">
        <div class="agent-icon">bm</div>
        <div>
          <h4>Brandon Mill Subdivision</h4>
          <p class="profile-link">View Profile</p>
          <p class="description">
            Brandon Mill Subdivision is a company full of professional staff.
            Call us anytime if you want to book a viewing.
          </p>
        </div>
      </div>
      <div class="actions">
        <button class="call"><i class="fas fa-phone"></i> Call now</button>
        <button class="email"><i class="fas fa-envelope"></i> Email</button>
      </div>
    </div>
  </main>

  <div v-else class="loading">Loading property...</div>
</template>

<style scoped>
@import '../assets/listings/PropertyPage.css'
</style>
