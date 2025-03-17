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
        <p><strong>Title:</strong></p>
        <p><strong>Price:</strong> </p>
        <p><strong>Type:</strong> </p>
        <p><strong>Size:</strong> </p>
        <p><strong>Bedrooms:</strong> </p>
        <p><strong>Bathrooms:</strong> </p>
        <p><strong>Address:</strong> </p>
        <strong>Amenities:</strong> 
      </div>
      <button  class="submit-button">Submit Another Property</button>
    </div>
    
    <form v-else  class="property-form">
      <div class="form-section">
        <h2>Basic Information</h2>
        
        <div class="form-group">
          <label for="title">Property Title*</label>
          <input 
            type="text" 
            id="title" 
            
          >
          <span class="error-message"></span>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="price">Price ($)*</label>
            <input 
              type="text" 
              id="price" 
            >
            <span  class="error-message"></span>
          </div>
          
          <div class="form-group">
            <label for="propertyType">Property Type*</label>
            <select id="propertyType" >
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
            <input type="number" id="bedrooms"  min="0">
          </div>
          
          <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="number" id="bathrooms"  min="0" step="0.5">
          </div>
          
          <div class="form-group">
            <label for="squareFeet">Square Feet*</label>
            <input 
              type="text" 
              id="squareFeet" 
            >
            <span  class="error-message"></span>
          </div>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Location</h2>
        
        <div class="form-group">
          <label for="address">Street Address*</label>
          <input type="text" id="address" >
          <span  class="error-message"></span>
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="city">City*</label>
            <input type="text" id="city">
            <span  class="error-message"></span>
          </div>
          
          <div class="form-group">
            <label for="state">State*</label>
            <input type="text" id="state"  >
            <span  class="error-message"></span>
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
            <div class="amenity-checkbox">
              <input 
                type="checkbox" >
              <label ></label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-actions">
        <button type="submit" class="submit-button">Submit Property</button>
        <button type="button"  class="reset-button">Reset Form</button>
      </div>
    </form>
  </div>
</div>
</template>

<style>
@import '../assets/listings/PropertyForm.css';
</style>