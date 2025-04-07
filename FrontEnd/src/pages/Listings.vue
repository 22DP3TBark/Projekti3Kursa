<script setup>
import { ref, onMounted, watch } from "vue";
import axiosClient from "../../axiosClient";
import { useRoute } from "vue-router";

const route = useRoute();   
const properties = ref([]);
const searchQuery = ref(route.query.q || "");
const filteredProperties = ref([]);


// Fetch properties
const fetchProperties = async () => {
  try {
    const response = await axiosClient.get("/properties");
    properties.value = response.data.properties; // Ensure this matches API response
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
};


// search properties
const searchProperties = async () => {
    if(!searchQuery.value) {
        fetchProperties(); // Fetch all properties if search query is empty
        return;
    }


    try {
        const response = await axiosClient.get("/properties/search", {
            params: {
                q: searchQuery.value
            }
        })
        properties.value = response.data
    } catch (error){
        console.error("Error searching properties:", error);
    }
}

onMounted(() => {
    if(searchQuery.value) {
        searchProperties(); // Fetch properties based on search query
    } else {
        fetchProperties(); // Fetch all properties if no search query
    }
})

// Also update results if the query changes (e.g., via router push)
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
        <!-- Headers -->
        <header class="header">
            <h1>Property Listings</h1>
            <div class="search">
                <input v-model="searchQuery" @keyup="searchProperties" type="text" class="ListInput"  placeholder="🔍 Search properties by location, type, or keyword...">
                
                <button @click="searchProperties" class="ListButton">Search</button>
            </div>
        </header>

        <!-- MainContent -->

        <main class="main-content">
            <aside class="filters">
                <h2>Filters</h2>

                <!-- Filter by Price -->
                <div class="filter-group">
                    <label for="">PriceRange</label>
                    <div class="input-group">
                        <input type="text" placeholder="min price">
                        <input type="text" placeholder="Max price" >
                    </div>
                </div>

                <!-- Filter by Type -->
                <div class="filter-group">
                    <label for="">Property Type:</label>
                    <div class="checkbox-group">
                        <label for=""><input type="checkbox">House</label>
                        <label for=""><input type="checkbox">Aparment</label>
                        <label for=""><input type="checkbox"> studio</label>
                    </div>
                </div>

                <!-- Bathrooms -->
                <div class="filter-group">
                <label>Bathrooms:</label>
                <select>
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
                    <label><input type="checkbox"> Balcony</label>
                    <label><input type="checkbox"> Garage</label>
                    <label><input type="checkbox"> Swimming Pool</label>
                </div>
                </div>

                <!-- Apply Filters Button -->
                <button class="apply-filters">Apply Filters</button>
            </aside>

            <!-- Listings -->
            <section class="listings">
                <h2>Available Properties</h2>
                <div class="properties-grid">
                    <div v-if="properties.length === 0" class="no-properties">
                        <p>No properties available at the moment.</p>
                    </div>
                    <div v-else v-for="property in properties" :key="property.id" class="property-card">
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