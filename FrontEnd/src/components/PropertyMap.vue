<script setup>
import { onMounted, ref } from 'vue';
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
  const coordinates = await getCords();

  const map = L.map(mapContainer.value).setView(coordinates, 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.marker(coordinates)
    .addTo(map)
    .bindPopup('Property Location')
    .openPopup();
});
</script>

<template>
  <div ref="mapContainer" style="height: 400px; width: 100%; border-radius: 12px;" />
</template>

<style scoped>
/* Add any additional styles if needed */
</style>