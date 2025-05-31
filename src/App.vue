<template>
  <div class="configurator-app">
    <header class="app-header">
      <div class="container">
        <div class="header-content">
          <div class="logo">
            <a href="/" class="logo-link">
              <img src="./assets/images/logo.svg" alt="Configurator" class="logo-image" />
              <span class="logo-text">Configurator</span>
            </a>
          </div>
          
          <nav class="main-nav">
            <ul class="nav-list">
              <li class="nav-item">
                <a href="#" class="nav-link">Home</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Products</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">About</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">Contact</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
    
    <main class="configurator-main">
      <div class="notifications-container">
        <div 
          v-for="notification in notifications" 
          :key="notification.id"
          class="notification"
          :class="getNotificationClass(notification.type)"
        >
          <div class="notification-content">
            <div class="notification-icon">
              <svg v-if="notification.type === 'success'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
              
              <svg v-else-if="notification.type === 'error'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
              
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            </div>
            
            <div class="notification-message">
              {{ notification.message }}
            </div>
          </div>
          
          <button 
            class="notification-close"
            @click="dismissNotification(notification.id)"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
      </div>
      
      <div v-if="!activeProduct" class="product-selector">
        <h2>Select a Product to Configure</h2>
        <div class="product-grid">
          <div 
            v-for="product in configurators" 
            :key="product.id"
            class="product-card"
            @click="selectProduct(product)"
          >
            <div class="product-image">
              <img 
                v-if="product.thumbnail" 
                :src="product.thumbnail" 
                :alt="product.name"
              />
              <div v-else class="product-placeholder">
                <span>{{ product.name.charAt(0) }}</span>
              </div>
            </div>
            
            <div class="product-info">
              <h3 class="product-name">{{ product.name }}</h3>
              
              <p v-if="product.shortDescription" class="product-description">
                {{ product.shortDescription }}
              </p>
              
              <div class="product-meta">
                <span class="product-price">{{ formatPrice(product.basePrice) }}</span>
                <span class="product-tag" v-if="product.isNew">New</span>
              </div>
            </div>
            
            <button class="product-configure-btn">
              Configure
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
          </div>
        </div>
      </div>
      
      <div v-else class="configurator-container">
        <header class="configurator-header">
          <div class="product-info">
            <h1 class="product-title">{{ activeProduct.name }}</h1>
            <p v-if="activeProduct.description" class="product-description">
              {{ activeProduct.description }}
            </p>
          </div>
          
          <div class="price-display">
            <span class="price-label">Total Price:</span>
            <span class="price-value">{{ formattedPrice }}</span>
          </div>
        </header>
        
        <div class="configurator-body">
          <div class="preview-panel">
            <div class="preview-container">
              <div 
                v-for="view in activeProduct.views" 
                :key="view.id"
                class="preview-view"
                :class="{ 'is-active': view.id === activeView }"
              >
                <div class="base-image-container">
                  <img 
                    v-if="view.baseImage" 
                    :src="view.baseImage" 
                    :alt="activeProduct.name" 
                    class="base-image"
                  />
                </div>
                
                <div class="layer-images-container">
                  <div 
                    v-for="layerId in activeLayers" 
                    :key="layerId"
                    class="layer-image-container"
                  >
                    <img 
                      v-if="getLayerImage(layerId, view.id)" 
                      :src="getLayerImage(layerId, view.id)" 
                      :alt="getLayerName(layerId)"
                      class="layer-image"
                    />
                  </div>
                </div>
              </div>
            </div>
            
            <div class="view-selector">
              <button 
                v-for="view in activeProduct.views" 
                :key="view.id"
                class="view-button"
                :class="{ 'is-active': view.id === activeView }"
                @click="changeView(view.id)"
              >
                <img 
                  v-if="view.thumbnail" 
                  :src="view.thumbnail" 
                  :alt="view.name"
                  class="view-thumbnail"
                />
                <span v-else class="view-name">{{ view.name }}</span>
              </button>
            </div>
          </div>
          
          <div class="controls-panel">
            <transition name="fade-slide" mode="out-in">
              <div v-if="currentStep === 'configure'" key="configure">
                <div class="controls-accordion">
                  <h3 class="controls-title">Customize Your Product</h3>
                  
                  <div class="accordion">
                    <div 
                      v-for="category in activeProduct.categories" 
                      :key="category.id"
                      class="accordion-item"
                      :class="{ 'is-active': activeCategories.includes(category.id) }"
                    >
                      <div 
                        class="accordion-header"
                        @click="toggleCategory(category.id)"
                      >
                        <span class="category-name">{{ category.name }}</span>
                        <span class="category-icon">
                          <svg v-if="activeCategories.includes(category.id)" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                          <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </span>
                      </div>
                      
                      <div 
                        v-if="activeCategories.includes(category.id)"
                        class="accordion-content"
                      >
                        <div class="controls-grid">
                          <div 
                            v-for="layer in getCategoryLayers(category.id)" 
                            :key="layer.id"
                            class="control-item"
                            :class="{ 'is-active': isLayerActive(layer.id) }"
                            @click="toggleLayer(layer.id)"
                          >
                            <div class="control-item-inner">
                              <div v-if="layer.type === 'color'" 
                                  class="control-color" 
                                  :style="{ backgroundColor: layer.color }">
                              </div>
                              <img 
                                v-else-if="layer.thumbnail" 
                                :src="layer.thumbnail" 
                                :alt="layer.name"
                                class="control-thumbnail"
                              />
                              <div v-else class="control-placeholder">
                                <span>{{ layer.name.charAt(0) }}</span>
                              </div>
                            </div>
                            
                            <div class="control-info">
                              <span class="control-name">{{ layer.name }}</span>
                              <span v-if="layer.price > 0" class="control-price">
                                +{{ formatPrice(layer.price) }}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div v-else-if="currentStep === 'quote'" key="quote">
                <div class="summary-container">
                  <h3 class="summary-title">Your Configuration Summary</h3>
                  
                  <div class="summary-content">
                    <div v-if="basePrice > 0" class="summary-item base-price">
                      <span class="item-name">Base Price</span>
                      <span class="item-price">{{ formatPrice(basePrice) }}</span>
                    </div>
                    
                    <div 
                      v-for="(category, categoryId) in summaryData" 
                      :key="categoryId"
                      class="summary-category"
                    >
                      <div class="category-header">
                        <h4 class="category-title">{{ category.title }}</h4>
                        <span v-if="category.price > 0" class="category-price">
                          {{ formatPrice(category.price) }}
                        </span>
                      </div>
                      
                      <ul class="category-items">
                        <li 
                          v-for="item in category.items" 
                          :key="item.id"
                          class="category-item"
                        >
                          <span class="item-name">{{ item.name }}</span>
                          <span v-if="item.price > 0" class="item-price">
                            {{ formatPrice(item.price) }}
                          </span>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="summary-total">
                      <span class="total-label">Total Price</span>
                      <span class="total-price">{{ formatPrice(totalPrice) }}</span>
                    </div>
                  </div>
                </div>
                
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
                      />
                    </div>
                    
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input 
                        id="email"
                        type="email"
                        v-model="formData.email"
                        placeholder="Enter your email address"
                        required
                      />
                    </div>
                    
                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input 
                        id="phone"
                        type="tel"
                        v-model="formData.phone"
                        placeholder="Enter your phone number"
                      />
                    </div>
                    
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea 
                        id="message"
                        v-model="formData.message"
                        placeholder="Tell us about your requirements"
                        rows="4"
                      ></textarea>
                    </div>
                    
                    <div class="form-group checkbox-group">
                      <div class="checkbox-wrapper">
                        <input 
                          id="gdpr"
                          type="checkbox"
                          v-model="formData.gdpr"
                          required
                        />
                        <label for="gdpr" class="checkbox-label">
                          I agree to the terms and conditions and privacy policy
                        </label>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
              <div v-else-if="currentStep === 'confirmation'" key="confirmation">
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
                </div>
              </div>
            </transition>
            
            <div class="action-buttons">
              <button 
                v-if="currentStep === 'configure'" 
                class="btn btn-primary"
                @click="proceedToQuote"
              >
                Get a Quote
              </button>
              
              <button 
                v-if="currentStep === 'quote'" 
                class="btn btn-secondary"
                @click="backToConfigure"
              >
                Back to Configure
              </button>
              
              <button 
                v-if="currentStep === 'quote'" 
                class="btn btn-primary"
                @click="submitQuote"
                :disabled="isSubmitting"
              >
                <span v-if="isSubmitting">Submitting...</span>
                <span v-else>Submit Quote Request</span>
              </button>
              
              <button 
                v-if="currentStep === 'confirmation'" 
                class="btn btn-secondary"
                @click="startNewConfiguration"
              >
                Start a New Configuration
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <footer class="app-footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-company">
            <div class="footer-logo">
              <img src="./assets/images/logo.svg" alt="Configurator" class="logo-image" />
              <span class="logo-text">Configurator</span>
            </div>
            <p class="company-description">
              Create custom products with our advanced configurator tool.
              Design, visualize, and order your perfect product.
            </p>
          </div>
          
          <div class="footer-links">
            <div class="footer-links-column">
              <h3 class="footer-heading">Products</h3>
              <ul class="footer-menu">
                <li><a href="#">Furniture</a></li>
                <li><a href="#">Clothing</a></li>
                <li><a href="#">Electronics</a></li>
                <li><a href="#">Custom Items</a></li>
              </ul>
            </div>
            
            <div class="footer-links-column">
              <h3 class="footer-heading">Company</h3>
              <ul class="footer-menu">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
            
            <div class="footer-links-column">
              <h3 class="footer-heading">Support</h3>
              <ul class="footer-menu">
                <li><a href="#">Help Center</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Shipping</a></li>
                <li><a href="#">Returns</a></li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="footer-bottom">
          <p class="copyright">
            &copy; {{ currentYear }} Configurator. All rights reserved.
          </p>
          
          <div class="footer-social">
            <a href="#" class="social-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>
            <a href="#" class="social-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
            </a>
            <a href="#" class="social-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import { ref, reactive, computed, onMounted } from 'vue'
