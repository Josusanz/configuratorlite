<template>
  <div class="admin-view">
    <div class="admin-panel">
      <div class="admin-header">
        <h1>Configurator Admin Panel</h1>
        <div class="admin-tabs">
          <button 
            class="admin-tab" 
            :class="{ 'active': activeTab === 'products' }"
            @click="activeTab = 'products'"
          >
            Products
          </button>
          <button 
            class="admin-tab" 
            :class="{ 'active': activeTab === 'quotes' }"
            @click="activeTab = 'quotes'"
          >
            Quotes
          </button>
        </div>
      </div>
      
      <div class="admin-content">
        <!-- Products Tab -->
        <div v-if="activeTab === 'products'" class="products-panel">
          <div class="panel-header">
            <h2>Manage Products</h2>
            <button class="btn btn-primary" @click="showNewProductForm = true">
              Add New Product
            </button>
          </div>
          
          <div class="products-list">
            <div v-for="product in products" :key="product.id" class="product-item">
              <div class="product-info">
                <img 
                  v-if="product.thumbnail" 
                  :src="product.thumbnail" 
                  :alt="product.name"
                  class="product-thumbnail"
                />
                <div class="product-details">
                  <h3>{{ product.name }}</h3>
                  <p>{{ product.shortDescription }}</p>
                  <div class="product-meta">
                    <span class="product-price">{{ formatPrice(product.basePrice) }}</span>
                    <span v-if="product.isNew" class="product-tag">New</span>
                  </div>
                </div>
              </div>
              
              <div class="product-actions">
                <button class="btn btn-secondary">Edit</button>
                <button class="btn btn-danger">Delete</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Quotes Tab -->
        <div v-if="activeTab === 'quotes'" class="quotes-panel">
          <div class="panel-header">
            <h2>Quote Requests</h2>
          </div>
          
          <div class="quotes-list">
            <div v-for="quote in quotes" :key="quote.id" class="quote-item">
              <div class="quote-header">
                <div class="quote-info">
                  <h3>{{ quote.userInfo.name }}</h3>
                  <p>{{ formatDate(quote.timestamp) }}</p>
                </div>
                <div class="quote-status" :class="quote.status">
                  {{ quote.status }}
                </div>
              </div>
              
              <div class="quote-details">
                <div class="quote-contact">
                  <p><strong>Email:</strong> {{ quote.userInfo.email }}</p>
                  <p v-if="quote.userInfo.phone"><strong>Phone:</strong> {{ quote.userInfo.phone }}</p>
                </div>
                
                <div class="quote-product">
                  <p><strong>Product:</strong> {{ quote.product.name }}</p>
                  <p><strong>Total Price:</strong> {{ formatPrice(quote.totalPrice) }}</p>
                </div>
                
                <div v-if="quote.userInfo.message" class="quote-message">
                  <p><strong>Message:</strong></p>
                  <p>{{ quote.userInfo.message }}</p>
                </div>
              </div>
              
              <div class="quote-actions">
                <select 
                  v-model="quote.status" 
                  class="status-select"
                >
                  <option value="pending">Pending</option>
                  <option value="processing">Processing</option>
                  <option value="completed">Completed</option>
                  <option value="rejected">Rejected</option>
                </select>
                
                <button class="btn btn-primary">
                  View Details
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
  setup() {
    // State
    const activeTab = ref('products');
    const products = ref([]);
    const quotes = ref([]);
    const showNewProductForm = ref(false);
    
    // Mock data for demonstration
    onMounted(() => {
      // Mock products
      products.value = [
        {
          id: 'chair-001',
          name: 'Modern Office Chair',
          thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          shortDescription: 'Ergonomic office chair with customizable features',
          basePrice: 299,
          isNew: true
        },
        {
          id: 'desk-001',
          name: 'Adjustable Standing Desk',
          thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          shortDescription: 'Electric standing desk with customizable options',
          basePrice: 499,
          isNew: false
        }
      ];
      
      // Mock quotes
      quotes.value = [
        {
          id: 'quote-001',
          timestamp: '2023-04-15T10:30:00Z',
          status: 'pending',
          userInfo: {
            name: 'John Doe',
            email: 'john@example.com',
            phone: '555-123-4567',
            message: 'I need this chair for my home office. Can you provide more information about delivery options?'
          },
          product: {
            name: 'Modern Office Chair',
            id: 'chair-001'
          },
          totalPrice: 374
        },
        {
          id: 'quote-002',
          timestamp: '2023-04-14T15:45:00Z',
          status: 'processing',
          userInfo: {
            name: 'Jane Smith',
            email: 'jane@example.com',
            phone: '555-987-6543',
            message: 'Looking for a desk for my new apartment.'
          },
          product: {
            name: 'Adjustable Standing Desk',
            id: 'desk-001'
          },
          totalPrice: 749
        }
      ];
    });
    
    // Methods
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price);
    };
    
    const formatDate = (timestamp) => {
      const date = new Date(timestamp);
      return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date);
    };
    
    return {
      activeTab,
      products,
      quotes,
      showNewProductForm,
      formatPrice,
      formatDate
    };
  }
};
</script>

