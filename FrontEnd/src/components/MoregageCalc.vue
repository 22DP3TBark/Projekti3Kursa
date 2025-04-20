<script setup>
import { ref, computed } from 'vue';

const price = ref(250000); // default property price
const downPayment = ref(50000);
const interestRate = ref(4); // in percent
const loanTerm = ref(30); // in years

// Monthly Payment = P[r(1+r)^n] / [(1+r)^n – 1]
const monthlyPayment = computed(() => {
  const loanAmount = price.value - downPayment.value;
  const monthlyInterest = interestRate.value / 100 / 12;
  const numberOfPayments = loanTerm.value * 12;

  if (loanAmount <= 0 || interestRate.value <= 0 || loanTerm.value <= 0) {
    return 0;
  }

  const numerator = loanAmount * monthlyInterest * Math.pow(1 + monthlyInterest, numberOfPayments);
  const denominator = Math.pow(1 + monthlyInterest, numberOfPayments) - 1;

  return numerator / denominator;
});
</script>

<template>
    <div class="calculator">
      <h2>Mortgage Calculator</h2>
  
      <div class="input-group">
        <label>Property Price (€)</label>
        <input type="number" v-model="price" />
      </div>
  
      <div class="input-group">
        <label>Down Payment (€)</label>
        <input type="number" v-model="downPayment" />
      </div>
  
      <div class="input-group">
        <label>Interest Rate (%)</label>
        <input type="number" v-model="interestRate" step="0.1" />
      </div>
  
      <div class="input-group">
        <label>Loan Term (Years)</label>
        <input type="number" v-model="loanTerm" />
      </div>
  
      <div class="result">
        <p>Estimated Monthly Payment:</p>
        <h3>€{{ monthlyPayment.toFixed(2) }}</h3>
      </div>
    </div>
  </template>

  <style scoped>
.calculator {
  background: #fff;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  max-width: 400px;
  margin: 0 auto;
}

h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  text-align: center;
}

.input-group {
  margin-bottom: 1rem;
}

.input-group label {
  display: block;
  font-weight: 600;
  margin-bottom: 0.3rem;
}

.input-group input {
  width: 100%;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
}

.result {
  text-align: center;
  margin-top: 1.5rem;
}

.result h3 {
  font-size: 1.8rem;
  color: #0066ff;
}
</style>