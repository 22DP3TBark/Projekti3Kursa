<template>
  <div class="location-step">
    <!-- Address Inputs -->
    <div class="form-group">
      <input v-model="street" placeholder="Street Address" />
      <input v-model="city" placeholder="City" />
      <input v-model="state" placeholder="State" />
      <input v-model="country" placeholder="Country" />
    </div>
    <button @click="geocodeAddress">📍 Find Location</button>

    <!-- Map -->
    <div v-if="showMap" id="map" style="height: 400px; margin-top: 1rem;"></div>

    <!-- Hidden form data or emit to parent -->
    <input type="hidden" :value="lat" name="latitude" />
    <input type="hidden" :value="lon" name="longitude" />
  </div>
</template>

<script setup>
import { ref, nextTick, watch } from 'vue'
import L from 'leaflet'

// Define emits for parent communication
const emit = defineEmits(['update:street', 'update:city', 'update:state', 'update:country', 'update:lat', 'update:lon'])

// Refs for form input
const street = ref('')
const city = ref('')
const state = ref('')
const country = ref('')
const lat = ref(0)
const lon = ref(0)
const showMap = ref(false)

let map = null
let marker = null

// Watch for changes and emit updates to the parent
watch([street, city, state, country, lat, lon], () => {
  emit('update:street', street.value)
  emit('update:city', city.value)
  emit('update:state', state.value)
  emit('update:country', country.value)
  emit('update:lat', lat.value)
  emit('update:lon', lon.value)
})

// Function to get coordinates from address
const geocodeAddress = async () => {
  const fullAddress = `${street.value}, ${city.value}, ${state.value}, ${country.value}`

  const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}`)
  const data = await response.json()

  if (data.length > 0) {
    lat.value = parseFloat(data[0].lat)
    lon.value = parseFloat(data[0].lon)
    showMap.value = true
    loadMap()
  } else {
    alert('Location not found. Please check the address.')
  }
}

// Function to initialize or update the map
const loadMap = async () => {
  const position = [lat.value, lon.value]

  await nextTick(); // Ensure the DOM is updated before accessing the #map element

  if (!map) {
    map = L.map('map').setView(position, 16)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map)

    marker = L.marker(position, { draggable: true }).addTo(map)
    marker.on('dragend', () => {
      const pos = marker.getLatLng()
      lat.value = pos.lat
      lon.value = pos.lng
    })
  } else {
    map.setView(position, 16)
    marker.setLatLng(position)
  }
}
</script>

<style scoped>
.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 1rem;
}

input {
  padding: 8px;
  font-size: 1rem;
  width: 100%;
  box-sizing: border-box;
}

button {
  padding: 10px 14px;
  font-size: 1rem;
  background-color: #3b82f6;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #2563eb;
}
</style>
