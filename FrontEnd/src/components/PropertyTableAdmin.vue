<script setup>
import { ref, onMounted, watch } from "vue";
import axiosClient from "../../axiosClient";
import Modal from "@/components/Model.vue"; // Import the Modal component

// Reactive state
const properties = ref([]);
const filteredProperties = ref([]);
const selectedProperty = ref(null); // Store the selected property for editing

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

// Select property for editing
const selectProperty = (property) => {
  selectedProperty.value = { ...property }; // Clone property for editing
};

// Update property
const updateProperty = async () => {
  if (!selectedProperty.value) return;

  try {
    const response = await axiosClient.put(
      `/property/${selectedProperty.value.id}`,
      selectedProperty.value
    );
    fetchProperties(); // Refresh the property list
    selectedProperty.value = null; // Close the form
    alert("Property updated successfully!");
  } catch (error) {
    console.error("Error updating property:", error);
    alert("Failed to update property. Please try again.");
  }
};

// Delete property
const deleteProperty = async (id) => {
  if(confirm('Are you sure you want to delete this property?')) {
    try {
      await axiosClient.delete(`/property/${id}`);
      fetchProperties(); // Refresh the property list
      alert("Property deleted successfully!");
    } catch (error) {
      console.error("Error deleting property:", error);
      alert("Failed to delete property. Please try again.");
    }
  }
};

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
          <td>
            <button @click="selectProperty(property)" class="action-btn edit">Edit</button>
            <button @click="deleteProperty(property.id)" class="action-btn delete">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Edit Property Modal -->
    <Modal v-if="selectedProperty" :close="() => selectedProperty = null">
      <h2>Edit Property</h2>
      <form @submit.prevent="updateProperty">
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea v-model="selectedProperty.description" id="description" required></textarea>
        </div>
        <div class="form-group">
          <label for="price">Price:</label>
          <input v-model="selectedProperty.price" id="price" type="number" min="0" required />
        </div>
        <div class="form-group">
          <label for="status">Status:</label>
          <select v-model="selectedProperty.status" id="status" required>
            <option value="available">Available</option>
            <option value="sold">Sold</option>
            <option value="rented">Rented</option>
          </select>
        </div>
        <div class="form-group">
          <label for="address">Address:</label>
          <input v-model="selectedProperty.address" id="address" type="text" required />
        </div>
        <div class="form-group">
          <label for="city">City:</label>
          <input v-model="selectedProperty.city" id="city" type="text" required />
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-update">Update Property</button>
          <button type="button" @click="selectedProperty = null" class="btn btn-cancel">Cancel</button>
        </div>
      </form>
    </Modal>
  </div>
</template>

<style scoped>
@import '../assets/PropTableAdmin.css';


</style>
