import { createApp } from 'vue'
import { createStore } from 'vuex'
import App from './App.vue'
import ConfiguratorPlugin from './plugins/configurator'
import './assets/css/main.css'

// Create Vuex store
const store = createStore({
  state() {
    return {
      activeProduct: null,
      activeView: 'front',
      activeLayers: [],
      basePrice: 0,
      totalPrice: 0,
      priceDetails: true,
      summaryData: {},
      userInfo: {
        name: '',
        email: '',
        phone: '',
        message: ''
      },
      currentStep: 'configure',
      configurators: [],
      notifications: []
    }
  },
  mutations: {
    setActiveProduct(state, product) {
      state.activeProduct = product
      state.basePrice = parseFloat(product.basePrice || 0)
    },
    setActiveView(state, view) {
      state.activeView = view
    },
    toggleLayer(state, layerId) {
      const index = state.activeLayers.indexOf(layerId)
      if (index === -1) {
        state.activeLayers.push(layerId)
      } else {
        state.activeLayers.splice(index, 1)
      }
      this.commit('calculateTotalPrice')
    },
    calculateTotalPrice(state) {
      let total = state.basePrice
      // Calculate price based on active layers
      state.activeLayers.forEach(layerId => {
        const layer = state.activeProduct?.layers.find(l => l.id === layerId)
        if (layer && layer.price) {
          total += parseFloat(layer.price)
        }
      })
      state.totalPrice = total
    },
    updateUserInfo(state, { field, value }) {
      state.userInfo[field] = value
    },
    setCurrentStep(state, step) {
      state.currentStep = step
    },
    setConfigurators(state, configurators) {
      state.configurators = configurators
    },
    addNotification(state, { message, type = 'info' }) {
      state.notifications.push({
        id: Date.now(),
        message,
        type
      })
    },
    removeNotification(state, id) {
      state.notifications = state.notifications.filter(n => n.id !== id)
    },
    buildSummaryData(state) {
      const summary = {}
      
      state.activeLayers.forEach(layerId => {
        const layer = state.activeProduct?.layers.find(l => l.id === layerId)
        if (!layer) return
        
        const categoryId = layer.categoryId
        if (!summary[categoryId]) {
          const category = state.activeProduct?.categories.find(c => c.id === categoryId)
          summary[categoryId] = {
            title: category?.name || 'Other',
            items: [],
            price: 0
          }
        }
        
        summary[categoryId].items.push({
          id: layer.id,
          name: layer.name,
          price: layer.price || 0
        })
        
        summary[categoryId].price += parseFloat(layer.price || 0)
      })
      
      state.summaryData = summary
    }
  },
  actions: {
    async fetchConfigurators({ commit }) {
      try {
        // In a real implementation, this would be an API call
        const response = await fetch('/api/configurators')
        const data = await response.json()
        commit('setConfigurators', data)
      } catch (error) {
        commit('addNotification', { 
          message: 'Failed to load configurators', 
          type: 'error' 
        })
      }
    },
    async submitQuote({ commit, state }) {
      try {
        // In a real implementation, this would be an API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        commit('addNotification', { 
          message: 'Quote submitted successfully!', 
          type: 'success' 
        })
        
        commit('setCurrentStep', 'confirmation')
      } catch (error) {
        commit('addNotification', { 
          message: 'Failed to submit quote', 
          type: 'error' 
        })
      }
    }
  },
  getters: {
    formattedPrice: state => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(state.totalPrice)
    },
    activeLayersByCategory: state => {
      const result = {}
      state.activeLayers.forEach(layerId => {
        const layer = state.activeProduct?.layers.find(l => l.id === layerId)
        if (layer) {
          const catId = layer.categoryId
          if (!result[catId]) result[catId] = []
          result[catId].push(layer)
        }
      })
      return result
    }
  }
})

// Create Vue app
const app = createApp(App)

// Register configurator plugin
app.use(ConfiguratorPlugin)

// Use Vuex store
app.use(store)

// Mount app
app.mount('#configurator-app')