<template>
  <header class="configurator-header">
    <div class="product-info">
      <h1 class="product-title">{{ product.name }}</h1>
      <p v-if="product.description" class="product-description">
        {{ product.description }}
      </p>
    </div>
    
    <div class="price-display">
      <span class="price-label">Total Price:</span>
      <span class="price-value">{{ totalPrice }}</span>
    </div>
  </header>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    totalPrice: {
      type: String,
      required: true
    }
  }
}
</script>

<style scoped>
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

@media (max-width: 640px) {
  .configurator-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .price-display {
    width: 100%;
    align-items: center;
  }
}
</style>