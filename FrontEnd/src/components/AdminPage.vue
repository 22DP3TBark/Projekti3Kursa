<script setup>
import { ref, onMounted } from 'vue';
import adminService from '@/services/adminService'; // Adjust the path to your adminService.js

// Reactive state
const users = ref([]);
const selectedUser = ref(null);
const loading = ref(false);
const error = ref(null);

// Fetch all users when the component mounts
const fetchUsers = async () => {
  loading.value = true;
  error.value = null;
  try {
    users.value = await adminService.getAllUsers();
  } catch (err) {
    error.value = 'Failed to load users. Please try again.';
  } finally {
    loading.value = false;
  }
};

// Select a user for editing
const selectUser = (user) => {
  selectedUser.value = { ...user, password: '' }; // Clone user and add password field
};

// Update a user
const updateUser = async () => {
  if (!selectedUser.value) return;

  loading.value = true;
  error.value = null;
  try {
    const userData = {
      name: selectedUser.value.name,
      email: selectedUser.value.email,
      lastname: selectedUser.value.lastname,
      phone: selectedUser.value.phone,
      username: selectedUser.value.username,
    };
    if (selectedUser.value.password) {
      userData.password = selectedUser.value.password; // Only include password if provided
    }
    await adminService.updateUser(selectedUser.value.id, userData);
    await fetchUsers(); // Refresh the user list
    selectedUser.value = null; // Close the form
  } catch (err) {
    error.value = 'Failed to update user. Please try again.';
  } finally {
    loading.value = false;
  }
};

// Delete a user
const deleteUser = async (id) => {
  if (!confirm('Are you sure you want to delete this user?')) return;

  loading.value = true;
  error.value = null;
  try {
    await adminService.deleteUser(id);
    await fetchUsers(); // Refresh the user list
  } catch (err) {
    error.value = 'Failed to delete user. Please try again.';
  } finally {
    loading.value = false;
  }
};

// Fetch users on component mount
onMounted(fetchUsers);

</script>

<template>
  <div class="admin-page">
    <h1>Admin Dashboard</h1>

    <!-- Loading State -->
    <div v-if="loading" class="loading">Loading users...</div>

    <!-- Error State -->
    <div v-if="error" class="error">{{ error }}</div>

    <!-- Users Table -->
    <table v-if="!loading && !error" class="users-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Username</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.lastname }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ user.username }}</td>
          <td>{{ user.role }}</td>
          <td>
            <button @click="selectUser(user)" class="btn btn-edit">Edit</button>
            <button @click="deleteUser(user.id)" class="btn btn-delete">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Edit User Form -->
    <div v-if="selectedUser" class="edit-form">
      <h2>Edit User</h2>
      <form @submit.prevent="updateUser">
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="selectedUser.name" id="name" type="text" required />
        </div>
        <div class="form-group">
          <label for="lastname">Last Name:</label>
          <input v-model="selectedUser.lastname" id="lastname" type="text" required />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input v-model="selectedUser.email" id="email" type="email" required />
        </div>
        <div class="form-group">
          <label for="phonenumber">Phone Number:</label>
          <input v-model="selectedUser.phonenumber" id="phonenumber" type="text" required />
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input v-model="selectedUser.username" id="username" type="text" required />
        </div>
        <div class="form-group">
          <label for="password">Password (leave blank to keep unchanged):</label>
          <input v-model="selectedUser.password" id="password" type="password" />
        </div>
        <button type="submit" class="btn btn-save">Save</button>
        <button @click="selectedUser = null" class="btn btn-cancel">Cancel</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.admin-page {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.users-table th,
.users-table td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}

.users-table th {
  background-color: #f4f4f4;
}

.btn {
  padding: 5px 10px;
  margin-right: 5px;
  cursor: pointer;
  border-radius: 4px;
  border: none;
}

.btn-edit {
  background-color: #007bff;
  color: white;
}

.btn-delete {
  background-color: #dc3545;
  color: white;
}

.btn-save {
  background-color: #28a745;
  color: white;
}

.btn-cancel {
  background-color: #6c757d;
  color: white;
}

.edit-form {
  margin-top: 20px;
  padding: 20px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.error {
  color: red;
  margin-top: 10px;
}

.loading {
  color: #007bff;
  margin-top: 10px;
}
</style>