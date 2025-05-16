<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import axiosClient from '../../axiosClient';
import PropertyMap from '../components/PropertyMap.vue';
import MortgageCalculator from '@/components/MoregageCalc.vue';

const route = useRoute();
const property = ref(null);
const errorMessage = ref(null);
const activeTab = ref('property'); // controls which tab is active

const selectedImage = ref(null); // For main image and modal
const showModal = ref(false);

const fetchProperty = async () => {
  try {
    const response = await axiosClient.get(`/properties/${route.params.id}`);
    property.value = response.data.property;
    selectedImage.value = property.value?.main_image || '/assets/placeholder.jpg';
  } catch (error) {
    console.error("Error fetching property:", error);
    errorMessage.value = "Could not load property details.";
  }
};

onMounted(fetchProperty);

// Helper to safely get gallery images as array
const galleryImages = () => {
  if (!property.value) return [];
  // If already array, return as is
  if (Array.isArray(property.value.gallery)) return property.value.gallery;
  // If it's a JSON string, try to parse
  if (typeof property.value.gallery === 'string') {
    try {
      const arr = JSON.parse(property.value.gallery);
      return Array.isArray(arr) ? arr : [];
    } catch {
      return [];
    }
  }
  return [];
};

// When property changes, update selectedImage
watch(
  () => property.value,
  (val) => {
    if (val) selectedImage.value = val.main_image || '/assets/placeholder.jpg';
  }
);
</script>

<template>
  <!-- 🔹 Top Tab Navigation -->
  <nav class="property-tabs">
    <button :class="{ active: activeTab === 'property' }" @click="activeTab = 'property'">Property</button>
    <button :class="{ active: activeTab === 'map' }" @click="activeTab = 'map'">Map</button>
    <button :class="{ active: activeTab === 'calculator' }" @click="activeTab = 'calculator'">Calculator</button>
  </nav>

  <!-- 🔹 Main Content -->
  <main class="property-details-container" v-if="property">
    <!-- Property Tab Content -->
    <div v-if="activeTab === 'property'" class="main-content property-flex">
      <!-- Left Side - Image -->
      <div class="image-gallery">
        <img
          :src="selectedImage"
          alt="Main Property"
          class="main-image"
          @click="showModal = true"
          style="cursor: zoom-in;"
        />
        <!-- Thumbnails Section -->
        <div class="thumbnails">
          <img
            v-for="(image, index) in galleryImages().slice(0, 4)"
            :key="index"
            :src="image || '/assets/placeholder.jpg'"
            alt="Property Thumbnail"
            class="thumbnail"
            :class="{ active: selectedImage === image }"
            @click="selectedImage = image"
            style="cursor: pointer;"
          />
        </div>
      </div>

      <!-- Modal for image preview -->
      <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
        <span class="modal-close" @click="showModal = false">&times;</span>
        <img :src="selectedImage" alt="Large Property" class="modal-image" />
      </div>

      <!-- Right Side - Info -->
      <div class="info-card">
        <h1>{{ property.title }}</h1>
        <p class="address">{{ property.address }}</p>
        <p class="price">${{ property.price.toLocaleString() }}</p>

        <div class="basic-info">
          <span><i class="fas fa-bed"></i> {{ property.bedrooms }} beds</span>
          <span><i class="fas fa-bath"></i> {{ property.bathrooms }} baths</span>
          <span><i class="fas fa-ruler-combined"></i> {{ property.size }} sq. ft.</span>
        </div>

        <section class="section">
          <h3>Description</h3>
          <p>{{ property.description }}</p>
        </section>

        <section class="section">
          <h3>Closer Location</h3>
          <ul>
            <li><i class="fas fa-map-marker-alt"></i> Park - 0.5 miles</li>
            <li><i class="fas fa-map-marker-alt"></i> View Point - 1.5 miles</li>
            <li><i class="fas fa-map-marker-alt"></i> School - 2.5 miles</li>
          </ul>
        </section>

        <section class="section">
          <h3>Key Features</h3>
          <ul>
            <li>Available cooling</li>
            <li>Detached garage</li>
            <li>Picnic area</li>
            <li>Sauna</li>
            <li>Swimming pool</li>
            <li>Dishwasher</li>
            <li>Cable TV ready</li>
          </ul>
        </section>
      </div>
    </div>

    <!-- Map Tab Content -->
    <div v-else-if="activeTab === 'map'" class="tab-content">
      <PropertyMap/>
    </div>

    <!-- Calculator Tab Content -->
    <div v-else-if="activeTab === 'calculator'" class="tab-content">
      <MortgageCalculator />
    </div>
  </main>

  <div v-else class="loading">Loading property...</div>
</template>

<style scoped>
@import '../assets/listings/PropertyPage.css';

/* Add flex layout for property details */
.property-flex {
  display: flex;
  gap: 48px;
  align-items: flex-start;
  justify-content: flex-start;
}

/* Move image gallery to the absolute left, info to the right */
.image-gallery {
  flex: 0 0 540px;
  max-width: 540px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  background: #fff;
  border-radius: 10px;
  border: 1.5px solid #e0e0e0;
  padding: 18px 14px 14px 14px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);

}

/* Make main image even wider and more visible and sharper */
.main-image {
  width: 510px;
  height: 320px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.18);
  background: #fff;
  border: 2.5px solid #007bff;
  margin-bottom: 14px;
  transition: box-shadow 0.2s, border 0.2s;
  image-rendering: crisp-edges;
  filter: contrast(1.08) brightness(1.08) saturate(1.08) drop-shadow(0 2px 8px rgba(0,0,0,0.10));
}
.main-image:hover {
  box-shadow: 0 8px 32px rgba(0,0,0,0.22);
  border: 2.5px solid #0056b3;
}

/* Thumbnails */
.thumbnails {
  display: flex;
  gap: 14px;
  margin-top: 0;
}
.thumbnail {
  width: 120px;
  height: 80px;
  object-fit: cover;
  border-radius: 4px;
  border: 2px solid transparent;
  background: #f0f0f0;
  transition: border 0.2s, box-shadow 0.2s;
  image-rendering: crisp-edges;
  filter: contrast(1.08) brightness(1.08) saturate(1.08);
}
.thumbnail.active,
.thumbnail:hover {
  border: 2.5px solid #007bff;
  box-shadow: 0 2px 8px rgba(0,123,255,0.10);
}

/* Info card stays on the right, give it more space and a max width */
.info-card {
  flex: 1 1 0;
  min-width: 340px;
  max-width: 600px;
  background: #fff;
  border-radius: 10px;
  border: 1.5px solid #e0e0e0;
  padding: 24px 28px 24px 28px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
  margin-left: 0;
  word-break: break-word;
}

/* Modal styles */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-image {
  max-width: 90vw;
  max-height: 80vh;
  border-radius: 8px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.3);
  image-rendering: crisp-edges;
  filter: contrast(1.08) brightness(1.08) saturate(1.08);
}
.modal-close {
  position: absolute;
  top: 30px;
  right: 40px;
  font-size: 2.5rem;
  color: #fff;
  cursor: pointer;
  z-index: 1001;
  user-select: none;
}

.tab-content {
  width: 100%;
  height: 600px;
}

.map-placeholder {
  text-align: center;
  padding: 40px;
  color: #6b7280;
  font-size: 18px;
}
</style>