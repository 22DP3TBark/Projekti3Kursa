<script setup>
import { ref } from "vue";

const currentStep = ref(1);
const totalSteps = 5;

const userType = ref({ value: "" });

const basicInfo = ref({
  title: "",
  description: "",
  purpose: "",
  propertyType: "",
});

const location = ref({
  address: "",
  city: "",
  district: "",
  zipCode: "",
  country: "Latvia",
  latitude: "",
  longitude: "",
});

const details = ref({
  bedrooms: "",
  bathrooms: "",
  size: "",
  floor: "",
  buildingType: "",
  yearBuilt: "",
  parkingSpaces: "",
});

const features = ref({
  amenities: [],
  mainImage: null,
  gallery: [],
});

const pricing = ref({
  price: "",
  currency: "EUR",
  status: "",
});

const nextStep = () => {
  if (currentStep.value < totalSteps) currentStep.value++;
};

const prevStep = () => {
  if (currentStep.value > 1) currentStep.value--;
};

const handleMainImageUpload = (e) => {
  features.value.mainImage = e.target.files[0];
};

const handleGalleryUpload = (e) => {
  features.value.gallery = Array.from(e.target.files);
};

const submitForm = () => {
  console.log("Submitted data:", {
    userType: userType.value,
    basicInfo: basicInfo.value,
    location: location.value,
    details: details.value,
    features: features.value,
    pricing: pricing.value,
  });
};
</script>

<template>
  <div class="submission-container">
    <!-- Progress Indicator -->
    <div class="progress-indicator">
      <div
        v-for="step in totalSteps"
        :key="step"
        :class="{ active: step === currentStep }"
        class="progress-step"
      >
        {{ step }}
      </div>
    </div>

    <!-- Step Content -->
    <div v-if="currentStep === 1" class="step">
      <h2>Step 1: Basic Info</h2>
      <div class="form-group">
        <label>Who are you?</label>
        <div class="user-type-options">
          <button
            class="option-button"
            :class="{ selected: userType.value === 'Real Estate Company' }"
            @click="userType.value = 'Real Estate Company'"
          >
            Real Estate Company
          </button>
          <button
            class="option-button"
            :class="{ selected: userType.value === 'Private Citizen' }"
            @click="userType.value = 'Private Citizen'"
          >
            Private Citizen
          </button>
        </div>
      </div>

      <div class="form-group">
        <label>Title</label>
        <input v-model="basicInfo.title" type="text" placeholder="Listing Title" />
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea v-model="basicInfo.description" placeholder="Property Description"></textarea>
      </div>
      <div class="form-group">
        <label>Purpose</label>
        <select v-model="basicInfo.purpose">
          <option disabled value="">Select purpose</option>
          <option>Sell</option>
          <option>Rent</option>
        </select>
      </div>
      <div class="form-group">
        <label>Property Type</label>
        <input v-model="basicInfo.propertyType" type="text" placeholder="e.g. Dzīvoklis, Māja" />
      </div>

      <div class="navigation-buttons">
        <button @click="nextStep" :disabled="!userType.value || !basicInfo.title || !basicInfo.description || !basicInfo.purpose || !basicInfo.propertyType">
          Next
        </button>
      </div>
    </div>

    <div v-if="currentStep === 2" class="step">
      <h2>Step 2: Location</h2>
      <div class="form-grid">
        <div class="form-group"><label>Address</label><input v-model="location.address" type="text" /></div>
        <div class="form-group"><label>City</label><input v-model="location.city" type="text" /></div>
        <div class="form-group"><label>District</label><input v-model="location.district" type="text" /></div>
        <div class="form-group"><label>ZIP Code</label><input v-model="location.zipCode" type="text" /></div>
        <div class="form-group"><label>Country</label><input v-model="location.country" type="text" disabled /></div>
        <div class="form-group"><label>Latitude</label><input v-model="location.latitude" type="text" /></div>
        <div class="form-group"><label>Longitude</label><input v-model="location.longitude" type="text" /></div>
      </div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="nextStep">Next</button>
      </div>
    </div>

    <div v-if="currentStep === 3" class="step">
      <h2>Step 3: Property Details</h2>
      <div class="form-grid">
        <div class="form-group"><label>Bedrooms</label><input v-model="details.bedrooms" type="number" /></div>
        <div class="form-group"><label>Bathrooms</label><input v-model="details.bathrooms" type="number" /></div>
        <div class="form-group"><label>Size (m²)</label><input v-model="details.size" type="number" /></div>
        <div class="form-group"><label>Floor</label><input v-model="details.floor" type="number" /></div>
        <div class="form-group"><label>Building Type</label><input v-model="details.buildingType" type="text" /></div>
        <div class="form-group"><label>Year Built</label><input v-model="details.yearBuilt" type="number" /></div>
        <div class="form-group"><label>Parking Spaces</label><input v-model="details.parkingSpaces" type="number" /></div>
      </div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="nextStep">Next</button>
      </div>
    </div>

    <div v-if="currentStep === 4" class="step">
      <h2>Step 4: Features & Images</h2>
      <div class="form-group">
        <label>Amenities</label>
        <div class="checkbox-group">
          <label><input type="checkbox" value="Balcony" v-model="features.amenities" /> Balcony</label>
          <label><input type="checkbox" value="Garage" v-model="features.amenities" /> Garage</label>
          <label><input type="checkbox" value="Swimming Pool" v-model="features.amenities" /> Swimming Pool</label>
          <label><input type="checkbox" value="Garden" v-model="features.amenities" /> Garden</label>
          <label><input type="checkbox" value="Furnished" v-model="features.amenities" /> Furnished</label>
        </div>
      </div>
      <div class="form-group"><label>Main Image</label><input type="file" accept="image/*" @change="handleMainImageUpload" /></div>
      <div class="form-group"><label>Gallery Images</label><input type="file" accept="image/*" multiple @change="handleGalleryUpload" /></div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="nextStep">Next</button>
      </div>
    </div>

    <div v-if="currentStep === 5" class="step">
      <h2>Step 5: Price & Status</h2>
      <div class="form-group"><label>Price</label><input v-model="pricing.price" type="number" /></div>
      <div class="form-group"><label>Currency</label><input v-model="pricing.currency" type="text" disabled /></div>
      <div class="form-group">
        <label>Status</label>
        <select v-model="pricing.status">
          <option disabled value="">Select status</option>
          <option>Available</option>
          <option>Sold</option>
          <option>Rented</option>
        </select>
      </div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="submitForm">Submit</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