<style scoped>
.admin-panel {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.admin-header {
  margin-bottom: 2rem;
}

.admin-header h1 {
  margin-bottom: 1rem;
}

.admin-tabs {
  display: flex;
  border-bottom: 1px solid #e2e8f0;
  margin-bottom: 2rem;
}

.admin-tab {
  padding: 0.75rem 1.5rem;
  background: none;
  border: none;
  border-bottom: 2px solid transparent;
  font-weight: 600;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s ease;
}

.admin-tab:hover {
  color: #334155;
}

.admin-tab.active {
  color: #2563eb;
  border-bottom-color: #2563eb;
}

.panel-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.panel-header h2 {
  margin: 0;
}

/* Products List */
.products-list {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

.product-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.product-info {
  display: flex;
  align-items: center;
}

.product-thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 1rem;
}

.product-details h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.125rem;
}

.product-details p {
  margin: 0 0 0.5rem 0;
  color: #64748b;
  font-size: 0.875rem;
}

.product-meta {
  display: flex;
  align-items: center;
  gap: 1rem;
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

.product-actions {
  display: flex;
  gap: 0.5rem;
}

/* Quotes List */
.quotes-list {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
}

.quote-item {
  padding: 1rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.quote-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.quote-info h3 {
  margin: 0 0 0.25rem 0;
  font-size: 1.125rem;
}

.quote-info p {
  margin: 0;
  color: #64748b;
  font-size: 0.75rem;
}

.quote-status {
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.quote-status.pending {
  background-color: #fef3c7;
  color: #d97706;
}

.quote-status.processing {
  background-color: #dbeafe;
  color: #2563eb;
}

.quote-status.completed {
  background-color: #d1fae5;
  color: #10b981;
}

.quote-status.rejected {
  background-color: #fee2e2;
  color: #ef4444;
}

.quote-details {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e2e8f0;
}

.quote-contact p,
.quote-product p {
  margin: 0 0 0.25rem 0;
  font-size: 0.875rem;
}

.quote-message p {
  margin: 0 0 0.5rem 0;
  font-size: 0.875rem;
}

.quote-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.status-select {
  padding: 0.5rem;
  border-radius: 4px;
  border: 1px solid #cbd5e1;
  background-color: white;
}

.btn-danger {
  background-color: #ef4444;
  color: white;
}

.btn-danger:hover {
  background-color: #dc2626;
}

@media (min-width: 768px) {
  .products-list {
    grid-template-columns: repeat(1, 1fr);
  }
  
  .quote-details {
    grid-template-columns: 1fr 1fr;
  }
  
  .quote-message {
    grid-column: span 2;
  }
}
</style>