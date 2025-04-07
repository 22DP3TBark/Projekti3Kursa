<script setup>
import { ref, nextTick } from "vue";
import { useRouter } from "vue-router";
import axiosClient from "../../axiosClient";

const title = ref("");
const description = ref("");
const price = ref(0);
const currency = ref("");
const propertyType = ref("");
const status = ref("");
const bedrooms = ref(0);
const bathrooms = ref(0);
const parkingSpaces = ref(0);
const size = ref(0);
const yearBuilt = ref(0);
const address = ref("");
const city = ref("");
const state = ref("");
const country = ref("");
const zipCode = ref("");
const latitude = ref(null);
const longitude = ref(null);
const features = ref({
  balcony: false,
  garage: false,
  swimmingPool: false,
  garden: false,
  furnished: false,
});
const mainImage = ref(null);
const galleryImages = ref([]);
const message = ref("");

function handleMainImage(event) {
  if (event.target.files.length > 0) {
    nextTick(() => {
      mainImage.value = event.target.files[0];
    });
  }
}

function handleGalleryImages(event) {
  const selectedFiles = Array.from(event.target.files);

  // Ensure only valid image files are added
  selectedFiles.forEach((file) => {
    if (!galleryImages.value.some((f) => f.name === file.name && f.lastModified === file.lastModified)) {
      galleryImages.value.push(file);
    }
  });

  // Reset input value to allow re-selection of the same file
  event.target.value = "";
}

async function submitProperty() {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("description", description.value);
  formData.append("price", price.value);
  formData.append("currency", currency.value);
  formData.append("property_type", propertyType.value);
  formData.append("status", status.value);
  formData.append("bedrooms", bedrooms.value);
  formData.append("bathrooms", bathrooms.value);
  formData.append("parking_spaces", parkingSpaces.value);
  formData.append("size", size.value);
  formData.append("year_built", yearBuilt.value);
  formData.append("address", address.value);
  formData.append("city", city.value);
  formData.append("state", state.value);
  formData.append("country", country.value);
  formData.append("zip_code", zipCode.value);
  formData.append("latitude", latitude.value);
  formData.append("longitude", longitude.value);
  formData.append("balcony", features.value.balcony);
  formData.append("garage", features.value.garage);
  formData.append("swimming_pool", features.value.swimmingPool);
  formData.append("garden", features.value.garden);
  formData.append("furnished", features.value.furnished);

  if (mainImage.value) {
    formData.append("main_image", mainImage.value);
  }

  // Append gallery images to FormData
  galleryImages.value.forEach((image, index) => {
    formData.append(`gallery[${index}]`, image);
  });

  try {
    const response = await axiosClient.post("/properties", formData);
    message.value = "Property submitted successfully!";
  } catch (error) {
    message.value = error.response?.data?.message || "An error occurred";
  }
}
</script>

<template>
  <Suspense>
    <div class="form-container">
      <h2>Submit Property</h2>
      <div class="form-section">
        <h3>Basic Information</h3>
        <hr />

        <div class="form-group">
          <input type="text" placeholder="Property Title" v-model="title" />
        </div>

        <div class="form-group">
          <textarea placeholder="Description" v-model="description"></textarea>
        </div>

        <div class="form-row">
          <input type="number" placeholder="Price" v-model="price" />
          <input type="text" placeholder="Currency (e.g., USD, EUR)" v-model="currency" />
        </div>

        <div class="form-row">
          <input type="text" placeholder="Property Type (house, apartment, etc.)" v-model="propertyType" />
          <input type="text" placeholder="Status (available, sold, rented)" v-model="status" />
        </div>

        <div class="form-row">
          <input type="number" placeholder="Bedrooms" v-model="bedrooms" />
          <input type="number" placeholder="Bathrooms" v-model="bathrooms" />
          <input type="number" placeholder="Parking Spaces" v-model="parkingSpaces" />
        </div>

        <div class="form-row">
          <input type="number" placeholder="Size (sq ft)" v-model="size" />
          <input type="number" placeholder="Year Built" v-model="yearBuilt" />
        </div>
      </div>

      <div class="form-section">
        <h3>Location Details</h3>
        <hr />
        <div class="form-group">
          <input type="text" placeholder="Address" v-model="address" />
        </div>
        <div class="form-row">
          <input type="text" placeholder="City" v-model="city" />
          <input type="text" placeholder="State" v-model="state" />
        </div>
        <div class="form-row">
          <input type="text" placeholder="Country" v-model="country" />
          <input type="text" placeholder="ZIP Code" v-model="zipCode" />
        </div>
        <div class="form-row">
          <input type="number" placeholder="Latitude" step="0.000001" v-model="latitude" />
          <input type="number" placeholder="Longitude" step="0.000001" v-model="longitude" />
        </div>
      </div>

      <div class="form-section">
        <h3>Additional Features</h3>
        <hr />
        <div class="checkbox-group">
          <label><input type="checkbox" v-model="features.balcony" /> Balcony</label>
          <label><input type="checkbox" v-model="features.garage" /> Garage</label>
          <label><input type="checkbox" v-model="features.swimmingPool" /> Swimming Pool</label>
          <label><input type="checkbox" v-model="features.garden" /> Garden</label>
          <label><input type="checkbox" v-model="features.furnished" /> Furnished</label>
        </div>
      </div>

      <div class="form-section">
        <h3>Images</h3>
        <hr />
        <div class="form-group">
          <label>Main Image</label>
          <input type="file" accept="image/*" @change="handleMainImage" />
        </div>
        <div class="form-group">
          <label>Gallery Images</label>
          <input type="file" multiple accept="image/*" @change="handleGalleryImages" />
        </div>
        <div class="form-group">
          <h4>Selected Gallery Images:</h4>
          <ul>
            <li v-for="(image, index) in galleryImages" :key="index">{{ image.name }}</li>
          </ul>
        </div>
      </div>

      <button type="submit" @click="submitProperty">Submit Property</button>
    </div>
  </Suspense>
</template>

<style scoped>
@import "../assets/Form.css";
</style>
