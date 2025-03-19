<script setup>

</script>

<template>
<div class="form-container">
    <h2>Submit Property</h2>
    <div class="form-section">
      <h3>Basic Information</h3>
      <hr />

      <div class="form-group">
        <input type="text" placeholder="Property Title" />
      </div>

      <div class="form-group">
        <textarea placeholder="Description"></textarea>
      </div>

      <div class="form-row">
        <input type="number" placeholder="Price" />
        <input type="text" placeholder="Currency (e.g., USD, EUR)" />
      </div>

      <div class="form-row">
        <input type="text" placeholder="Property Type (house, apartment, etc.)" />
        <input type="text" placeholder="Status (available, sold, rented)" />
      </div>

      <div class="form-row">
        <input type="number" placeholder="Bedrooms" />
        <input type="number" placeholder="Bathrooms" />
        <input type="number" placeholder="Parking Spaces" />
      </div>

      <div class="form-row">
        <input type="number" placeholder="Size (sq ft)" />
        <input type="number" placeholder="Year Built" />
      </div>
    </div>

    <div class="form-section">
      <h3>Location Details</h3>
      <hr />

      <div class="form-group">
        <input type="text" placeholder="Address" />
      </div>

      <div class="form-row">
        <input type="text" placeholder="City" />
        <input type="text" placeholder="State" />
      </div>

      <div class="form-row">
        <input type="text" placeholder="Country" />
        <input type="text" placeholder="ZIP Code" />
      </div>

      <div class="form-row">
        <input type="number" placeholder="Latitude" step="0.000001" />
        <input type="number" placeholder="Longitude" step="0.000001" />
      </div>
    </div>

    <div class="form-section">
      <h3>Additional Features</h3>
      <hr />

      <div class="checkbox-group">
        <label><input type="checkbox" /> Balcony</label>
        <label><input type="checkbox" /> Garage</label>
        <label><input type="checkbox" /> Swimming Pool</label>
        <label><input type="checkbox" /> Garden</label>
        <label><input type="checkbox" /> Furnished</label>
      </div>
    </div>

    <div class="form-section">
      <h3>Images</h3>
      <hr />

      <div class="form-group">
        <label>Main Image</label>
        <input type="file" accept="image/*" />
      </div>

      <div class="form-group">
        <label>Gallery Images</label>
        <input type="file" multiple accept="image/*" />
      </div>
    </div>

    <button type="submit">Submit Property</button>
  </div>
</template>

<style scoped>
@import "../assets/Form.css";
</style>