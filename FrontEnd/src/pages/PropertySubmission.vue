<script setup>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import axiosClient from "../../axiosClient";
import LocationStep from '../components/LocationStep.vue';

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

// Validation state
const errors = reactive({
  basicInfo: {},
  location: {},
  details: {},
  features: {},
  pricing: {},
});

// Validation functions
function validateBasicInfo() {
  errors.basicInfo = {};
  if (!userType.value.value) errors.basicInfo.userType = "Lūdzu izvēlieties lietotāja tipu.";
  if (!basicInfo.value.title) errors.basicInfo.title = "Virsraksts ir obligāts.";
  if (!basicInfo.value.description) errors.basicInfo.description = "Apraksts ir obligāts.";
  if (!basicInfo.value.purpose) errors.basicInfo.purpose = "Lūdzu izvēlieties mērķi.";
  if (!basicInfo.value.propertyType) errors.basicInfo.propertyType = "Lūdzu norādiet īpašuma tipu.";
  return Object.keys(errors.basicInfo).length === 0;
}

function validateLocation() {
  errors.location = {};
  if (!location.value.address) errors.location.address = "Adrese ir obligāta.";
  if (!location.value.city) errors.location.city = "Pilsēta ir obligāta.";
  if (!location.value.district) errors.location.district = "Rajons ir obligāts.";
  if (!location.value.zipCode) errors.location.zipCode = "Pasta indekss ir obligāts.";
  if (!location.value.country) errors.location.country = "Valsts ir obligāta.";
  // Optionally validate lat/lon
  return Object.keys(errors.location).length === 0;
}

function validateDetails() {
  errors.details = {};
  if (!details.value.bedrooms) errors.details.bedrooms = "Guļamistabu skaits ir obligāts.";
  if (!details.value.bathrooms) errors.details.bathrooms = "Vannas istabu skaits ir obligāts.";
  if (!details.value.size) errors.details.size = "Izmērs ir obligāts.";
  if (!details.value.floor) errors.details.floor = "Stāvs ir obligāts.";
  if (!details.value.buildingType) errors.details.buildingType = "Ēkas tips ir obligāts.";
  if (!details.value.yearBuilt) errors.details.yearBuilt = "Uzcelšanas gads ir obligāts.";
  if (!details.value.parkingSpaces) errors.details.parkingSpaces = "Stāvvietu skaits ir obligāts.";
  return Object.keys(errors.details).length === 0;
}

function validateFeatures() {
  errors.features = {};
  if (!features.value.mainImage) errors.features.mainImage = "Galvenais attēls ir obligāts.";
  // Optionally validate gallery or amenities
  return Object.keys(errors.features).length === 0;
}

function validatePricing() {
  errors.pricing = {};
  if (!pricing.value.price) errors.pricing.price = "Cena ir obligāta.";
  if (!pricing.value.status) errors.pricing.status = "Statuss ir obligāts.";
  return Object.keys(errors.pricing).length === 0;
}

const nextStep = () => {
  let valid = true;
  if (currentStep.value === 1) valid = validateBasicInfo();
  if (currentStep.value === 2) valid = validateLocation();
  if (currentStep.value === 3) valid = validateDetails();
  if (currentStep.value === 4) valid = validateFeatures();
  if (valid && currentStep.value < totalSteps) currentStep.value++;
};

const prevStep = () => {
  if (currentStep.value > 1) currentStep.value--;
};

const handleMainImageUpload = (e) => {
  features.value.mainImage = e.target.files[0];
};

const handleGalleryUpload = (e) => {
  const newFiles = Array.from(e.target.files);
  const existingNames = features.value.gallery.map(f => f.name);
  newFiles.forEach(file => {
    if (!existingNames.includes(file.name)) {
      features.value.gallery.push(file);
    }
  });
  e.target.value = '';
};

const router = useRouter();

