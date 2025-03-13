<script setup>
import { ref } from 'vue';

const formData = ref({
  title: '',
  price: '',
  bedrooms: 1,
  bathrooms: 1,
  squareFeet: '',
  address: '',
  city: '',
  state: '',
  zipCode: '',
  description: '',
  propertyType: 'house',
  amenities: []
});

const amenitiesList = [
  'Swimming Pool',
  'Garden',
  'Garage',
  'Air Conditioning',
  'Heating',
  'Balcony',
  'Fireplace',
  'Security System'
];

const formSubmitted = ref(false);
const formErrors = ref({});

const validateForm = () => {
  const errors = {};
  
  if (!formData.value.title.trim()) errors.title = 'Property title is required';
  if (!formData.value.price.trim()) errors.price = 'Price is required';
  else if (isNaN(formData.value.price) || Number(formData.value.price) <= 0) errors.price = 'Price must be a positive number';
  
  if (!formData.value.squareFeet.trim()) errors.squareFeet = 'Square feet is required';
  else if (isNaN(formData.value.squareFeet) || Number(formData.value.squareFeet) <= 0) errors.squareFeet = 'Square feet must be a positive number';
  
  if (!formData.value.address.trim()) errors.address = 'Address is required';
  if (!formData.value.city.trim()) errors.city = 'City is required';
  if (!formData.value.state.trim()) errors.state = 'State is required';
  if (!formData.value.zipCode.trim()) errors.zipCode = 'Zip code is required';
  
  formErrors.value = errors;
  return Object.keys(errors).length === 0;
};

const submitForm = () => {
  if (validateForm()) {
    console.log('Form submitted:', formData.value);
    formSubmitted.value = true;
  } else {
    console.log('Form has errors');
  }
};

const resetForm = () => {
  formData.value = {
    title: '',
    price: '',
    bedrooms: 1,
    bathrooms: 1,
    squareFeet: '',
    address: '',
    city: '',
    state: '',
    zipCode: '',
    description: '',
    propertyType: 'house',
    amenities: []
  };
  formSubmitted.value = false;
  formErrors.value = {};
};

const toggleAmenity = (amenity) => {
  const index = formData.value.amenities.indexOf(amenity);
  if (index === -1) {
    formData.value.amenities.push(amenity);
  } else {
    formData.value.amenities.splice(index, 1);
  }
};
</script>

<template>
    <div class="container">
  <div class="property-form-container">
    <h1>Property Submission Form</h1>
    
    <div v-if="formSubmitted" class="success-message">
      <h2>Thank You for Your Submission!</h2>
      <p>Your property has been successfully submitted.</p>
      <div class="property-summary">
        <h3>Property Summary</h3>
        <p><strong>Title:</strong> {{ formData.title }}</p>
        <p><strong>Price:</strong> ${{ formData.price }}</p>
        <p><strong>Type:</strong> {{ formData.propertyType }}</p>
        <p><strong>Size:</strong> {{ formData.squareFeet }} sq ft</p>
        <p><strong>Bedrooms:</strong> {{ formData.bedrooms }}</p>
        <p><strong>Bathrooms:</strong> {{ formData.bathrooms }}</p>
        <p><strong>Address:</strong> {{ formData.address }}, {{ formData.city }}, {{ formData.state }} {{ formData.zipCode }}</p>
        <p v-if="formData.amenities.length > 0"><strong>Amenities:</strong> {{ formData.amenities.join(', ') }}</p>
      </div>
      <button @click="resetForm" class="submit-button">Submit Another Property</button>
    </div>
    
    <form v-else @submit.prevent="submitForm" class="property-form">
      <div class="form-section">
        <h2>Basic Information</h2>
        
        <div class="form-group">
          <label for="title">Property Title*</label>
          <input 
            type="text" 
            id="title" 
            v-model="formData.title" 
            :class="{ 'error-input': formErrors.title }"
          >
          <span v-if="formErrors.title" class="error-message">{{ formErrors.title }}</span>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="price">Price ($)*</label>
            <input 
              type="text" 
              id="price" 
              v-model="formData.price" 
              :class="{ 'error-input': formErrors.price }"
            >
            <span v-if="formErrors.price" class="error-message">{{ formErrors.price }}</span>
          </div>
          
          <div class="form-group">
            <label for="propertyType">Property Type*</label>
            <select id="propertyType" v-model="formData.propertyType">
              <option value="house">House</option>
              <option value="apartment">Apartment</option>
              <option value="condo">Condo</option>
              <option value="townhouse">Townhouse</option>
              <option value="land">Land</option>
              <option value="commercial">Commercial</option>
            </select>
          </div>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <input type="number" id="bedrooms" v-model="formData.bedrooms" min="0">
          </div>
          
          <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms" v-model="formData.bathrooms" min="0" step="0.5">
          </div>
          
          <div class="form-group">
            <label for="squareFeet">Square Feet*</label>
            <input 
              type="text" 
              id="squareFeet" 
              v-model="formData.squareFeet" 
              :class="{ 'error-input': formErrors.squareFeet }"
            >
            <span v-if="formErrors.squareFeet" class="error-message">{{ formErrors.squareFeet }}</span>
          </div>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Location</h2>
        
        <div class="form-group">
          <label for="address">Street Address*</label>
          <input 
            type="text" 
            id="address" 
            v-model="formData.address" 
            :class="{ 'error-input': formErrors.address }"
          >
          <span v-if="formErrors.address" class="error-message">{{ formErrors.address }}</span>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="city">City*</label>
            <input 
              type="text" 
              id="city" 
              v-model="formData.city" 
              :class="{ 'error-input': formErrors.city }"
            >
            <span v-if="formErrors.city" class="error-message">{{ formErrors.city }}</span>
          </div>
          
          <div class="form-group">
            <label for="state">State*</label>
            <input 
              type="text" 
              id="state" 
              v-model="formData.state" 
              :class="{ 'error-input': formErrors.state }"
            >
            <span v-if="formErrors.state" class="error-message">{{ formErrors.state }}</span>
          </div>
          
          <div class="form-group">
            <label for="zipCode">Zip Code*</label>
            <input 
              type="text" 
              id="zipCode" 
              v-model="formData.zipCode" 
              :class="{ 'error-input': formErrors.zipCode }"
            >
            <span v-if="formErrors.zipCode" class="error-message">{{ formErrors.zipCode }}</span>
          </div>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Property Details</h2>
        
        <div class="form-group">
          <label for="description">Description</label>
          <textarea 
            id="description" 
            v-model="formData.description" 
            rows="4"
            placeholder="Describe the property..."
          ></textarea>
        </div>
        
        <div class="form-group">
          <label>Amenities</label>
          <div class="amenities-container">
            <div 
              v-for="amenity in amenitiesList" 
              :key="amenity" 
              class="amenity-checkbox"
            >
              <input 
                type="checkbox" 
                :id="amenity" 
                :value="amenity" 
                :checked="formData.amenities.includes(amenity)"
                @change="toggleAmenity(amenity)"
              >
              <label :for="amenity">{{ amenity }}</label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="submit" class="submit-button">Submit Property</button>
        <button type="button" @click="resetForm" class="reset-button">Reset Form</button>
      </div>
    </form>
  </div>
</div>
</template>

<style>
@import '../assets/listings/PropertyForm.css';
</style>