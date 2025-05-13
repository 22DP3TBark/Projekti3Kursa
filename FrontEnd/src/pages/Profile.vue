<script setup>
import { useAuth } from "@/stores/useAuth";
import { ref, onMounted } from "vue";
import axiosClient from "../../axiosClient";
import Modal from "../components/Model.vue";

const { user } = useAuth();
const isEditing = ref(false);
const currentSection = ref('profile'); // Default view
const properties = ref([])

const isEditingProperty = ref(false);
const selectedProperty = ref(null);

const passwordData = ref({
  current_password: "",
  new_password: "",
  new_password_confirmation: ""
});

const message = ref("");

const enableEditing = () => {
  isEditing.value = true;
};

const cancelEditing = () => {
  isEditing.value = false;
};

const fetchUserProfile = async () => {
  try {
    const response = await axiosClient.get('/profile');
    user.value = response.data;
  } catch (error) {
    console.error("Error fetching user profile:", error);
  }
};

const updateProfile = async () => {
  try {
    const response = await axiosClient.put('/profile/update', {
      name: user.value.name,
      lastname: user.value.lastname,
      username: user.value.username,
      phone: user.value.phone
    });

    // Update the user object with the response data
    user.value = response.data;

    // Close the modal
    isEditing.value = false;

    alert("Profile updated successfully!");
  } catch (error) {
    console.error("Error updating profile:", error);
    alert("Failed to update profile. Please try again.");
  }
};

const updatePassword = async () => {
  try {
    const response = await axiosClient.put('/profile/update-password', {
      current_password: passwordData.value.current_password,
      new_password: passwordData.value.new_password,
      new_password_confirmation: passwordData.value.new_password_confirmation
    });
    message.value = response.data.message;

    passwordData.value = { current_password: "", new_password: "", new_password_confirmation: "" };
    alert("Password updated successfully!");
  } catch (error) {
    console.error("Error updating password:", error);
  }
};

const editProperty = async(property) => {
  // Logic to edit a property
  try{
    const response = await axiosClient.put(`/user/properties/${property.id}`);
    const propertyData = response.data;

    console.log("Property data:", propertyData); // Debugging
  }catch{(error) => {
    console.error("Error fetching property details:", error);
    alert("Failed to fetch property details. Please try again.");
  }
}
};

const deleteProperty = async (propertyId) => {
  const confirmation = confirm("Are you sure you want to delete this property?");
  if (!confirmation) {
    return; // Exit if the user cancels the action
  }

  try {
    await axiosClient.delete(`/user/properties/${propertyId}`);
    properties.value = properties.value.filter((property) => property.id !== propertyId);
    alert("Property deleted successfully!");
  } catch (error) {
    console.error("Error deleting property:", error);
    alert("Failed to delete property. Please try again.");
  }
};

const openEditPropertyModal = (property) => {
  selectedProperty.value = { ...property }; // Clone the property data
  isEditingProperty.value = true;
};

const closeEditPropertyModal = () => {
  isEditingProperty.value = false;
  selectedProperty.value = null;
};

const saveEditedProperty = async () => {
  try {
    const response = await axiosClient.put(`/user/properties/${selectedProperty.value.id}`, selectedProperty.value);
    const updatedProperty = response.data;

    // Update the properties list with the edited property
    const index = properties.value.findIndex((p) => p.id === updatedProperty.id);
    if (index !== -1) {
      properties.value[index] = updatedProperty;
    }

    alert("Property updated successfully!");
    closeEditPropertyModal();
  } catch (error) {
    console.error("Error updating property:", error);
    alert("Failed to update property. Please try again.");
  }
};

