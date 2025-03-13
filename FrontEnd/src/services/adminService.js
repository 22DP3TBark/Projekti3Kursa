import axiosClient from "../../axiosClient";

const adminService = {
    // Get all users
  async getAllUsers() {
    try {
      const response = await axiosClient.get('/users');
      return response.data;
    } catch (error) {
      console.error('Error fetching all users:', error.response?.data || error.message);
      throw error;
    }
  },
  // Get a single user by ID
  async getUser(id) {
    try {
      const response = await axiosClient.get(`/users/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching user ${id}:`, error.response?.data || error.message);
      throw error;
    }
  },

  // Update a user
  async updateUser(id, userData) {
    try {
      const response = await axiosClient.put(`/users/${id}`, userData);
      return response.data;
    } catch (error) {
      console.error(`Error updating user ${id}:`, error.response?.data || error.message);
      throw error;
    }
  },

  // Delete a user
  async deleteUser(id) {
    try {
      const response = await axiosClient.delete(`/users/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error deleting user ${id}:`, error.response?.data || error.message);
      throw error;
    }
  },
};

export default adminService;