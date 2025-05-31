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
          title="Zoom"
        >
          <svg v-if="isZoomed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3"></path><path d="M21 8h-3a2 2 0 0 1-2-2V3"></path><path d="M3 16h3a2 2 0 0 1 2 2v3"></path><path d="M16 21v-3a2 2 0 0 1 2-2h3"></path></svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"></polyline><polyline points="9 21 3 21 3 15"></polyline><line x1="21" y1="3" x2="14" y2="10"></line><line x1="3" y1="21" x2="10" y2="14"></line></svg>
        </button>
        
        <button 
          v-if="isSaveEnabled"
          @click="saveImage" 
          class="preview-control-btn save-btn"
          title="Save Image"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        </button>
        
        <button 
          v-if="isShareEnabled"
          @click="shareConfiguration" 
          class="preview-control-btn share-btn"
          title="Share Configuration"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
        </button>
      </div>
    </div>
    
    <!-- Share Modal -->
    <div v-if="showShareModal" class="share-modal-overlay" @click="showShareModal = false">
      <div class="share-modal" @click.stop>
        <div class="share-modal-header">
          <h3>Share Your Configuration</h3>
          <button class="share-modal-close" @click="showShareModal = false">×</button>
        </div>
        
        <div class="share-modal-body">
          <p>Share this unique configuration with others:</p>
          
          <div class="share-link-container">
            <input 
              type="text" 
              readonly 
              :value="shareUrl" 
              class="share-link-input"
              ref="shareLinkInput"
            />
            <button class="btn btn-primary" @click="copyShareLink">
              {{ linkCopied ? 'Copied!' : 'Copy Link' }}
            </button>
          </div>
          
          <div class="share-social">
            <p>Or share directly:</p>
            <div class="share-social-buttons">
              <a :href="facebookShareUrl" target="_blank" class="share-social-button facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                Facebook
              </a>
              
              <a :href="twitterShareUrl" target="_blank" class="share-social-button twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                Twitter
              </a>
              
              <a :href="emailShareUrl" class="share-social-button email">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                Email
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue';
import html2canvas from 'html2canvas';

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
    },
    isShareEnabled: {
      type: Boolean,
      default: true
    }
  },
  
  setup(props) {
    // Refs
    const previewContainer = ref(null);
    const isZoomed = ref(false);
    const loading = ref(true);
    const loadedImages = ref(0);
    const totalImages = ref(0);
    const showShareModal = ref(false);
    const shareLinkInput = ref(null);
    const linkCopied = ref(false);
    
    // Computed
    const totalExpectedImages = computed(() => {
      // Base image + layer images for active layers
      return props.product.views.length + props.activeLayers.length * props.product.views.length;
    });
    
    const shareUrl = computed(() => {
      // In a real app, this would generate a unique URL with the configuration encoded
      const baseUrl = window.location.origin;
      const productId = props.product.id;
      const layersParam = props.activeLayers.join(',');
      
      return `${baseUrl}?product=${productId}&config=${layersParam}`;
    });
    
    const facebookShareUrl = computed(() => {
      return `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl.value)}`;
    });
    
    const twitterShareUrl = computed(() => {
      const text = `Check out my custom ${props.product.name} configuration!`;
      return `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(shareUrl.value)}`;
    });
    
    const emailShareUrl = computed(() => {
      const subject = `My Custom ${props.product.name} Configuration`;
      const body = `Check out my custom configuration: ${shareUrl.value}`;
      return `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    });
    
    // Watch for changes in product or active layers
    watch([() => props.product, () => props.activeLayers], () => {
      loading.value = true;
      loadedImages.value = 0;
    });
    
    // Methods
    const getLayerImage = (layerId, viewId) => {
      const layer = props.product.layers.find(l => l.id === layerId);
      if (!layer || !layer.views) return null;
      
      const viewImage = layer.views[viewId];
      return viewImage || null;
    };
    
    const getLayerName = (layerId) => {
      const layer = props.product.layers.find(l => l.id === layerId);
      return layer ? layer.name : '';
    };
    
    const getLayerStyle = (layerId, viewId) => {
      const layer = props.product.layers.find(l => l.id === layerId);
      if (!layer || !layer.viewStyles || !layer.viewStyles[viewId]) return {};
      
      return layer.viewStyles[viewId];
    };
    
    const toggleZoom = () => {
      isZoomed.value = !isZoomed.value;
      
      if (isZoomed.value) {
        previewContainer.value.classList.add('zoomed');
        enableZoomPan();
      } else {
        previewContainer.value.classList.remove('zoomed');
        disableZoomPan();
      }
    };
    
    const enableZoomPan = () => {
      // Implement zoom and pan functionality
      // This is a simplified version, in a real application,
      // you would use a library like panzoom or implement more robust handling
      
      const container = previewContainer.value;
      let isDragging = false;
      let startX, startY;
      let scrollLeft, scrollTop;
      
      const onMouseDown = (e) => {
        isDragging = true;
        container.style.cursor = 'grabbing';
        startX = e.pageX - container.offsetLeft;
        startY = e.pageY - container.offsetTop;
        scrollLeft = container.scrollLeft;
        scrollTop = container.scrollTop;
      };
      
      const onMouseMove = (e) => {
        if (!isDragging) return;
        e.preventDefault();
        
        const x = e.pageX - container.offsetLeft;
        const y = e.pageY - container.offsetTop;
        const walkX = (x - startX) * 2;
        const walkY = (y - startY) * 2;
        
        container.scrollLeft = scrollLeft - walkX;
        container.scrollTop = scrollTop - walkY;
      };
      
      const onMouseUp = () => {
        isDragging = false;
        container.style.cursor = 'grab';
      };
      
      container.addEventListener('mousedown', onMouseDown);
      container.addEventListener('mousemove', onMouseMove);
      container.addEventListener('mouseup', onMouseUp);
      container.addEventListener('mouseleave', onMouseUp);
      
      // Store event handlers for cleanup
      container._zoomHandlers = {
        onMouseDown,
        onMouseMove,
        onMouseUp
      };
    };
    
    const disableZoomPan = () => {
      const container = previewContainer.value;
      if (!container || !container._zoomHandlers) return;
      
      const { onMouseDown, onMouseMove, onMouseUp } = container._zoomHandlers;
      
      container.removeEventListener('mousedown', onMouseDown);
      container.removeEventListener('mousemove', onMouseMove);
      container.removeEventListener('mouseup', onMouseUp);
      container.removeEventListener('mouseleave', onMouseUp);
      
      container.style.cursor = 'default';
    };
    
    const saveImage = async () => {
      try {
        const activeViewElement = previewContainer.value.querySelector('.preview-view.is-active');
        
        if (!activeViewElement) return;
        
        // Hide controls before capturing
        const controls = previewContainer.value.querySelector('.preview-controls');
        if (controls) controls.style.display = 'none';
        
        const canvas = await html2canvas(activeViewElement, {
          backgroundColor: null,
          scale: 2, // Higher quality
          logging: false,
          useCORS: true
        });
        
        // Show controls again
        if (controls) controls.style.display = '';
        
        // Create download link
        const link = document.createElement('a');
        link.download = `${props.product.name.replace(/\s+/g, '-').toLowerCase()}-configuration.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
      } catch (error) {
        console.error('Error saving image:', error);
        alert('Failed to save image. Please try again.');
      }
    };
    
    const shareConfiguration = () => {
      showShareModal.value = true;
      
      // Focus and select the share link input after the modal is shown
      setTimeout(() => {
        if (shareLinkInput.value) {
          shareLinkInput.value.focus();
          shareLinkInput.value.select();
        }
      }, 100);
    };
    
    const copyShareLink = () => {
      if (!shareLinkInput.value) return;
      
      shareLinkInput.value.select();
      document.execCommand('copy');
      
      linkCopied.value = true;
      setTimeout(() => {
        linkCopied.value = false;
      }, 2000);
    };
    
    const handleImageLoad = () => {
      loadedImages.value++;
      if (loadedImages.value >= totalExpectedImages.value) {
        loading.value = false;
      }
    };
    
    onMounted(() => {
      // Reset loading state when component is mounted
      loading.value = true;
      loadedImages.value = 0;
    });
    
    return {
      previewContainer,
      isZoomed,
      loading,
      showShareModal,
      shareLinkInput,
      linkCopied,
      shareUrl,
      facebookShareUrl,
      twitterShareUrl,
      emailShareUrl,
      getLayerImage,
      getLayerName,
      getLayerStyle,
      toggleZoom,
      saveImage,
      shareConfiguration,
      copyShareLink,
      handleImageLoad
    };
  }
};
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

/* Share Modal */
.share-modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.share-modal {
  background-color: white;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.share-modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.share-modal-header h3 {
  margin: 0;
  font-size: 1.25rem;
}

.share-modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #64748b;
}

.share-modal-body {
  padding: 1.5rem;
}

.share-link-container {
  display: flex;
  margin: 1rem 0;
}

.share-link-input {
  flex-grow: 1;
  padding: 0.75rem;
  border: 1px solid #cbd5e1;
  border-right: none;
  border-radius: 6px 0 0 6px;
  font-size: 0.875rem;
  color: #0f172a;
  background-color: #f8fafc;
}

.share-link-container .btn {
  border-radius: 0 6px 6px 0;
}

.share-social {
  margin-top: 1.5rem;
}

.share-social p {
  margin-bottom: 1rem;
}

.share-social-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.share-social-button {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.875rem;
  text-decoration: none;
  transition: all 0.2s ease;
}

.share-social-button.facebook {
  background-color: #1877f2;
  color: white;
}

.share-social-button.twitter {
  background-color: #1da1f2;
  color: white;
}

.share-social-button.email {
  background-color: #6b7280;
  color: white;
}

.share-social-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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