<script setup>
import { onMounted, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const mapContainer = ref(null);

onMounted(() => {
  const map = L.map(mapContainer.value).setView([56.9496, 24.1052], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  L.marker([56.9496, 24.1052])
    .addTo(map)
    .bindPopup('Property location (Riga)')
    .openPopup();
});
</script>

<template>
  <div ref="mapContainer" style="height: 400px; width: 100%; border-radius: 12px;" />
</template>

<style scoped>

</style>