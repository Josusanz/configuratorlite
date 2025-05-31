<template>
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
</template>

<script>
export default {
  props: {
    summaryData: {
      type: Object,
      default: () => ({})
    },
    basePrice: {
      type: Number,
      default: 0
    },
    totalPrice: {
      type: Number,
      default: 0
    }
  },
  
  setup() {
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price)
    }
    
    return {
      formatPrice
    }
  }
}
</script>

<style scoped>
.summary-container {
  padding: 1.5rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
</style>