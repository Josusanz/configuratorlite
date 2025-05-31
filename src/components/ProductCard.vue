<template>
  <div class="product-card" @click="selectProduct">
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
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  
  emits: ['select'],
  
  setup(props, { emit }) {
    const selectProduct = () => {
      emit('select', props.product)
    }
    
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price)
    }
    
    return {
      selectProduct,
      formatPrice
    }
  }
}
</script>

<style scoped>
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
</style>