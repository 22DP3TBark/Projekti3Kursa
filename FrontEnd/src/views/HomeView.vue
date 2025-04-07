<script setup>
import { ref, onMounted } from 'vue';
import axiosClient from '../../axiosClient';
import { useRouter } from 'vue-router';

const properties = ref([]);
const searchQuery = ref('');
const router = useRouter();

const fetchProperties = async () => {
  try {
    const response = await axiosClient.get('/properties');
    properties.value = response.data.properties; // Ensure this matches API response
    console.log("Fetched properties:", properties.value); // Debugging
  } catch (error) {
    console.error("Error fetching properties:", error);
  }
};
// This runs when user clicks "Search" on homepage
const handleSearch = () => {
  if (searchQuery.value.trim()) {
    router.push({ name: 'Listings', query: { q: searchQuery.value } });
  }
};



onMounted(fetchProperties);

</script>

<template>
    <div className="hero">
        <img
          src="https://www.tennessean.com/gcdn/presto/2019/10/11/PNAS/adf1101a-0f8c-404f-9df3-5837bf387dfd-1_Exterior_House_Beautiful_Whole_Home_Concept_House_Castle_Homes_Photo_Reed_Brown_Photography.jpg?crop=5619,3161,x0,y104&width=3200&height=1801&format=pjpg&auto=webp"
          alt="Luxury home"
          className="hero-image"
        />
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <h1>Atrodi savu sapņu māju</h1>
          <p>
            Atrodi perfekto īpašumu no  mūsu eksluzīvās kolekcijas un labākajām vietām
          </p>
          <div class="search-box">
            <div class="search-form">
              <div class="search-input">
                <input v-model="searchQuery"  @keyup.enter="handleSearch" type="text" placeholder="🔍 Search properties by location, type, or keyword..." />
              </div>
             
              <button @click="handleSearch"  class="button type1">
                <span class="btn-txt">Search</span>
            </button>
            </div>
          </div>
        </div>
      </div>

      <main>
        <section class=" property-section">
          <h2 class="section-title">Featured Property</h2>
          <div class="property-container">
            <div 
              class="property-card" 
              v-for="(property, index) in properties.slice(0, 3)" 
              :key="index"
            >
              <img :src="property.image" alt="Property Image" />
              <div class="property-info">
                <h3>{{ property.title }}</h3>
                <p class="price">{{ property.price }}</p>
                <p class="location">{{ property.location }}</p>
                <button class="view-details">View Details</button>
              </div>
            </div>
          </div>
        </section>
        <section class="why-choose-section">
    <h2 class="section-title">Why Choose Us?</h2>
    <div class="choose-container">
      
      <!-- Feature 1 -->
      <div class="choose-card">
        <i class="fas fa-check-circle"></i>
        <h3>Verified Listings</h3>
        <p>All properties are verified for authenticity, ensuring a safe experience.</p>
      </div>

      <!-- Feature 2 -->
      <div class="choose-card">
        <i class="fas fa-dollar-sign"></i>
        <h3>Affordable Prices</h3>
        <p>We offer the best property deals tailored to your budget.</p>
      </div>

      <!-- Feature 3 -->
      <div class="choose-card">
        <i class="fas fa-headset"></i>
        <h3>24/7 Support</h3>
        <p>Our team is always ready to assist you at any time.</p>
      </div>

    </div>
  </section>  

  <section class="how-it-works">
    <h2 class="section-title">How It Works</h2>
    <div class="steps-container">
      
      <!-- Step 1 -->
      <div class="step-card">
        <i class="fas fa-search"></i>
        <h3>Search Properties</h3>
        <p>Find your dream home by searching through our verified listings.</p>
      </div>

      <!-- Step 2 -->
      <div class="step-card">
        <i class="fas fa-phone-alt"></i>
        <h3>Contact Seller</h3>
        <p>Reach out to the property owner or agent directly for more details.</p>
      </div>

      <!-- Step 3 -->
      <div class="step-card">
        <i class="fas fa-calendar-check"></i>
        <h3>Schedule a Visit</h3>
        <p>Arrange a property viewing to check if it meets your expectations.</p>
      </div>

      <!-- Step 4 -->
      <div class="step-card">
        <i class="fas fa-handshake"></i>
        <h3>Make a Deal</h3>
        <p>Negotiate, finalize, and move into your new home with ease.</p>
      </div>

    </div>
  </section>
    <footer class="footer">
      <div class="col-1">
        <h3>Useful Links</h3>
        <a href="#">Home</a>
        <a href="#">About Us</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        <a href="#">FAQ</a>
      </div>
      <div class="col-2">
        <h3>Newsletter</h3>
          <form action="">
            <input type="text" placeholder="Enter your email">
            <button type="submit">Subscribe</button>
          </form>
      </div>
      <div class="col-3">
          <h3>Contacts</h3>
          <p>
            Address: 123 Main Street<br />
            Phone: +1 234 567 890<br />
            Email: info@example.com
          </p>
      </div>
      
    </footer>
      </main>
    
 
    
</template>

<style scoped>
@import '../assets/HomeView.css';
</style>