import { useStore } from 'vuex'

export default {
  setup() {
    const store = useStore()
    
    // Load configurators when component is created
    onMounted(() => {
      store.dispatch('fetchConfigurators')
    })
    
    // Reactive state
    const activeCategories = ref([])
    const isSubmitting = ref(false)
    const formData = reactive({
      name: '',
      email: '',
      phone: '',
      message: '',
      gdpr: false
    })
    
    // Computed properties
    const activeProduct = computed(() => store.state.activeProduct)
    const activeView = computed(() => store.state.activeView)
    const activeLayers = computed(() => store.state.activeLayers)
    const basePrice = computed(() => store.state.basePrice)
    const totalPrice = computed(() => store.state.totalPrice)
    const formattedPrice = computed(() => store.getters.formattedPrice)
    const currentStep = computed(() => store.state.currentStep)
    const configurators = computed(() => store.state.configurators)
    const summaryData = computed(() => store.state.summaryData)
    const notifications = computed(() => store.state.notifications)
    const currentYear = computed(() => new Date().getFullYear())
    
    // Methods
    const selectProduct = (product) => {
      store.commit('setActiveProduct', product)
      
      // If there are categories, open the first one by default
      if (product.categories && product.categories.length > 0) {
        activeCategories.value = [product.categories[0].id]
      }
    }
    
    const changeView = (viewId) => {
      store.commit('setActiveView', viewId)
    }
    
    const toggleCategory = (categoryId) => {
      const index = activeCategories.value.indexOf(categoryId)
      if (index === -1) {
        activeCategories.value.push(categoryId)
      } else {
        activeCategories.value.splice(index, 1)
      }
    }
    
    const toggleLayer = (layerId) => {
      store.commit('toggleLayer', layerId)
    }
    
    const isLayerActive = (layerId) => {
      return activeLayers.value.includes(layerId)
    }
    
    const getCategoryLayers = (categoryId) => {
      return activeProduct.value.layers.filter(layer => layer.categoryId === categoryId)
    }
    
    const getLayerImage = (layerId, viewId) => {
      const layer = activeProduct.value.layers.find(l => l.id === layerId)
      if (!layer || !layer.views) return null
      
      const viewImage = layer.views[viewId]
      return viewImage || null
    }
    
    const getLayerName = (layerId) => {
      const layer = activeProduct.value.layers.find(l => l.id === layerId)
      return layer ? layer.name : ''
    }
    
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price)
    }
    
    const proceedToQuote = () => {
      store.commit('buildSummaryData')
      store.commit('setCurrentStep', 'quote')
    }
    
    const backToConfigure = () => {
      store.commit('setCurrentStep', 'configure')
    }
    
    const submitForm = () => {
      // Update user info in store
      Object.keys(formData).forEach(key => {
        if (key !== 'gdpr') {
          store.commit('updateUserInfo', { field: key, value: formData[key] })
        }
      })
      
      submitQuote()
    }
    
    const submitQuote = () => {
      isSubmitting.value = true
      store.dispatch('submitQuote').finally(() => {
        isSubmitting.value = false
      })
    }
    
    const startNewConfiguration = () => {
      store.commit('setActiveProduct', null)
      store.commit('setCurrentStep', 'configure')
      activeCategories.value = []
    }
    
    const getNotificationClass = (type) => {
      switch (type) {
        case 'success':
          return 'is-success'
        case 'error':
          return 'is-error'
        case 'warning':
          return 'is-warning'
        default:
          return 'is-info'
      }
    }
    
    const dismissNotification = (id) => {
      store.commit('removeNotification', id)
    }
    
    return {
      activeProduct,
      activeView,
      activeLayers,
      basePrice,
      totalPrice,
      formattedPrice,
      currentStep,
      configurators,
      summaryData,
      notifications,
      currentYear,
      activeCategories,
      formData,
      isSubmitting,
      selectProduct,
      changeView,
      toggleCategory,
      toggleLayer,
      isLayerActive,
      getCategoryLayers,
      getLayerImage,
      getLayerName,
      formatPrice,
      proceedToQuote,
      backToConfigure,
      submitForm,
      submitQuote,
      startNewConfiguration,
      getNotificationClass,
      dismissNotification
    }
  }
}
</script>