onMounted(async () => {
  try {
    const response = await axiosClient.get('/user/properties');
    properties.value = response.data; // Ensure this updates the `properties` ref
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
})

// Fetch user profile when the component is mounted
onMounted(() => {
  fetchUserProfile();
});
</script>

<template>
  

  <main>
  <div class="profile-layout">
    <aside class="profile-aside">
      <div class="tabs">
        <button @click="currentSection = 'profile'" :class="{ active: currentSection === 'profile' }" class="tab-button">Profile</button>
        <button @click="currentSection = 'security'" :class="{ active: currentSection === 'security' }" class="tab-button">Security</button>
        <button @click="currentSection = 'properties'" :class="{ active: currentSection === 'properties' }" class="tab-button">My Properties</button>
      </div>
    </aside>
    <div class="profile-main">
      <!-- Profile Tab -->
      <div v-if="currentSection === 'profile'" class="tab-content">
        <h2>Profile Information</h2>
        <div class="profile-section"><label>First Name: {{ user.name }}</label></div>
        <div class="profile-section"><label>Last Name: {{ user.lastname }}</label></div>
        <div class="profile-section"><label>Username: {{ user.username }}</label></div>
        <div class="profile-section"><label>Email: {{ user.email }}</label></div>
        <div class="profile-section"><label>Phone Number: {{ user.phone }}</label></div>
        <button class="edit-btn" @click="enableEditing">Edit</button>
      </div>

      <!-- Edit Modal -->
      <Modal v-if="isEditing" @close="cancelEditing">
        <h3>Edit Profile</h3>
        <div>
          <label class="LABEL">Name:</label>
          <input class="INPUT" v-model="user.name" type="text" />
          <label class="LABEL">Last Name:</label>
          <input class="INPUT" v-model="user.lastname" type="text" />
          <label class="LABEL">Username:</label>
          <input class="INPUT" v-model="user.username" type="text" />
          <label class="LABEL">Phone:</label>
          <input class="INPUT" v-model="user.phone" type="text" />
        </div>
        <div class="options">
          <button class="SC-btn" @click="updateProfile">Save</button>
          <button class="SC-btn" @click="cancelEditing">Cancel</button>
        </div>
        
      </Modal>

      <!-- Security Tab -->
      <div v-if="currentSection === 'security'" class="tab-content">
        <h2>Change Password</h2>
        <div class="profile-section">
          <label>Current Password:</label>
          <input type="password" v-model="passwordData.current_password" class="input-field" required />
        </div>
        <div class="profile-section">
          <label>New Password:</label>
          <input type="password" v-model="passwordData.new_password" class="input-field" required />
        </div>
        <div class="profile-section">
          <label>Confirm Password:</label>
          <input type="password" v-model="passwordData.new_password_confirmation" class="input-field" required />
        </div>
        <button class="save-button" @click="updatePassword">Update Password</button>
        <p v-if="message" class="message">{{ message }}</p>
      </div>

      <!-- Properties Tab -->
      <div v-if="currentSection === 'properties'" class="tab-content">
        <h2>My Property Listings</h2>
        <div v-if="properties.length" class="properties-grid">
          <div v-for="property in properties" :key="property.id" class="property-card">
            <img :src="property.main_image" alt="Property Image" class="property-image" v-if="property.main_image" />
            <div class="property-info">
              <h3>{{ property.title }}</h3>
              
              <p class="price">Price: {{ property.price }} {{ property.currency }}</p>
              <p class="location">{{ property.city }}, {{ property.country }}</p>
            </div>
              <div class="property-actions">
                <button class="edit-btn" @click="openEditPropertyModal(property)">Edit</button>
                <button class="delete-btn" @click="deleteProperty(property.id)">Delete</button>
              </div>
      </div>
        </div>
        <p v-else>You have no property listings yet.</p>
      </div>
    </div>
  </div>
</main>

<Modal v-if="isEditingProperty" @close="closeEditPropertyModal">
  <h3>Edit Property</h3>
  <div>
    <label class="LABEL">Title:</label>
    <input class="INPUT" v-model="selectedProperty.title" type="text" />
    <label class="LABEL">Description:</label>
    <textarea class="INPUT" v-model="selectedProperty.description"></textarea>
    <label class="LABEL">Price:</label>
    <input class="INPUT" v-model="selectedProperty.price" type="number" />
    <label class="LABEL">Currency:</label>
    <input class="INPUT" v-model="selectedProperty.currency" type="text" />
    <label class="LABEL">City:</label>
    <input class="INPUT" v-model="selectedProperty.city" type="text" />
    <label class="LABEL">Country:</label>
    <input class="INPUT" v-model="selectedProperty.country" type="text" />
  </div>
  <div class="options">
  <button class="SC-btn" @click="saveEditedProperty">Save</button>
  <button class="SC-btn" @click="closeEditPropertyModal">Cancel</button>
</div>
</Modal>
</template>

<style scoped>
@import '../assets/Profile.css';

.properties-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.property-card {
  background-color: #f9f9f9;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%;
}

.property-image{
  width: 90%;
  height: auto;
  border-radius: 10px;
 
  height: 140px; /* Set a fixed height for uniformity */
  
 
}

.property-card h3 {
  font-size: 20px;
  color: #0b236b;
  margin-bottom: 10px;
}

.property-card p {
  font-size: 14px;
  color: #555;
  margin-bottom: 15px;
}

.property-actions {
  display: flex;
  justify-content: space-between;
}

.edit-btn,
.delete-btn {
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.edit-btn {
  background-color: #0b236b;
  color: white;
}

.edit-btn:hover {
  background-color: #09205a;
}

.delete-btn {
  background-color: #d9534f;
  color: white;
}

.delete-btn:hover {
  background-color: #c9302c;
}
</style>