body, html {
  height: 100%;
  margin: 0;
}

.submission-container {
  max-width: 1100px;
  margin: 40px auto;
  padding: 40px;
  background-color: #ffffff;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
  font-family: 'Inter', sans-serif;
  min-height: 90vh;
  display: flex;
  flex-direction: column;
}

.progress-indicator {
  display: flex;
  justify-content: center;
  margin-bottom: 36px;
  gap: 14px;
}

.progress-step {
  width: 40px;
  height: 40px;
  background-color: #e5e7eb;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: 600;
  color: #6b7280;
  transition: all 0.2s;
}

.progress-step.active {
  background-color: #3b82f6;
  color: #fff;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
}

.step h2 {
  font-size: 1.75rem;
  font-weight: 600;
  margin-bottom: 24px;
  color: #111827;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
  flex: 1;
}

.form-group label {
  margin-bottom: 8px;
  color: #374151;
  font-weight: 500;
}

input,
select,
textarea {
  padding: 14px 16px;
  font-size: 1.05rem;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  background-color: #f9fafb;
  transition: border-color 0.3s ease;
}

input:focus,
select:focus,
textarea:focus {
  border-color: #3b82f6;
  outline: none;
  background-color: #ffffff;
}

.checkbox-group {
  display: flex;
  flex-wrap: wrap;
  gap: 10px 20px;
}

.user-type-options {
  display: flex;
  gap: 12px;
  margin-top: 8px;
}

.option-button {
  padding: 10px 18px;
  background-color: #f3f4f6;
  border: 1px solid #d1d5db;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 500;
  color: #374151;
  transition: all 0.2s ease-in-out;
}

.option-button:hover {
  background-color: #e5e7eb;
}

.option-button.selected {
  background-color: #3b82f6;
  color: #ffffff;
  border-color: #3b82f6;
}

.navigation-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
}

.navigation-buttons button {
  padding: 14px 26px;
  background-color: #3b82f6;
  color: #fff;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.2s ease;
  font-size: 1rem;
}

.navigation-buttons button:hover {
  background-color: #2563eb;
}

.navigation-buttons button:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}

.form-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
</style>
