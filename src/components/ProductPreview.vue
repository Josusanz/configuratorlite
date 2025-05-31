<template>
  <div class="product-preview">
    <div class="preview-container" ref="previewContainer">
      <div v-if="loading" class="preview-loading">
        <div class="loading-spinner"></div>
        <span>Loading preview...</span>
      </div>
      
      <div 
        v-for="view in product.views" 
        :key="view.id"
        class="preview-view"
        :class="{ 'is-active': view.id === activeView }"
      >
        <div class="base-image-container">
          <img 
            v-if="view.baseImage" 
            :src="view.baseImage" 
            :alt="product.name" 
            class="base-image"
            @load="handleImageLoad"
          />
        </div>
        
        <transition-group name="fade" tag="div" class="layer-images-container">
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
              :style="getLayerStyle(layerId, view.id)"
              @load="handleImageLoad"
            />
          </div>
        </transition-group>
      </div>
      
      <div class="preview-controls">
        <button 
          v-if="isZoomEnabled"
          @click="toggleZoom" 
          class="preview-control-btn zoom-btn"
          :class="{ 'is-active': isZoomed }"
        >
          <svg v-if="isZoomed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3"></path><path d="M21 8h-3a2 2 0 0 1-2-2V3"></path><path d="M3 16h3a2 2 0 0 1 2 2v3"></path><path d="M16 21v-3a2 2 0 0 1 2-2h3"></path></svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
        </button>
        
        <button 
          v-if="isSaveEnabled"
          @click="saveImage" 
          class="preview-control-btn save-btn"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'

export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    activeView: {
      type: String,
      required: true
    },
    activeLayers: {
      type: Array,
      default: () => []
    },
    isZoomEnabled: {
      type: Boolean,
      default: true
    },
    isSaveEnabled: {
      type: Boolean,
      default: true
    }
  },
  
  setup(props) {
    // Refs
    const previewContainer = ref(null)
    const isZoomed = ref(false)
    const loading = ref(true)
    const loadedImages = ref(0)
    const totalImages = ref(0)
    
    // Computed
    const totalExpectedImages = computed(() => {
      // Base image + layer images for active layers
      return 1 + props.activeLayers.length
    })
    
    // Methods
    const getLayerImage = (layerId, viewId) => {
      const layer = props.product.layers.find(l => l.id === layerId)
      if (!layer || !layer.views) return null
      
      const viewImage = layer.views[viewId]
      return viewImage || null
    }
    
    const getLayerName = (layerId) => {
      const layer = props.product.layers.find(l => l.id === layerId)
      return layer ? layer.name : ''
    }
    
    const getLayerStyle = (layerId, viewId) => {
      const layer = props.product.layers.find(l => l.id === layerId)
      if (!layer || !layer.viewStyles || !layer.viewStyles[viewId]) return {}
      
      return layer.viewStyles[viewId]
    }
    
    const toggleZoom = () => {
      isZoomed.value = !isZoomed.value
      
      if (isZoomed.value) {
        previewContainer.value.classList.add('zoomed')
        enableZoomPan()
      } else {
        previewContainer.value.classList.remove('zoomed')
        disableZoomPan()
      }
    }
    
    const enableZoomPan = () => {
      // Implement zoom and pan functionality
      // This is a simplified version, in a real application,
      // you would use a library like panzoom or implement more robust handling
      
      const container = previewContainer.value
      let isDragging = false
      let startX, startY
      let scrollLeft, scrollTop
      
      const onMouseDown = (e) => {
        isDragging = true
        container.style.cursor = 'grabbing'
        startX = e.pageX - container.offsetLeft
        startY = e.pageY - container.offsetTop
        scrollLeft = container.scrollLeft
        scrollTop = container.scrollTop
      }
      
      const onMouseMove = (e) => {
        if (!isDragging) return
        e.preventDefault()
        
        const x = e.pageX - container.offsetLeft
        const y = e.pageY - container.offsetTop
        const walkX = (x - startX) * 2
        const walkY = (y - startY) * 2
        
        container.scrollLeft = scrollLeft - walkX
        container.scrollTop = scrollTop - walkY
      }
      
      const onMouseUp = () => {
        isDragging = false
        container.style.cursor = 'grab'
      }
      
      container.addEventListener('mousedown', onMouseDown)
      container.addEventListener('mousemove', onMouseMove)
      container.addEventListener('mouseup', onMouseUp)
      container.addEventListener('mouseleave', onMouseUp)
      
      // Store event handlers for cleanup
      container._zoomHandlers = {
        onMouseDown,
        onMouseMove,
        onMouseUp
      }
    }
    
    const disableZoomPan = () => {
      const container = previewContainer.value
      if (!container || !container._zoomHandlers) return
      
      const { onMouseDown, onMouseMove, onMouseUp } = container._zoomHandlers
      
      container.removeEventListener('mousedown', onMouseDown)
      container.removeEventListener('mousemove', onMouseMove)
      container.removeEventListener('mouseup', onMouseUp)
      container.removeEventListener('mouseleave', onMouseUp)
      
      container.style.cursor = 'default'
    }
    
    const saveImage = () => {
      // In a real implementation, this would capture the preview as an image
      // and trigger a download
      alert('Save image functionality would be implemented here')
    }
    
    const handleImageLoad = () => {
      loadedImages.value++
      if (loadedImages.value >= totalExpectedImages.value) {
        loading.value = false
      }
    }
    
    onMounted(() => {
      // Reset loading state when component is mounted
      loading.value = true
      loadedImages.value = 0
    })
    
    return {
      previewContainer,
      isZoomed,
      loading,
      getLayerImage,
      getLayerName,
      getLayerStyle,
      toggleZoom,
      saveImage,
      handleImageLoad
    }
  }
}
</script>

<style scoped>
.product-preview {
  width: 100%;
  height: 100%;
  background-color: #f8fafc;
  border-radius: 8px;
  overflow: hidden;
  position: relative;
}

.preview-container {
  width: 100%;
  height: 100%;
  overflow: hidden;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.preview-container.zoomed {
  cursor: grab;
  overflow: auto;
}

.preview-loading {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 10;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e2e8f0;
  border-radius: 50%;
  border-top-color: #2563eb;
  animation: spin 1s ease-in-out infinite;
  margin-bottom: 1rem;
}

@keyframes spin {
  to { transform: rotate(360deg); }
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

.preview-controls {
  position: absolute;
  bottom: 1rem;
  right: 1rem;
  display: flex;
  gap: 0.5rem;
  z-index: 5;
}

.preview-control-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: white;
  border: none;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #64748b;
  transition: all 0.2s ease;
}

.preview-control-btn:hover {
  background-color: #f1f5f9;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.preview-control-btn.is-active {
  background-color: #2563eb;
  color: white;
}

/* Animations */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>