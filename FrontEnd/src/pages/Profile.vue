<script setup>
import { useAuth } from "@/stores/useAuth";
import { ref, onMounted } from "vue";
import axiosClient from "../../axiosClient";

const { user } = useAuth();
const isEditing = ref(false);

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
    await axiosClient.put('/profile/update', {
      name: user.value.name,
      lastname: user.value.lastname,
      username: user.value.username,
      phone: user.value.phone
    });

    isEditing.value = false;
    alert("Profile updated successfully!");
  } catch (error) {
    console.error("Error updating profile:", error);
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

// Fetch user profile when the component is mounted
onMounted(() => {
  fetchUserProfile();
});
</script>

<template>
<div class="profile-container">
    <!-- Tabs Navigation -->
    <div class="tabs">
      <button class="tab-button">Profile</button>
      <button class="tab-button">Security</button>
    </div>

    <!-- Profile Tab -->
    <div v-if="!isEditing" class="tab-content">
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
    <div class="Else-CL" v-else>
      <label>Name:</label>
      <input v-model="user.name" type="text" />

      <label>Last Name:</label>
      <input v-model="user.lastname" type="text" />

      <label>Username:</label>
      <input v-model="user.username" type="text" />

      <label>Phone:</label>
      <input v-model="user.phone" type="text" />

      <button class="SC-btn" @click="updateProfile">Save</button>
      <button class="SC-btn" @click="cancelEditing">Cancel</button>
    </div>

    <!-- Security Tab -->
    <div class="tab-content">
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
  </div>
</template>

<style scoped>
@import '../assets/Profile.css';
</style>