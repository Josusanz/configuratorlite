import { createApp } from 'vue'
import { createStore } from 'vuex'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import Admin from './views/Admin.vue'
import './assets/css/main.css'

// Create router
const routes = [
  {
    path: '/',
    name: 'Home',
    component: App
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Create Vuex store
const store = createStore({
  state() {
    return {
      activeProduct: null,
      activeView: 'front',
      activeLayers: [],
      basePrice: 0,
      totalPrice: 0,
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
      state.activeLayers = [] // Reset active layers when changing product
      this.commit('calculateTotalPrice')
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
        // For now, we'll use mock data
        const mockData = [
          {
            id: 'chair-001',
            name: 'Modern Office Chair',
            thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
            shortDescription: 'Ergonomic office chair with customizable features',
            description: 'Our premium office chair offers exceptional comfort and support for long work days. Customize every aspect to create your perfect seating solution.',
            basePrice: 299,
            isNew: true,
            views: [
              {
                id: 'front',
                name: 'Front',
                baseImage: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600'
              },
              {
                id: 'side',
                name: 'Side',
                baseImage: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600',
                thumbnail: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
              }
            ],
            categories: [
              { id: 'frame', name: 'Frame' },
              { id: 'seat', name: 'Seat Material' },
              { id: 'color', name: 'Color' },
              { id: 'extras', name: 'Extras' }
            ],
            layers: [
              {
                id: 'frame-standard',
                name: 'Standard Frame',
                categoryId: 'frame',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'frame-premium',
                name: 'Premium Aluminum Frame',
                categoryId: 'frame',
                price: 50,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'seat-fabric',
                name: 'Fabric Seat',
                categoryId: 'seat',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'seat-leather',
                name: 'Leather Seat',
                categoryId: 'seat',
                price: 100,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'color-black',
                name: 'Black',
                categoryId: 'color',
                type: 'color',
                color: '#000000',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'color-gray',
                name: 'Gray',
                categoryId: 'color',
                type: 'color',
                color: '#808080',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'color-blue',
                name: 'Blue',
                categoryId: 'color',
                type: 'color',
                color: '#0000FF',
                price: 20,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-headrest',
                name: 'Headrest',
                categoryId: 'extras',
                price: 30,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-armrest',
                name: 'Adjustable Armrests',
                categoryId: 'extras',
                price: 45,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-lumbar',
                name: 'Lumbar Support',
                categoryId: 'extras',
                price: 25,
                views: {
                  front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
                  side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              }
            ]
          },
          {
            id: 'desk-001',
            name: 'Adjustable Standing Desk',
            thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
            shortDescription: 'Electric standing desk with customizable options',
            description: 'Transform your workspace with our premium adjustable standing desk. Choose from various desktop materials, sizes, and accessories to create your ideal workstation.',
            basePrice: 499,
            isNew: false,
            views: [
              {
                id: 'front',
                name: 'Front',
                baseImage: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600'
              },
              {
                id: 'top',
                name: 'Top',
                baseImage: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600',
                thumbnail: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
              }
            ],
            categories: [
              { id: 'frame', name: 'Frame' },
              { id: 'top', name: 'Desktop Surface' },
              { id: 'size', name: 'Size' },
              { id: 'extras', name: 'Extras' }
            ],
            layers: [
              {
                id: 'frame-standard',
                name: 'Standard Frame',
                categoryId: 'frame',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'frame-premium',
                name: 'Premium Frame',
                categoryId: 'frame',
                price: 100,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'top-laminate',
                name: 'Laminate',
                categoryId: 'top',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'top-bamboo',
                name: 'Bamboo',
                categoryId: 'top',
                price: 150,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'size-small',
                name: 'Small (48")',
                categoryId: 'size',
                price: 0,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'size-medium',
                name: 'Medium (60")',
                categoryId: 'size',
                price: 100,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'size-large',
                name: 'Large (72")',
                categoryId: 'size',
                price: 200,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-cable',
                name: 'Cable Management',
                categoryId: 'extras',
                price: 50,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-wireless',
                name: 'Wireless Charging',
                categoryId: 'extras',
                price: 80,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              },
              {
                id: 'extras-monitor',
                name: 'Monitor Arm',
                categoryId: 'extras',
                price: 120,
                views: {
                  front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
                  top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
                }
              }
            ]
          }
        ];
        
        commit('setConfigurators', mockData)
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

// Use Vuex store
app.use(store)

// Use router
app.use(router)

// Mount app
app.mount('#app')