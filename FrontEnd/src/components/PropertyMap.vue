<script setup>
import { onMounted, ref, nextTick } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axiosClient from '../../axiosClient';
import { useRoute } from 'vue-router';

const mapContainer = ref(null);
const route = useRoute();

const getCords = async () => {
  try {
    const response = await axiosClient.get(`/properties/${route.params.id}`);
    const property = response.data.property;
    return [property.latitude, property.longitude];
  } catch (error) {
    console.error("Error fetching property coordinates:", error);
    return [56.9496, 24.1052]; // Default to Riga if there's an error
  }
};

onMounted(async () => {
  await nextTick(); // Ensure DOM is rendered before initializing map
  const coordinates = await getCords();

  const map = L.map(mapContainer.value).setView(coordinates, 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.marker(coordinates)
    .addTo(map)
    .bindPopup('Property Location')
    .openPopup();

  // Fix map resize if parent is flex or hidden initially
  setTimeout(() => {
    map.invalidateSize();
  }, 300);
});
</script>

<template>
  <div ref="mapContainer" class="property-map-container" />
</template>

<style scoped>
.property-map-container {
  width: 100%;
  min-width: 320px;
  height: 400px;
  min-height: 300px;
  border-radius: 12px;
  margin: 0 auto;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  background: #e9ecef;
  display: block;
}
</style>