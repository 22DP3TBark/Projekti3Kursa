<script setup>
import { ref, onMounted, watch } from "vue";
import axiosClient from "../../axiosClient";
import { useRoute } from "vue-router";

const route = useRoute();   
const properties = ref([]);
const searchQuery = ref(route.query.q || "");

// Filters
const filters = ref({
  minPrice: "",
  maxPrice: "",
  propertyTypes: [],
  bathrooms: "",
  amenities: [],
});

// Fetch all properties
const fetchProperties = async () => {
  try {
    const response = await axiosClient.get("/properties");
    properties.value = response.data.properties || response.data; // Adjust if needed
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
};

// Search with filters
const searchProperties = async () => {
  try {
    const response = await axiosClient.get("/properties/search", {
      params: {
        q: searchQuery.value,
        min_price: filters.value.minPrice,
        max_price: filters.value.maxPrice,
        property_types: filters.value.propertyTypes.join(","),
        bathrooms: filters.value.bathrooms,
        amenities: filters.value.amenities.join(","),
      },
    });
    properties.value = response.data;
  } catch (error) {
    console.error("Error searching properties:", error);
  }
};

onMounted(() => {
  if (searchQuery.value) {
    searchProperties();
  } else {
    fetchProperties();
  }
});

// Watch for query string changes
watch(
  () => route.query.q,
  (newQuery) => {
    searchQuery.value = newQuery || "";
    if (searchQuery.value) {
      searchProperties();
    } else {
      fetchProperties();
    }
  }
);
</script>

<template>
  <div class="listings-container">
    <!-- Header -->
    <header class="header">
      <h1>Property Listings</h1>
      <div class="search">
        <input
          v-model="searchQuery"
          @keyup.enter="searchProperties"
          type="text"
          class="ListInput"
          placeholder="🔍 Search properties by location, type, or keyword..."
        />
        <button @click="searchProperties" class="ListButton">Search</button>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
      <aside class="filters">
        <h2>Filters</h2>

        <!-- Price Range -->
        <div class="filter-group">
          <label>Price Range</label>
          <div class="input-group">
            <input type="number" v-model="filters.minPrice" placeholder="Min price" />
            <input type="number" v-model="filters.maxPrice" placeholder="Max price" />
          </div>
        </div>

        <!-- Property Type -->
        <div class="filter-group">
          <label>Property Type:</label>
          <div class="checkbox-group">
            <label><input type="checkbox" value="House" v-model="filters.propertyTypes" /> House</label>
            <label><input type="checkbox" value="Apartment" v-model="filters.propertyTypes" /> Apartment</label>
            <label><input type="checkbox" value="Studio" v-model="filters.propertyTypes" /> Studio</label>
          </div>
        </div>

        <!-- Bathrooms -->
        <div class="filter-group">
          <label>Bathrooms:</label>
          <select v-model="filters.bathrooms">
            <option value="">Any</option>
            <option value="1">1+</option>
            <option value="2">2+</option>
            <option value="3">3+</option>
          </select>
        </div>

        <!-- Amenities -->
        <div class="filter-group">
          <label>Amenities:</label>
          <div class="checkbox-group">
            <label><input type="checkbox" value="Balcony" v-model="filters.amenities" /> Balcony</label>
            <label><input type="checkbox" value="Garage" v-model="filters.amenities" /> Garage</label>
            <label><input type="checkbox" value="Swimming Pool" v-model="filters.amenities" /> Swimming Pool</label>
          </div>
        </div>

        <!-- Apply Filters Button -->
        <button class="apply-filters" @click="searchProperties">Apply Filters</button>
      </aside>

      <!-- Property Listings -->
      <section class="listings">
        <h2>Available Properties</h2>
        <div class="properties-grid">
          <div v-if="properties.length === 0" class="no-properties">
            <p>No properties available at the moment.</p>
          </div>
          <div
            v-else
            v-for="property in properties"
            :key="property.id"
            class="property-card"
            @click="$router.push({ name: 'PropertyDetails', params: { id: property.id } })"
            style="cursor: pointer;"
          >
            <div class="property-image-container">
              <img :src="property.main_image" alt="Property Image" class="property-image" />
            </div>
            <div class="property-details">
              <h3 class="property-title">{{ property.city }}</h3>
              <p class="property-address">{{ property.address }}</p>
              <p class="property-price">Price: ${{ property.price }}</p>
              <p class="property-rooms">Rooms: {{ property.bedrooms }}</p>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<style scoped>
@import '../assets/listings/Listings.css';
</style>
