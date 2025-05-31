<template>
  <div class="confirmation-container">
    <div class="confirmation-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>
    </div>
    
    <h2 class="confirmation-title">Thank You for Your Request!</h2>
    
    <p class="confirmation-message">
      Your quote request has been successfully submitted. We will review your configuration
      and get back to you shortly with a customized quote.
    </p>
    
    <p class="confirmation-details">
      A confirmation email has been sent to your inbox with the details of your request.
      Please check your email for further information.
    </p>
    
    <div class="confirmation-actions">
      <button @click="startNewConfiguration" class="btn btn-secondary">
        Start a New Configuration
      </button>
    </div>
  </div>
</template>

<script>
import { useStore } from 'vuex'

export default {
  setup() {
    const store = useStore()
    
    const startNewConfiguration = () => {
      store.commit('setActiveProduct', null)
      store.commit('setCurrentStep', 'configure')
    }
    
    return {
      startNewConfiguration
    }
  }
}
</script>

<style scoped>
.confirmation-container {
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}

.confirmation-icon {
  color: #10b981;
  margin-bottom: 1.5rem;
}

.confirmation-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 1rem 0;
}

.confirmation-message {
  font-size: 1rem;
  color: #475569;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}

.confirmation-details {
  font-size: 0.875rem;
  color: #64748b;
  margin-bottom: 2rem;
  padding: 1rem;
  background-color: #f8fafc;
  border-radius: 6px;
}

.confirmation-actions {
  margin-top: 1rem;
}
</style>