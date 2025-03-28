<script setup>

</script>

<template>
 <header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <router-link to="/home" class="navbar-brand">SkyLine</router-link>

    <!-- Hamburger Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Listings Section moved to the left -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <router-link to="/list" class="nav-link">Listings</router-link>
        </li>

        <li class="nav-item dropdown">
          
          <ul class="dropdown-menu " aria-labelledby="moreDropdown">
            <li v-if="isAuthenticated"><router-link to="/userprop" class="dropdown-item">Property</router-link></li>
            <li v-if="isAuthenticated"><router-link to="/propertylist" class="dropdown-item">NK</router-link></li>
            <li v-if="isAdmin"><router-link to="/admindash" class="dropdown-item">Dashboard</router-link></li>
            <li v-if="isAdmin"><router-link to="/admin" class="dropdown-item">Admin Dashboard</router-link></li>
          </ul>
        </li>
      </ul>

      <!-- Login/Register Section moved to the right -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <router-link to="/login" class="nav-link" v-if="!isAuthenticated">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/register" class="nav-link" v-if="!isAuthenticated">Register</router-link>
        </li>

        <li class="nav-item" v-if="isAuthenticated">
          <router-link to="/profile" class="nav-link">Welcome, {{ user?.name }}</router-link>
        </li>

        <li class="nav-item" v-if="isAuthenticated">
          <button @click="logout" class="btn btn-danger btn-sm">Logout</button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="vh-100 w-100 vh-100" 
     style="height: 100%; 
            background-image: url('https://www.tennessean.com/gcdn/presto/2019/10/11/PNAS/adf1101a-0f8c-404f-9df3-5837bf387dfd-1_Exterior_House_Beautiful_Whole_Home_Concept_House_Castle_Homes_Photo_Reed_Brown_Photography.jpg?crop=5619,3161,x0,y104&width=3200&height=1801&format=pjpg&auto=webp');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
</div>

<div class="mask" style="background-color: hsla(0, 0%, 0%, 0.6)">
    <div class="container d-flex flex-column justify-content-between min-vh-100 pt-5">
      <div class="container d-flex justify-content-center align-items-center h-50 pt-5  ">
        <div class="text-white text-center">
          <h1 class="mb-4  h1 fw-bold">Unleash the Power of the Audi RS6 Avant!</h1>
          <h5 class="mb-10">A fusion of raw performance and everyday practicality—experience the thrill of a 600HP twin-turbo V8, quattro® all-wheel drive, and a design that turns heads</h5>
        </div>
    </div>
    <div class="container pb-5">
      <div class="row text-white align-items-center  pt-6">
        <div class="col-md-4 d-flex justify-content-center">
          <h6>🚀 0-60 in just 3.3 seconds</h6>
          
        </div>
    
        <div class="col-md-4 d-flex justify-content-center">
          <h6>🎯 Precision engineering meets luxury</h6>
        </div>
        <div class="col-md-4 d-flex justify-content-center">
          <h6>🔊 Sport exhaust for an exhilarating soundtrack</h6>
        </div>
      </div>
       
      </div>
    
      <div class="row text-white text-center mt-4 mb-5">
        <div class="col-md-6 offset-md-3">
          <p>Limited availability—secure yours today!</p>
          <button type="button" class="btn bg-black text-white fw-bold" data-mdb-ripple-init>Book a Test Drive</button>
          <button type="button" class="btn bg-white text-black fw-bold" data-mdb-ripple-init>Get Exclusive Offers</button>
        </div>
      </div>
    </div>
  </div>
  
 </header>
 <main></main>
 <footer></footer>
</template>

<style>

</style>