<script setup>

</script>

<template>
    <div class="auth-container">
      <form  class="auth-form">
        <h2>Register</h2>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" required>
          </div>
  
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" required>
          </div>
    
          <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" required>
          </div>
  
        <button type="submit">Register</button>
  
          <p class="auth-link">
          Already have an account? 
          <router-link to="/login">Login</router-link>
        </p>
      </form>
    </div>
  </template>
  
<style scoped>
  @import '../assets/Register.css';
</style>