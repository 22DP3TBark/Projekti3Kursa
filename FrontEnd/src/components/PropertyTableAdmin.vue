<script setup>
import { ref, onMounted, watch } from "vue";
import axiosClient from "../../axiosClient";

// Reactive state
const properties = ref([]);
const filteredProperties = ref([]);

// Props
const props = defineProps({
  searchQuery: {
    type: String,
    default: "",
  },
});

// Fetch properties
const fetchProperties = async () => {
  try {
    const response = await axiosClient.get("/properties");
    properties.value = response.data.properties; // Ensure this matches API response
    filteredProperties.value = properties.value; // Initialize filteredProperties
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
};

// Watch for changes in searchQuery and filter properties
watch(
  () => props.searchQuery,
  (newQuery) => {
    const lowerCaseQuery = newQuery.toLowerCase();
    filteredProperties.value = properties.value.filter((property) =>
      Object.values(property).some((value) =>
        String(value).toLowerCase().includes(lowerCaseQuery)
      )
    );
  }
);

onMounted(fetchProperties);
</script>

<template>
  <div>
    <h2>Property Table</h2>
    <table class="user-table">
      <thead>
        <tr>
          <th>UserID</th>
          <th>PropertyID</th>
          <th>Title</th>
          <th>Price</th>
          <th>Address</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="property in filteredProperties" :key="property.id">
          <td>{{ property.user_id }}</td>
          <td>{{ property.id }}</td>
          <td>{{ property.title }}</td>
          <td>{{ property.price }}</td>
          <td>{{ property.address }}</td>
          <td>12-10-2005</td>
          <td>Edit Delete</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
@import '../assets/PropTableAdmin.css';
</style>