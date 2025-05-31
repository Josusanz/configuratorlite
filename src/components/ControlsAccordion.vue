<template>
  <div class="controls-accordion">
    <h3 class="controls-title">Customize Your Product</h3>
    
    <div class="accordion">
      <div 
        v-for="category in product.categories" 
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
        
        <transition name="accordion">
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
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'

export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    activeLayers: {
      type: Array,
      default: () => []
    }
  },
  
  emits: ['toggle-layer'],
  
  setup(props, { emit }) {
    // State
    const activeCategories = ref([])
    
    // If there are categories, open the first one by default
    if (props.product.categories && props.product.categories.length > 0) {
      activeCategories.value = [props.product.categories[0].id]
    }
    
    // Methods
    const toggleCategory = (categoryId) => {
      const index = activeCategories.value.indexOf(categoryId)
      if (index === -1) {
        activeCategories.value.push(categoryId)
      } else {
        activeCategories.value.splice(index, 1)
      }
    }
    
    const toggleLayer = (layerId) => {
      emit('toggle-layer', layerId)
    }
    
    const isLayerActive = (layerId) => {
      return props.activeLayers.includes(layerId)
    }
    
    const getCategoryLayers = (categoryId) => {
      return props.product.layers.filter(layer => layer.categoryId === categoryId)
    }
    
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price)
    }
    
    return {
      activeCategories,
      toggleCategory,
      toggleLayer,
      isLayerActive,
      getCategoryLayers,
      formatPrice
    }
  }
}
</script>

<style scoped>
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

/* Animations */
.accordion-enter-active,
.accordion-leave-active {
  transition: max-height 0.3s ease, opacity 0.3s ease;
  max-height: 1000px;
  overflow: hidden;
}

.accordion-enter-from,
.accordion-leave-to {
  max-height: 0;
  opacity: 0;
}
</style>