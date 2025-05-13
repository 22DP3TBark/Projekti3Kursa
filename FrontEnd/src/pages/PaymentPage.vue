<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import axiosClient from '../../axiosClient'

const route = useRoute()
const propertyId = ref(Number(route.query.property_id) || 1) // fallback to 1 if not provided

const cardNumber = ref('')
const cardName = ref('')
const expiry = ref('')
const cvc = ref('')
const isPaid = ref(false)
const loading = ref(false)
const error = ref('')

async function pay() {
  error.value = ''
  loading.value = true
  try {
    // Only send required fields to backend
    await axiosClient.post('/property-receipts', {
      property_id: propertyId.value,
      card_number: cardNumber.value.replace(/\s/g, '') // remove spaces
    })
    isPaid.value = true
  } catch (e) {
    error.value = e.response?.data?.message || 'Payment failed. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="payment-container">
    <div class="payment-card">
      <h2>Confirm Your Payment</h2>
      <div class="summary">
        <h3>Property Summary</h3>
        <!-- Replace with real property info as needed -->
        <div class="summary-row">
          <span>Property:</span>
          <span>Modern Apartment</span>
        </div>
        <div class="summary-row">
          <span>Price:</span>
          <span>€1,200 / month</span>
        </div>
      </div>
      <form class="payment-form" @submit.prevent="pay" v-if="!isPaid">
        <label>
          Card Number
          <input
            v-model="cardNumber"
            maxlength="19"
            placeholder="1234 5678 9012 3456"
            required
            pattern="\d{4} \d{4} \d{4} \d{4}"
            autocomplete="cc-number"
          />
        </label>
        <label>
          Name on Card
          <input
            v-model="cardName"
            placeholder="John Doe"
            required
            autocomplete="cc-name"
          />
        </label>
        <div class="row">
          <label>
            Expiry
            <input
              v-model="expiry"
              maxlength="5"
              placeholder="MM/YY"
              required
              pattern="\d{2}/\d{2}"
              autocomplete="cc-exp"
            />
          </label>
          <label>
            CVC
            <input
              v-model="cvc"
              maxlength="4"
              placeholder="123"
              required
              pattern="\d{3,4}"
              autocomplete="cc-csc"
            />
          </label>
        </div>
        <button type="submit" class="pay-btn" :disabled="loading">
          <span v-if="loading">Processing...</span>
          <span v-else>Pay</span>
        </button>
        <div v-if="error" class="error-message">{{ error }}</div>
      </form>
      <div v-else class="success-message">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12" fill="#4ade80"/><path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <p>Payment Successful!</p>
        <p>Thank you for your submission.</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.payment-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(120deg, #f0f4f8 0%, #e0e7ff 100%);
}
.payment-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 6px 32px rgba(60, 72, 88, 0.15);
  padding: 2.5rem 2rem;
  width: 100%;
  max-width: 400px;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
h2 {
  margin: 0 0 0.5rem 0;
  font-weight: 700;
  color: #3730a3;
  text-align: center;
}
.summary {
  background: #f3f4f6;
  border-radius: 10px;
  padding: 1rem;
  margin-bottom: 1rem;
}
.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
  font-size: 1rem;
}
.payment-form label {
  display: block;
  margin-bottom: 1rem;
  font-weight: 500;
  color: #4b5563;
}
.payment-form input {
  width: 100%;
  padding: 0.6rem 0.8rem;
  margin-top: 0.3rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 1rem;
  background: #f9fafb;
  transition: border 0.2s;
}
.payment-form input:focus {
  border: 1.5px solid #6366f1;
  outline: none;
}
.row {
  display: flex;
  gap: 1rem;
}
.pay-btn {
  width: 100%;
  padding: 0.8rem;
  background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: 0.5rem;
  transition: background 0.2s;
}
.pay-btn:hover {
  background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
}
.success-message {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #059669;
  gap: 0.5rem;
  text-align: center;
}
.error-message {
  color: #dc2626;
  background: #fef2f2;
  border-radius: 6px;
  padding: 0.5rem 0.8rem;
  margin-top: 0.5rem;
  text-align: center;
  font-size: 1rem;
}
</style>