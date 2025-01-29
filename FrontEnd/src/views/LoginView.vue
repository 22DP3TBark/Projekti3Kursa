<script setup >


</script>

<template>
  <div class="auth-container">
    <form class="auth-form">
      <h2>Login</h2>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password"required>
        </div>

      <button type="submit">Login</button>

      <p class="auth-link">
        Don't have an account? 
        <router-link to="/register">Register</router-link>
      </p>
    </form>
  </div>
</template>

<style scoped>
@import '../assets/Login.css';
</style>