const UserPropSubmission = async () => {
  // Validate all before submit
  const valid =
    validateBasicInfo() &
    validateLocation() &
    validateDetails() &
    validateFeatures() &
    validatePricing();
  if (!valid) {
    currentStep.value = [validateBasicInfo, validateLocation, validateDetails, validateFeatures, validatePricing]
      .findIndex(fn => !fn()) + 1;
    return;
  }
  try {
    // Prepare FormData for file uploads
    const formData = new FormData();
    formData.append("userType", userType.value.value); // Fix: use .value
    formData.append("title", basicInfo.value.title);
    formData.append("description", basicInfo.value.description);
    formData.append("purpose", basicInfo.value.purpose);
    formData.append("property_type", basicInfo.value.propertyType); // Corrected field name
    formData.append("address", location.value.address || ""); // Ensure non-null values
    formData.append("city", location.value.city || "");
    formData.append("district", location.value.district || ""); // Ensure district is appended
    formData.append("zip_code", location.value.zipCode || ""); // Corrected field name
    formData.append("country", location.value.country || "");
    formData.append("latitude", location.value.latitude || "");
    formData.append("longitude", location.value.longitude || "");
    formData.append("bedrooms", details.value.bedrooms);
    formData.append("bathrooms", details.value.bathrooms);
    formData.append("size", details.value.size);
    formData.append("floor", details.value.floor); // Ensure floor is appended
    formData.append("building_type", details.value.buildingType); // Corrected field name
    formData.append("year_built", details.value.yearBuilt); // Corrected field name
    formData.append("parking_spaces", details.value.parkingSpaces); // Corrected field name
    formData.append("price", pricing.value.price);
    formData.append("currency", pricing.value.currency);
    formData.append("status", pricing.value.status);

    // Append main image
    if (features.value.mainImage) {
      formData.append("main_image", features.value.mainImage); // Corrected field name
    }

    // Append gallery images as an array (gallery[])
    if (features.value.gallery.length > 0) {
      features.value.gallery.forEach((file) => {
        formData.append("gallery[]", file);
      });
    }

    // Append amenities as a JSON string
    formData.append("amenities", JSON.stringify(features.value.amenities));
    formData.append("balcony", features.value.amenities.includes("Balcony") ? 1 : 0);
    formData.append("garage", features.value.amenities.includes("Garage") ? 1 : 0);
    formData.append("swimming_pool", features.value.amenities.includes("Swimming Pool") ? 1 : 0);
    formData.append("garden", features.value.amenities.includes("Garden") ? 1 : 0);
    formData.append("furnished", features.value.amenities.includes("Furnished") ? 1 : 0);

    console.log('FormData being sent:', Object.fromEntries(formData.entries())); // Log FormData

    // Send the request
    const response = await axiosClient.post("/properties", formData);

    console.log("Property submitted successfully:", response.data);
    alert("Property submitted successfully!");
    // Redirect to payment page, passing property id as query param
    const propertyId = response.data?.property?.id || response.data?.id;
    if (propertyId) {
      router.push({ name: "Payment", query: { property_id: propertyId } });
    } else {
      router.push({ name: "Payment" });
    }
  } catch (error) {
    console.error("Error submitting property:", error.message);
    if (error.response) {
      console.error("Response data:", error.response.data);
    }
    alert("Failed to submit property. Please try again.");
  }
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

// Helper for object URL
const getObjectURL = (file) => {
  return window.URL.createObjectURL(file);
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
            :class="{ selected: userType.value === 'company' }"
            @click="userType.value = 'company'"
          >
            Nekustamo īpašumu aģentūra
          </button>
          <button
            class="option-button"
            :class="{ selected: userType.value === 'private' }"
            @click="userType.value = 'private'"
          >
            Privat Persona
          </button>
        </div>
        <span v-if="errors.basicInfo.userType" class="error-msg">{{ errors.basicInfo.userType }}</span>
      </div>

      <div class="form-group">
        <label>Virsraksts</label>
        <input v-model="basicInfo.title" type="text" placeholder="Listing Title" />
        <span v-if="errors.basicInfo.title" class="error-msg">{{ errors.basicInfo.title }}</span>
      </div>
      <div class="form-group">
        <label>Apraksts</label>
        <textarea v-model="basicInfo.description" placeholder="Property Description"></textarea>
        <span v-if="errors.basicInfo.description" class="error-msg">{{ errors.basicInfo.description }}</span>
      </div>
      <div class="form-group">
        <label>Mērķis</label>
        <select v-model="basicInfo.purpose">
          <option disabled value="">Select purpose</option>
          <option>Pārdot</option>
          <option>īrēt</option>
        </select>
        <span v-if="errors.basicInfo.purpose" class="error-msg">{{ errors.basicInfo.purpose }}</span>
      </div>
      <div class="form-group">
        <label>īpašuma tips</label>
        <input v-model="basicInfo.propertyType" type="text" placeholder="e.g. Dzīvoklis, Māja" />
        <span v-if="errors.basicInfo.propertyType" class="error-msg">{{ errors.basicInfo.propertyType }}</span>
      </div>

      <div class="navigation-buttons">
        <button @click="nextStep" :disabled="false">
          Next
        </button>
      </div>
    </div>

    <div v-if="currentStep === 2" class="step">
      <h2>Step 2: Location</h2>
      <LocationStep
        v-model:street="location.address"
        v-model:city="location.city"
        v-model:state="location.district"
        v-model:country="location.country"
        v-model:lat="location.latitude"
        v-model:lon="location.longitude"
      />
      <div class="form-group">
        <span v-if="errors.location.address" class="error-msg">{{ errors.location.address }}</span>
        <span v-if="errors.location.city" class="error-msg">{{ errors.location.city }}</span>
        <span v-if="errors.location.district" class="error-msg">{{ errors.location.district }}</span>
        <span v-if="errors.location.zipCode" class="error-msg">{{ errors.location.zipCode }}</span>
        <span v-if="errors.location.country" class="error-msg">{{ errors.location.country }}</span>
      </div>
      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="nextStep">Next</button>
      </div>
    </div>

    <div v-if="currentStep === 3" class="step">
      <h2>Step 3: Property Details</h2>
      <div class="form-grid">
        <div class="form-group">
          <label>Guļamistabas</label>
          <input v-model="details.bedrooms" type="number" />
          <span v-if="errors.details.bedrooms" class="error-msg">{{ errors.details.bedrooms }}</span>
        </div>
        <div class="form-group">
          <label>Vannas Izstaba</label>
          <input v-model="details.bathrooms" type="number" />
          <span v-if="errors.details.bathrooms" class="error-msg">{{ errors.details.bathrooms }}</span>
        </div>
        <div class="form-group">
          <label>izmērs(m²)</label>
          <input v-model="details.size" type="number" />
          <span v-if="errors.details.size" class="error-msg">{{ errors.details.size }}</span>
        </div>
        <div class="form-group">
          <label>stāvs</label>
          <input v-model="details.floor" type="number" />
          <span v-if="errors.details.floor" class="error-msg">{{ errors.details.floor }}</span>
        </div>
        <div class="form-group">
          <label>īpašuma tips</label>
          <input v-model="details.buildingType" type="text" />
          <span v-if="errors.details.buildingType" class="error-msg">{{ errors.details.buildingType }}</span>
        </div>
        <div class="form-group">
          <label>Uzcelšanas gads</label>
          <input v-model="details.yearBuilt" type="number" />
          <span v-if="errors.details.yearBuilt" class="error-msg">{{ errors.details.yearBuilt }}</span>
        </div>
        <div class="form-group">
          <label>Parkings</label>
          <input v-model="details.parkingSpaces" type="number" />
          <span v-if="errors.details.parkingSpaces" class="error-msg">{{ errors.details.parkingSpaces }}</span>
        </div>
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
          <label><input type="checkbox" value="Balcony" v-model="features.amenities" /> Balkons</label>
          <label><input type="checkbox" value="Garage" v-model="features.amenities" /> Garāža</label>
          <label><input type="checkbox" value="Swimming Pool" v-model="features.amenities" /> Baseins</label>
          <label><input type="checkbox" value="Garden" v-model="features.amenities" /> Dārzs</label>
          <label><input type="checkbox" value="Furnished" v-model="features.amenities" />Mebeles</label>
        </div>
      </div>
      <div class="form-group">
        <label>Main Image</label>
        <input type="file" accept="image/*" @change="handleMainImageUpload" />
        <span v-if="errors.features.mainImage" class="error-msg">{{ errors.features.mainImage }}</span>
      </div>
      <div class="form-group">
        <label>Gallery Images</label>
        <input type="file" accept="image/*" multiple @change="handleGalleryUpload" />
        <div v-if="features.gallery.length" style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap;">
          <img
            v-for="(img, idx) in features.gallery"
            :key="idx"
            :src="getObjectURL(img)"
            style="width:80px;height:80px;object-fit:cover;border-radius:8px;"
          />
        </div>
      </div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="nextStep">Next</button>
      </div>
    </div>

    <div v-if="currentStep === 5" class="step">
      <h2>Step 5: Price & Status</h2>
      <div class="form-group">
        <label>Cena</label>
        <input v-model="pricing.price" type="number" />
        <span v-if="errors.pricing.price" class="error-msg">{{ errors.pricing.price }}</span>
      </div>
      <div class="form-group">
        <label>Currency</label>
        <input v-model="pricing.currency" type="text" disabled />
      </div>
      <div class="form-group">
        <label>Status</label>
        <select v-model="pricing.status">
          <option disabled value="">Select status</option>
          <option>Available</option>
          <option>Sold</option>
          <option>Rented</option>
        </select>
        <span v-if="errors.pricing.status" class="error-msg">{{ errors.pricing.status }}</span>
      </div>

      <div class="navigation-buttons">
        <button @click="prevStep">Back</button>
        <button @click="UserPropSubmission">Submit</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
body, html {
  height: 100%;
  margin: 0;
  font-family: 'Inter', sans-serif;
  background-color: #f9fafb;
}

.submission-container {
  max-width: 1100px;
  margin: 40px auto;
  padding: 40px;
  background-color: #ffffff;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
  display: flex;
  flex-direction: column;
  min-height: 90vh;
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
  transition: all 0.3s ease;
}

.progress-step.active {
  background-color: #3b82f6;
  color: #ffffff;
  box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
}

.step {
  flex-grow: 1;
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
}

.form-group label {
  margin-bottom: 8px;
  font-weight: 500;
  color: #374151;
}

input[type="text"],
input[type="number"],
input[type="file"],
textarea,
select {
  padding: 12px 16px;
  border: 1px solid #d1d5db;
  border-radius: 12px;
  font-size: 1rem;
  outline: none;
  transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="number"]:focus,
textarea:focus,
select:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

textarea {
  resize: vertical;
  min-height: 120px;
}

.user-type-options {
  display: flex;
  gap: 16px;
}

.option-button {
  flex: 1;
  padding: 12px;
  border: 2px solid #d1d5db;
  background-color: #ffffff;
  border-radius: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.option-button:hover {
  background-color: #f3f4f6;
}

.option-button.selected {
  border-color: #3b82f6;
  background-color: #dbeafe;
  color: #1d4ed8;
}

.navigation-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
  gap: 16px;
}

.navigation-buttons button {
  flex: 1;
  padding: 14px;
  background-color: #3b82f6;
  color: #ffffff;
  border: none;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.navigation-buttons button:hover {
  background-color: #2563eb;
}

.navigation-buttons button:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.checkbox-group {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.checkbox-group label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 500;
  color: #374151;
}

.checkbox-group input[type="checkbox"] {
  width: 18px;
  height: 18px;
  accent-color: #3b82f6;
}

input[type="file"] {
  background-color: #f9fafb;
}

.error-msg {
  color: #dc2626;
  font-size: 0.95em;
  margin-top: 4px;
  margin-bottom: 2px;
  display: block;
}
</style>
