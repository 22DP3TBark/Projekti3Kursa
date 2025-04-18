<script setup>
import { ref } from 'vue'
import axiosClient from '../../axiosClient'

// Define reactive properties
const email = ref('')
const successMessage = ref('')
const errorMessage = ref('')

// Submit email function
const submitEmail = async () => {
  successMessage.value = ''
  errorMessage.value = ''

  try {
    const response = await axiosClient.post('/forgot-password', {
      email: email.value
    })
    console.log('Response:', response.data)
    successMessage.value = response.data.message
  } catch (error) {
    console.error('Error:', error.response?.data || error.message)
    if (error.response?.data?.errors) {
      // Display validation errors
      errorMessage.value = Object.values(error.response.data.errors).flat().join(', ')
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message
    } else {
      errorMessage.value = 'Something went wrong. Please try again.'
    }
  }
}
</script>

<template>
  <div class="forgot-password-container">
    <h2>Forgot Your Password?</h2>

    <form @submit.prevent="submitEmail">
      <div class="form-group">
        <label for="email">Enter your email address:</label>
        <input v-model="email" type="email" id="email" required />
      </div>

      <button type="submit">Send Reset Link</button>
    </form>

    <p v-if="successMessage" class="success">{{ successMessage }}</p>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div>
</template>

<style scoped>
.forgot-password-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 2rem;
}
.form-group {
  margin-bottom: 1rem;
}
input {
  width: 100%;
  padding: 0.5rem;
}
button {
  padding: 0.5rem 1rem;
}
.success {
  color: green;
}
.error {
  color: red;
}
</style>