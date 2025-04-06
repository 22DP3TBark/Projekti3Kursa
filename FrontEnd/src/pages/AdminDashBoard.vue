<script setup>
import { ref, onMounted, computed } from 'vue';
import adminService from '@/services/adminService'; // Adjust the path to your adminService.js
import { useAuth } from "../stores/useAuth";
import PropertyTableAdmin from '@/components/PropertyTableAdmin.vue';
import Modal from '@/components/Model.vue'; // Import the Modal component

const {user} = useAuth();

// Reactive state
const users = ref([]);
const selectedUser = ref(null);
const filteredUsers = ref([]);
const loading = ref(false);
const error = ref(null);
const showUsersTable = ref(false); // Define showUsersTable
const showPropertiesTable = ref(false); // Define showPropertiesTable
const propertySearchQuery = ref(""); // Add a reactive property for the search query

// Fetch all users when the component mounts
const fetchUsers = async () => {
  loading.value = true;
  error.value = null;
  try {
    users.value = await adminService.getAllUsers();
    filteredUsers.value = users.value; // Initialize filteredUsers with all users
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

// Toggle the visibility of the users table
const toggleUsersTable = () => {
  showUsersTable.value = !showUsersTable.value;
  showPropertiesTable.value = false;
};

const togglePropertiesTable = () => {
  showPropertiesTable.value = !showPropertiesTable.value;
  showUsersTable.value = false; // Hide Users Table when Properties Table is shown
};

// Fetch users on component mount
onMounted(fetchUsers);


const emit = defineEmits(['search']);

const search = (e) =>{
  emit('search', e.target.value)
};

const handlesearch = (query) => {
  const lowerCaseQuery = query.toLowerCase();
  filteredUsers.value = users.value.filter(user => 
    Object.values(user).some((value) =>
      String(value).toLowerCase().includes(lowerCaseQuery)
    )
  );
};
</script>

<template>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span>🚀</span>
                <span>Admin Dashboard</span>
            </div>
            <nav>
                <a href="#" class="nav-item active">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" @click.prevent="toggleUsersTable">
                    <span>👥</span>
                    <span>Users</span>
                </a>
                <a href="#" class="nav-item" @click.prevent="togglePropertiesTable">
                    <span>📝</span>
                    <span>Properties</span>
                </a>
                <a href="#" class="nav-item">
                    <span>⚙️</span>
                    <span>Settings</span>
                </a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1 class="header-title">Admin Dashboard</h1>
                <div class="user-profile">
                    <span>{{ user.name }}</span>
                    <div class="user-avatar">JD</div>
                </div>
            </header>
            <section>
              
                <div v-if="showUsersTable">
                  <div class="search">
                    <input type="text" @input="handlesearch($event.target.value)" placeholder="Search..." class="search-input" />
                    <button class="search-btn" disabled>Search</button>
                  </div>
                    <h2>Users Table</h2>
                    <!-- Users Table -->
                    <table v-if="!loading && !error" class="user-table">
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
                        <tr v-for="user in filteredUsers" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.lastname }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            <button @click="selectUser(user)" class="action-btn edit">Edit</button>
                            <button @click="deleteUser(user.id)" class="action-btn delete">Delete</button>
                        </td>
                        </tr>
                    </tbody>
                </table>

            
                <!-- Edit User Form -->
                <Modal v-if="selectedUser" :close="() => selectedUser = null">
                  
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
                          <input v-model="selectedUser.phone" id="phonenumber" type="text" required />
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
                        <button type="button" @click="selectedUser = null" class="btn btn-cancel">Cancel</button>
                      </form>
                    
                </Modal>


                </div>
                <!-- Properties-->
                <div v-if="showPropertiesTable">
                  <div class="search">
                    <input
                      type="text"
                      v-model="propertySearchQuery"
                      placeholder="Search properties..."
                      class="search-input"
                    />
                    <button class="search-btn" disabled>Search</button>
                  </div>
                    <PropertyTableAdmin :searchQuery="propertySearchQuery" />  
                </div>
                <div v-else>
                    <p>Welcome to the Admin Dashboard. Select an option from the sidebar.</p>
                </div>
            </section>
        </main>
    </div>
</template>

<style style>
@import '../assets/AdminDashboard.css';
</style>