<script setup>
import { ref } from "vue";

const currentStep = ref(1);
const totalSteps = 3;

// Form data
const userType = ref({ value: "" }); // Changed to an object with a value property
const basicInfo = ref({
  title: "",
  price: "",
  address: "",
  city: "",
});
const additionalInfo = ref({
  bedrooms: "",
  bathrooms: "",
  amenities: [],
});

// Navigation methods
const nextStep = () => {
  if (currentStep.value < totalSteps) currentStep.value++;
};

const prevStep = () => {
  if (currentStep.value > 1) currentStep.value--;
};

const submitForm = () => {
  console.log("Form submitted:", { userType: userType.value, basicInfo, additionalInfo });
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

    <!-- Step 1: User Type -->
    <div v-if="currentStep === 1" class="step">
      <h2>Who are you?</h2>
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
      <div class="navigation-buttons">
        <button @click="nextStep" :disabled="!userType.value" class="next-button">
          Next
        </button>
      </div>
    </div>

    <!-- Step 2: Basic Information -->
    <div v-if="currentStep === 2" class="step">
      <h2>Basic Information</h2>
      <div class="form-group">
        <label>Title</label>
        <input v-model="basicInfo.title" type="text" placeholder="Listing Title" />
      </div>
      <div class="form-group">
        <label>Price</label>
        <input v-model="basicInfo.price" type="number" placeholder="Price" />
      </div>
      <div class="form-group">
        <label>Address</label>
        <input v-model="basicInfo.address" type="text" placeholder="Address" />
      </div>
      <div class="form-group">
        <label>City</label>
        <input v-model="basicInfo.city" type="text" placeholder="City" />
      </div>
      <div class="navigation-buttons">
        <button @click="prevStep" class="back-button">Back</button>
        <button
          @click="nextStep"
          :disabled="!basicInfo.title || !basicInfo.price || !basicInfo.address || !basicInfo.city"
          class="next-button"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Step 3: Additional Information -->
    <div v-if="currentStep === 3" class="step">
      <h2>Additional Information</h2>
      <div class="form-group">
        <label>Bedrooms</label>
        <input v-model="additionalInfo.bedrooms" type="number" placeholder="Number of Bedrooms" />
      </div>
      <div class="form-group">
        <label>Bathrooms</label>
        <input v-model="additionalInfo.bathrooms" type="number" placeholder="Number of Bathrooms" />
      </div>
      <div class="form-group">
        <label>Amenities</label>
        <div class="checkbox-group">
          <label><input type="checkbox" value="Balcony" v-model="additionalInfo.amenities" /> Balcony</label>
          <label><input type="checkbox" value="Garage" v-model="additionalInfo.amenities" /> Garage</label>
          <label><input type="checkbox" value="Swimming Pool" v-model="additionalInfo.amenities" /> Swimming Pool</label>
        </div>
      </div>
      <div class="navigation-buttons">
        <button @click="prevStep" class="back-button">Back</button>
        <button @click="submitForm" class="submit-button">Submit</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Center form in full page */
body, html {
  height: 100%;
  margin: 0;
}

.submission-container {
  max-width: 600px;
  width: 90%;
  margin: auto;
  padding: 2rem;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 100vh;
}

/* Progress Indicator */
.progress-indicator {
  display: flex;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.progress-step {
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: #ddd;
  color: #fff;
  font-weight: bold;
  transition: background 0.3s ease;
}

.progress-step.active {
  background: #007bff;
}

/* Headings */
.step h2 {
  margin-bottom: 1.5rem;
  font-size: 1.75rem;
  color: #333;
  text-align: center;
}

/* Form Fields */
.form-group {
  margin-bottom: 1.25rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #444;
}

.form-group input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
}

/* Checkboxes */
.checkbox-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #555;
}

/* Navigation */
.navigation-buttons {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
  margin-top: 1.5rem;
}

button {
  padding: 0.75rem 1.25rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s ease;
}

.next-button {
  background: #007bff;
  color: #fff;
}

.back-button {
  background: #ccc;
  color: #333;
}

.submit-button {
  background: #28a745;
  color: #fff;
}

button:disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
}

/* User Type Buttons */
.user-type-options {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.option-button {
  padding: 1rem 1.5rem;
  border: 2px solid #ccc;
  border-radius: 10px;
  background: #fff;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.option-button.selected {
  background: #007bff;
  color: #fff;
  border-color: #007bff;
}

.option-button:hover {
  border-color: #007bff;
}
</style>