<style>
/* App Header */
.app-header {
  background-color: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  width: 100%;
  z-index: 100;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 64px;
}

.logo {
  display: flex;
  align-items: center;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  color: #1e293b;
}

.logo-image {
  height: 32px;
  width: auto;
}

.logo-text {
  font-weight: 700;
  font-size: 1.25rem;
}

.main-nav {
  display: none;
}

.nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: #475569;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9375rem;
  transition: color 0.2s ease;
  padding: 0.5rem 0;
}

.nav-link:hover {
  color: #2563eb;
}

@media (min-width: 768px) {
  .main-nav {
    display: block;
  }
}

/* Notifications */
.notifications-container {
  position: fixed;
  top: 1.5rem;
  right: 1.5rem;
  z-index: 9999;
  width: 320px;
  max-width: calc(100vw - 3rem);
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.notification {
  background-color: #fff;
  border-radius: 6px;
  padding: 1rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: flex-start;
  border-left: 4px solid #64748b;
}

.notification.is-success {
  border-left-color: #10b981;
}

.notification.is-error {
  border-left-color: #ef4444;
}

.notification.is-warning {
  border-left-color: #f59e0b;
}

.notification.is-info {
  border-left-color: #3b82f6;
}

.notification-content {
  display: flex;
  flex-grow: 1;
}

.notification-icon {
  margin-right: 0.75rem;
  color: #64748b;
}

.is-success .notification-icon {
  color: #10b981;
}

.is-error .notification-icon {
  color: #ef4444;
}

.is-warning .notification-icon {
  color: #f59e0b;
}

.is-info .notification-icon {
  color: #3b82f6;
}

.notification-message {
  font-size: 0.875rem;
  color: #0f172a;
  line-height: 1.5;
}

.notification-close {
  background: none;
  border: none;
  padding: 0.25rem;
  margin-left: 0.5rem;
  cursor: pointer;
  color: #94a3b8;
  transition: color 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-close:hover {
  color: #475569;
}

/* Product Card */
.product-card {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
  position: relative;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
}

.product-image {
  height: 200px;
  width: 100%;
  background-color: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
  transform: scale(1.05);
}

.product-placeholder {
  width: 80px;
  height: 80px;
  background-color: #e2e8f0;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  font-weight: 700;
  color: #64748b;
}

.product-info {
  padding: 1.25rem;
}

.product-name {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 0.5rem 0;
}

.product-description {
  font-size: 0.875rem;
  color: #64748b;
  margin: 0 0 1rem 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-meta {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.product-price {
  font-weight: 600;
  color: #2563eb;
}

.product-tag {
  background-color: #10b981;
  color: white;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
}

.product-configure-btn {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 0.75rem;
  background-color: #2563eb;
  color: white;
  border: none;
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  transform: translateY(100%);
  transition: transform 0.3s ease;
}

.product-card:hover .product-configure-btn {
  transform: translateY(0);
}

/* Configurator Header */
.configurator-header {
  padding: 1.5rem;
  background-color: #fff;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.product-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.product-description {
  margin: 0.5rem 0 0 0;
  color: #64748b;
  font-size: 0.875rem;
  max-width: 40ch;
}

.price-display {
  background-color: #f1f5f9;
  padding: 0.75rem 1.25rem;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.price-label {
  font-size: 0.75rem;
  color: #64748b;
  margin-bottom: 0.25rem;
}

.price-value {
  font-size: 1.25rem;
  font-weight: 700;
  color: #2563eb;
}

/* Preview Panel */
.preview-container {
  width: 100%;
  height: 100%;
  overflow: hidden;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.preview-view {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.preview-view.is-active {
  opacity: 1;
  visibility: visible;
}

.base-image-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.base-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.layer-images-container {
  position: relative;
  width: 100%;
  height: 100%;
}

.layer-image-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.layer-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

/* View Selector */
.view-selector {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  padding: 1rem;
  position: absolute;
  bottom: 1rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 5;
  background-color: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(4px);
  border-radius: 999px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.view-button {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 2px solid transparent;
  overflow: hidden;
  padding: 0;
  cursor: pointer;
  transition: all 0.2s ease;
  background-color: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
}

.view-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.view-button.is-active {
  border-color: #2563eb;
  transform: scale(1.1);
  box-shadow: 0 2px 12px rgba(37, 99, 235, 0.2);
}

.view-thumbnail {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.view-name {
  font-size: 0.75rem;
  font-weight: 600;
  color: #334155;
}

/* Controls Accordion */
.controls-accordion {
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
  padding: 1rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.controls-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  color: #1e293b;
}

.accordion {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.accordion-item {
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  overflow: hidden;
  transition: all 0.2s ease;
}

.accordion-item.is-active {
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.accordion-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #f8fafc;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.accordion-header:hover {
  background-color: #f1f5f9;
}

.category-name {
  font-weight: 600;
  color: #334155;
}

.category-icon {
  color: #64748b;
  transition: transform 0.2s ease;
}

.accordion-item.is-active .category-icon {
  transform: rotate(180deg);
}

.accordion-content {
  padding: 1rem;
  background-color: #fff;
  border-top: 1px solid #e2e8f0;
}

.controls-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 1rem;
}

.control-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.control-item:hover {
  transform: translateY(-2px);
}

.control-item.is-active .control-item-inner {
  border-color: #2563eb;
  box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
}

.control-item-inner {
  width: 64px;
  height: 64px;
  border-radius: 8px;
  border: 2px solid #e2e8f0;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.5rem;
  background-color: #f8fafc;
  transition: all 0.2s ease;
}

.control-color {
  width: 100%;
  height: 100%;
}

.control-thumbnail {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.control-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #e2e8f0;
  color: #64748b;
  font-weight: 600;
  font-size: 1.5rem;
}

.control-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.control-name {
  font-size: 0.875rem;
  color: #334155;
  margin-bottom: 0.25rem;
}

.control-price {
  font-size: 0.75rem;
  font-weight: 600;
  color: #0ea5e9;
}

/* Summary */
.summary-container {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  margin-bottom: 1.5rem;
}

.summary-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 1.5rem 0;
}

.summary-content {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
  border-bottom: 1px solid #e2e8f0;
}

.base-price {
  font-weight: 500;
}

.summary-category {
  margin-bottom: 1rem;
}

.category-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.category-title {
  font-size: 1rem;
  font-weight: 600;
  color: #334155;
  margin: 0;
}

.category-price {
  font-weight: 600;
  color: #64748b;
}

.category-items {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.category-item {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0 0.5rem 1rem;
  font-size: 0.875rem;
  position: relative;
}

.category-item::before {
  content: '';
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 4px;
  height: 4px;
  border-radius: 50%;
  background-color: #94a3b8;
}

.item-name {
  color: #475569;
}

.item-price {
  color: #64748b;
  font-weight: 500;
}

.summary-total {
  display: flex;
  justify-content: space-between;
  padding: 1rem 0;
  margin-top: 1rem;
  border-top: 2px solid #e2e8f0;
  font-weight: 600;
}

.total-label {
  font-size: 1.125rem;
  color: #0f172a;
}

.total-price {
  font-size: 1.25rem;
  color: #2563eb;
}

/* Quote Form */
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

/* Confirmation */
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

/* Footer */
.app-footer {
  background-color: #f8fafc;
  padding: 3rem 0 1.5rem;
  margin-top: 3rem;
  border-top: 1px solid #e2e8f0;
}

.footer-content {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.company-description {
  font-size: 0.875rem;
  color: #64748b;
  max-width: 300px;
}

.footer-links {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.footer-heading {
  font-size: 1rem;
  font-weight: 600;
  color: #334155;
  margin: 0 0 1.25rem 0;
}

.footer-menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-menu li {
  margin-bottom: 0.75rem;
}

.footer-menu a {
  color: #64748b;
  text-decoration: none;
  font-size: 0.875rem;
  transition: color 0.2s ease;
}

.footer-menu a:hover {
  color: #2563eb;
}

.footer-bottom {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e2e8f0;
}

.copyright {
  font-size: 0.875rem;
  color: #94a3b8;
  margin: 0;
}

.footer-social {
  display: flex;
  gap: 1.25rem;
}

.social-link {
  color: #64748b;
  transition: color 0.2s ease;
}

.social-link:hover {
  color: #2563eb;
}

@media (min-width: 768px) {
  .footer-content {
    grid-template-columns: 1fr 2fr;
  }
  
  .footer-links {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .footer-bottom {
    flex-direction: row;
    justify-content: space-between;
  }
}
</style>