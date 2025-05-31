<template>
  <div class="configurator-app">
    <AppHeader />
    
    <main class="configurator-main">
      <Notifications />
      
      <div v-if="!activeProduct" class="product-selector">
        <h2>Select a Product to Configure</h2>
        <div class="product-grid">
          <ProductCard 
            v-for="product in configurators" 
            :key="product.id"
            :product="product" 
            @select="selectProduct"
          />
        </div>
      </div>
      
      <div v-else class="configurator-container">
        <ConfiguratorHeader 
          :product="activeProduct" 
          :total-price="formattedPrice" 
        />
        
        <div class="configurator-body">
          <div class="preview-panel">
            <ProductPreview 
              :product="activeProduct" 
              :active-view="activeView"
              :active-layers="activeLayers" 
            />
            <ViewSelector 
              :views="activeProduct.views" 
              :active-view="activeView" 
              @change-view="changeView"
            />
          </div>
          
          <div class="controls-panel">
            <transition name="fade-slide" mode="out-in">
              <div v-if="currentStep === 'configure'" key="configure">
                <ControlsAccordion 
                  :product="activeProduct" 
                  :active-layers="activeLayers"
                  @toggle-layer="toggleLayer" 
                />
              </div>
              
              <div v-else-if="currentStep === 'quote'" key="quote">
                <Summary 
                  :summary-data="summaryData" 
                  :base-price="basePrice"
                  :total-price="totalPrice" 
                />
                <QuoteForm 
                  :user-info="userInfo" 
                  @update-field="updateField"
                  @submit="submitQuote" 
                />
              </div>
              
              <div v-else-if="currentStep === 'confirmation'" key="confirmation">
                <Confirmation />
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
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <AppFooter />
  </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import AppHeader from './components/AppHeader.vue'
import AppFooter from './components/AppFooter.vue'
import Notifications from './components/Notifications.vue'
import ProductCard from './components/ProductCard.vue'
import ConfiguratorHeader from './components/ConfiguratorHeader.vue'
import ProductPreview from './components/ProductPreview.vue'
import ViewSelector from './components/ViewSelector.vue'
import ControlsAccordion from './components/ControlsAccordion.vue'
import Summary from './components/Summary.vue'
import QuoteForm from './components/QuoteForm.vue'
import Confirmation from './components/Confirmation.vue'

export default {
  components: {
    AppHeader,
    AppFooter,
    Notifications,
    ProductCard,
    ConfiguratorHeader,
    ProductPreview,
    ViewSelector,
    ControlsAccordion,
    Summary,
    QuoteForm,
    Confirmation
  },
  setup() {
    const store = useStore()
    
    // Load configurators when component is created
    store.dispatch('fetchConfigurators')
    
    // Computed properties
    const activeProduct = computed(() => store.state.activeProduct)
    const activeView = computed(() => store.state.activeView)
    const activeLayers = computed(() => store.state.activeLayers)
    const basePrice = computed(() => store.state.basePrice)
    const totalPrice = computed(() => store.state.totalPrice)
    const formattedPrice = computed(() => store.getters.formattedPrice)
    const currentStep = computed(() => store.state.currentStep)
    const configurators = computed(() => store.state.configurators)
    const userInfo = computed(() => store.state.userInfo)
    const summaryData = computed(() => store.state.summaryData)
    
    // Methods
    const selectProduct = (product) => {
      store.commit('setActiveProduct', product)
    }
    
    const changeView = (view) => {
      store.commit('setActiveView', view)
    }
    
    const toggleLayer = (layerId) => {
      store.commit('toggleLayer', layerId)
    }
    
    const updateField = ({ field, value }) => {
      store.commit('updateUserInfo', { field, value })
    }
    
    const proceedToQuote = () => {
      store.commit('buildSummaryData')
      store.commit('setCurrentStep', 'quote')
    }
    
    const backToConfigure = () => {
      store.commit('setCurrentStep', 'configure')
    }
    
    const submitQuote = () => {
      store.dispatch('submitQuote')
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
      userInfo,
      summaryData,
      selectProduct,
      changeView,
      toggleLayer,
      updateField,
      proceedToQuote,
      backToConfigure,
      submitQuote
    }
  }
}
</script>