<template>
  <div class="quote-form-container">
    <h3 class="form-title">Request a Quote</h3>
    
    <form @submit.prevent="submitForm" class="quote-form">
      <div class="form-group">
        <label for="name">Name</label>
        <input 
          id="name"
          type="text"
          v-model="formData.name"
          placeholder="Enter your name"
          required
          :class="{ 'has-error': errors.name }"
        />
        <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
      </div>
      
      <div class="form-group">
        <label for="email">Email Address</label>
        <input 
          id="email"
          type="email"
          v-model="formData.email"
          placeholder="Enter your email address"
          required
          :class="{ 'has-error': errors.email }"
        />
        <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
      </div>
      
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input 
          id="phone"
          type="tel"
          v-model="formData.phone"
          placeholder="Enter your phone number"
          :class="{ 'has-error': errors.phone }"
        />
        <span v-if="errors.phone" class="error-message">{{ errors.phone }}</span>
      </div>
      
      <div class="form-group">
        <label for="message">Message</label>
        <textarea 
          id="message"
          v-model="formData.message"
          placeholder="Tell us about your requirements"
          rows="4"
          :class="{ 'has-error': errors.message }"
        ></textarea>
        <span v-if="errors.message" class="error-message">{{ errors.message }}</span>
      </div>
      
      <div class="form-group checkbox-group">
        <div class="checkbox-wrapper">
          <input 
            id="gdpr"
            type="checkbox"
            v-model="formData.gdpr"
            required
            :class="{ 'has-error': errors.gdpr }"
          />
          <label for="gdpr" class="checkbox-label">
            I agree to the terms and conditions and privacy policy
          </label>
        </div>
        <span v-if="errors.gdpr" class="error-message">{{ errors.gdpr }}</span>
      </div>
      
      <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-submit" :disabled="isSubmitting">
          <span v-if="isSubmitting" class="spinner"></span>
          <span>{{ isSubmitting ? 'Submitting...' : 'Submit Quote Request' }}</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { reactive, ref, watch } from 'vue'

export default {
  props: {
    userInfo: {
      type: Object,
      default: () => ({})
    }
  },
  
  emits: ['update-field', 'submit'],
  
  setup(props, { emit }) {
    // Form data
    const formData = reactive({
      name: props.userInfo.name || '',
      email: props.userInfo.email || '',
      phone: props.userInfo.phone || '',
      message: props.userInfo.message || '',
      gdpr: false
    })
    
    // Form state
    const errors = reactive({})
    const isSubmitting = ref(false)
    
    // Watch for changes in form data
    watch(formData, (newValue, oldValue) => {
      // Find which field changed
      for (const key in newValue) {
        if (newValue[key] !== oldValue[key]) {
          emit('update-field', { field: key, value: newValue[key] })
          
          // Clear error when field is updated
          if (errors[key]) {
            errors[key] = ''
          }
        }
      }
    })
    
    // Form validation
    const validateForm = () => {
      const newErrors = {}
      
      if (!formData.name.trim()) {
        newErrors.name = 'Name is required'
      }
      
      if (!formData.email.trim()) {
        newErrors.email = 'Email is required'
      } else if (!isValidEmail(formData.email)) {
        newErrors.email = 'Please enter a valid email address'
      }
      
      if (formData.phone && !isValidPhone(formData.phone)) {
        newErrors.phone = 'Please enter a valid phone number'
      }
      
      if (!formData.gdpr) {
        newErrors.gdpr = 'You must agree to the terms and conditions'
      }
      
      // Copy validation errors
      for (const key in newErrors) {
        errors[key] = newErrors[key]
      }
      
      return Object.keys(newErrors).length === 0
    }
    
    const isValidEmail = (email) => {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(String(email).toLowerCase())
    }
    
    const isValidPhone = (phone) => {
      const re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/
      return re.test(String(phone))
    }
    
    // Submit handler
    const submitForm = () => {
      if (!validateForm()) return
      
      isSubmitting.value = true
      
      // Emit submit event with form data
      emit('submit')
    }
    
    return {
      formData,
      errors,
      isSubmitting,
      submitForm
    }
  }
}
</script>

<style scoped>
.quote-form-container {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.form-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 1.5rem 0;
}

.quote-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #475569;
  margin-bottom: 0.5rem;
}

input[type="text"],
input[type="email"],
input[type="tel"],
textarea {
  padding: 0.75rem;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  font-size: 1rem;
  color: #0f172a;
  background-color: #f8fafc;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

input:focus,
textarea:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

input::placeholder,
textarea::placeholder {
  color: #94a3b8;
}

.checkbox-group {
  margin-top: 0.5rem;
}

.checkbox-wrapper {
  display: flex;
  align-items: flex-start;
}

input[type="checkbox"] {
  margin-top: 0.25rem;
  margin-right: 0.75rem;
  width: 16px;
  height: 16px;
}

.checkbox-label {
  font-size: 0.875rem;
  line-height: 1.5;
  color: #475569;
}

.has-error {
  border-color: #ef4444;
}

.error-message {
  font-size: 0.75rem;
  color: #ef4444;
  margin-top: 0.375rem;
}

.form-actions {
  margin-top: 1rem;
}

.btn-submit {
  width: 100%;
  padding: 0.75rem 1.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.spinner {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>