<script setup>
import { useAuth } from "@/stores/useAuth";
import { ref, onMounted } from "vue";
import axiosClient from "../../axiosClient";
import Modal from "../components/Model.vue";

const { user } = useAuth();
const isEditing = ref(false);
const currentSection = ref('profile'); // Default view
const properties = ref([])


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
<div class="profile-container">
    <!-- Tabs Navigation -->
    <div class="tabs">
      <button @click="currentSection = 'profile'" class="tab-button">Profile</button>
      <button @click="currentSection = 'security'" class="tab-button">Security</button>
      <button @click="currentSection = 'properties'" class="tab-button">My Properties</button>
    </div>

    <!-- Profile Tab -->
    <div v-if="currentSection === 'profile'" class="tab-content">
      <h2>Profile Information</h2>
      <div class="profile-section">
        <label>First Name: {{ user.name }}</label>
      </div>
      <div class="profile-section">
        <label>Last Name: {{ user.lastname }}</label>
      </div>
      <div class="profile-section">
        <label>Username: {{ user.username }}</label>
      </div>
      <div class="profile-section">
        <label>Email: {{ user.email }}</label>
      </div>
      <div class="profile-section">
        <label>Phone Number: {{ user.phone }}</label>
      </div>
      <button class="edit-btn" @click="enableEditing">Edit</button>
    </div>

    <!-- Edit Modal -->
    <Modal v-if="isEditing" @close="cancelEditing">
     
        <h3>Edit Profile</h3>
      
        <div>
          <label class="LABEL">Name:</label>
          <input class="INPUT" v-model="user.name" type="text" />

          <label  class="LABEL">Last Name:</label>
          <input class="INPUT" v-model="user.lastname" type="text" />

          <label  class="LABEL">Username:</label>
          <input class="INPUT" v-model="user.username" type="text" />

          <label  class="LABEL">Phone:</label>
          <input class="INPUT" v-model="user.phone" type="text" />
        </div>
      
      
        <button class="SC-btn" @click="updateProfile">Save</button>
        <button class="SC-btn" @click="cancelEditing">Cancel</button>
      
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


    <div v-if="currentSection === 'properties'" class="tab-content">
      <div class="my-properties">
        <h2>My Property Listings</h2>
        <hr>
        <div class="Prop-container">
            <div class="UsersProperties">
              <ul v-if="properties.length">
                <li v-for="property in properties" :key="property.id">
                  <h4>{{ property.title }}</h4>
                  <p>{{ property.description }}</p>
                  <!-- Add more details if needed -->
                </li>
                <div class="view-more">
                  <button>view more</button>
                </div>
              </ul>
              <p v-else>You have no property listings yet.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import '../assets/Profile.css';
</style>