<template>
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
              <button class="btn btn-secondary" @click="editProduct(product)">Edit</button>
              <button class="btn btn-danger" @click="confirmDeleteProduct(product)">Delete</button>
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
                <p>{{ quote.timestamp | formatDate }}</p>
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
                @change="updateQuoteStatus(quote)"
                class="status-select"
              >
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
              </select>
              
              <button class="btn btn-primary" @click="viewQuoteDetails(quote)">
                View Details
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Product Form Modal -->
    <div v-if="showProductForm" class="modal-overlay">
      <div class="modal-container">
        <div class="modal-header">
          <h2>{{ isEditMode ? 'Edit Product' : 'Add New Product' }}</h2>
          <button class="modal-close" @click="closeProductForm">×</button>
        </div>
        
        <div class="modal-body">
          <form @submit.prevent="saveProduct" class="product-form">
            <div class="form-group">
              <label for="product-name">Product Name</label>
              <input 
                id="product-name"
                v-model="productForm.name"
                type="text"
                required
              />
            </div>
            
            <div class="form-group">
              <label for="product-description">Short Description</label>
              <input 
                id="product-description"
                v-model="productForm.shortDescription"
                type="text"
                required
              />
            </div>
            
            <div class="form-group">
              <label for="product-full-description">Full Description</label>
              <textarea 
                id="product-full-description"
                v-model="productForm.description"
                rows="3"
              ></textarea>
            </div>
            
            <div class="form-group">
              <label for="product-price">Base Price</label>
              <input 
                id="product-price"
                v-model.number="productForm.basePrice"
                type="number"
                min="0"
                step="0.01"
                required
              />
            </div>
            
            <div class="form-group checkbox-group">
              <div class="checkbox-wrapper">
                <input 
                  id="product-is-new"
                  v-model="productForm.isNew"
                  type="checkbox"
                />
                <label for="product-is-new" class="checkbox-label">
                  Mark as New Product
                </label>
              </div>
            </div>
            
            <div class="form-group">
              <label for="product-thumbnail">Thumbnail URL</label>
              <input 
                id="product-thumbnail"
                v-model="productForm.thumbnail"
                type="text"
                required
              />
            </div>
            
            <h3 class="form-section-title">Views</h3>
            <div 
              v-for="(view, index) in productForm.views" 
              :key="index"
              class="form-nested-group"
            >
              <div class="nested-group-header">
                <h4>View {{ index + 1 }}</h4>
                <button 
                  type="button" 
                  class="btn btn-danger btn-sm"
                  @click="removeView(index)"
                >
                  Remove
                </button>
              </div>
              
              <div class="form-group">
                <label :for="`view-id-${index}`">View ID</label>
                <input 
                  :id="`view-id-${index}`"
                  v-model="view.id"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`view-name-${index}`">View Name</label>
                <input 
                  :id="`view-name-${index}`"
                  v-model="view.name"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`view-image-${index}`">Base Image URL</label>
                <input 
                  :id="`view-image-${index}`"
                  v-model="view.baseImage"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`view-thumbnail-${index}`">Thumbnail URL</label>
                <input 
                  :id="`view-thumbnail-${index}`"
                  v-model="view.thumbnail"
                  type="text"
                  required
                />
              </div>
            </div>
            
            <button 
              type="button" 
              class="btn btn-secondary btn-add"
              @click="addView"
            >
              Add View
            </button>
            
            <h3 class="form-section-title">Categories</h3>
            <div 
              v-for="(category, index) in productForm.categories" 
              :key="index"
              class="form-nested-group"
            >
              <div class="nested-group-header">
                <h4>Category {{ index + 1 }}</h4>
                <button 
                  type="button" 
                  class="btn btn-danger btn-sm"
                  @click="removeCategory(index)"
                >
                  Remove
                </button>
              </div>
              
              <div class="form-group">
                <label :for="`category-id-${index}`">Category ID</label>
                <input 
                  :id="`category-id-${index}`"
                  v-model="category.id"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`category-name-${index}`">Category Name</label>
                <input 
                  :id="`category-name-${index}`"
                  v-model="category.name"
                  type="text"
                  required
                />
              </div>
            </div>
            
            <button 
              type="button" 
              class="btn btn-secondary btn-add"
              @click="addCategory"
            >
              Add Category
            </button>
            
            <h3 class="form-section-title">Layers</h3>
            <div 
              v-for="(layer, index) in productForm.layers" 
              :key="index"
              class="form-nested-group"
            >
              <div class="nested-group-header">
                <h4>Layer {{ index + 1 }}</h4>
                <button 
                  type="button" 
                  class="btn btn-danger btn-sm"
                  @click="removeLayer(index)"
                >
                  Remove
                </button>
              </div>
              
              <div class="form-group">
                <label :for="`layer-id-${index}`">Layer ID</label>
                <input 
                  :id="`layer-id-${index}`"
                  v-model="layer.id"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`layer-name-${index}`">Layer Name</label>
                <input 
                  :id="`layer-name-${index}`"
                  v-model="layer.name"
                  type="text"
                  required
                />
              </div>
              
              <div class="form-group">
                <label :for="`layer-category-${index}`">Category</label>
                <select 
                  :id="`layer-category-${index}`"
                  v-model="layer.categoryId"
                  required
                >
                  <option value="">Select Category</option>
                  <option 
                    v-for="category in productForm.categories" 
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
              
              <div class="form-group">
                <label :for="`layer-price-${index}`">Price</label>
                <input 
                  :id="`layer-price-${index}`"
                  v-model.number="layer.price"
                  type="number"
                  min="0"
                  step="0.01"
                  required
                />
              </div>
              
              <div class="form-group checkbox-group">
                <div class="checkbox-wrapper">
                  <input 
                    :id="`layer-is-color-${index}`"
                    v-model="layer.isColorType"
                    type="checkbox"
                  />
                  <label :for="`layer-is-color-${index}`" class="checkbox-label">
                    Is Color Type
                  </label>
                </div>
              </div>
              
              <div v-if="layer.isColorType" class="form-group">
                <label :for="`layer-color-${index}`">Color</label>
                <input 
                  :id="`layer-color-${index}`"
                  v-model="layer.color"
                  type="color"
                  required
                />
              </div>
              
              <h5>View Images</h5>
              <div 
                v-for="view in productForm.views" 
                :key="`layer-${index}-view-${view.id}`"
                class="form-group"
              >
                <label :for="`layer-${index}-view-${view.id}`">{{ view.name }} View Image URL</label>
                <input 
                  :id="`layer-${index}-view-${view.id}`"
                  v-model="layer.views[view.id]"
                  type="text"
                  required
                />
              </div>
            </div>
            
            <button 
              type="button" 
              class="btn btn-secondary btn-add"
              @click="addLayer"
            >
              Add Layer
            </button>
            
            <div class="form-actions">
              <button type="button" class="btn btn-secondary" @click="closeProductForm">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary">
                {{ isEditMode ? 'Update Product' : 'Create Product' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Quote Details Modal -->
    <div v-if="selectedQuote" class="modal-overlay">
      <div class="modal-container">
        <div class="modal-header">
          <h2>Quote Details</h2>
          <button class="modal-close" @click="selectedQuote = null">×</button>
        </div>
        
        <div class="modal-body">
          <div class="quote-detail-header">
            <div>
              <h3>{{ selectedQuote.userInfo.name }}</h3>
              <p>{{ selectedQuote.timestamp | formatDate }}</p>
            </div>
            <div class="quote-status" :class="selectedQuote.status">
              {{ selectedQuote.status }}
            </div>
          </div>
          
          <div class="quote-detail-section">
            <h4>Contact Information</h4>
            <p><strong>Email:</strong> {{ selectedQuote.userInfo.email }}</p>
            <p v-if="selectedQuote.userInfo.phone"><strong>Phone:</strong> {{ selectedQuote.userInfo.phone }}</p>
          </div>
          
          <div class="quote-detail-section">
            <h4>Product Configuration</h4>
            <p><strong>Product:</strong> {{ selectedQuote.product.name }}</p>
            
            <div class="quote-summary">
              <div v-if="selectedQuote.basePrice > 0" class="summary-item">
                <span>Base Price</span>
                <span>{{ formatPrice(selectedQuote.basePrice) }}</span>
              </div>
              
              <div 
                v-for="(category, categoryId) in selectedQuote.summaryData" 
                :key="categoryId"
                class="summary-category"
              >
                <div class="category-header">
                  <h5>{{ category.title }}</h5>
                  <span>{{ formatPrice(category.price) }}</span>
                </div>
                
                <ul class="category-items">
                  <li 
                    v-for="item in category.items" 
                    :key="item.id"
                    class="category-item"
                  >
                    <span>{{ item.name }}</span>
                    <span>{{ formatPrice(item.price) }}</span>
                  </li>
                </ul>
              </div>
              
              <div class="summary-total">
                <span>Total Price</span>
                <span>{{ formatPrice(selectedQuote.totalPrice) }}</span>
              </div>
            </div>
          </div>
          
          <div v-if="selectedQuote.userInfo.message" class="quote-detail-section">
            <h4>Message</h4>
            <p>{{ selectedQuote.userInfo.message }}</p>
          </div>
          
          <div class="quote-detail-actions">
            <select 
              v-model="selectedQuote.status" 
              @change="updateQuoteStatus(selectedQuote)"
              class="status-select"
            >
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="rejected">Rejected</option>
            </select>
            
            <button class="btn btn-primary" @click="sendResponse">
              Send Response
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteConfirmation" class="modal-overlay">
      <div class="modal-container modal-sm">
        <div class="modal-header">
          <h2>Confirm Delete</h2>
          <button class="modal-close" @click="showDeleteConfirmation = false">×</button>
        </div>
        
        <div class="modal-body">
          <p>Are you sure you want to delete the product "{{ productToDelete?.name }}"?</p>
          <p class="text-danger">This action cannot be undone.</p>
          
          <div class="form-actions">
            <button class="btn btn-secondary" @click="showDeleteConfirmation = false">
              Cancel
            </button>
            <button class="btn btn-danger" @click="deleteProduct">
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, reactive, computed, onMounted } from 'vue';
import { 
  adminFetchConfigurators, 
  adminFetchQuotes,
  adminCreateConfigurator,
  adminUpdateConfigurator,
  adminDeleteConfigurator,
  adminUpdateQuoteStatus
} from '../../backend/api';

export default {
  setup() {
    // State
    const activeTab = ref('products');
    const products = ref([]);
    const quotes = ref([]);
    const showProductForm = ref(false);
    const showNewProductForm = ref(false);
    const isEditMode = ref(false);
    const selectedQuote = ref(null);
    const showDeleteConfirmation = ref(false);
    const productToDelete = ref(null);
    const isSubmitting = ref(false);
    
    // Form state
    const productForm = reactive({
      name: '',
      shortDescription: '',
      description: '',
      basePrice: 0,
      isNew: false,
      thumbnail: '',
      views: [],
      categories: [],
      layers: []
    });
    
    // Fetch data on mount
    onMounted(async () => {
      try {
        products.value = await adminFetchConfigurators();
        quotes.value = await adminFetchQuotes();
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    });
    
    // Methods
    const formatPrice = (price) => {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
      }).format(price);
    };
    
    const resetProductForm = () => {
      productForm.name = '';
      productForm.shortDescription = '';
      productForm.description = '';
      productForm.basePrice = 0;
      productForm.isNew = false;
      productForm.thumbnail = '';
      productForm.views = [];
      productForm.categories = [];
      productForm.layers = [];
    };
    
    const editProduct = (product) => {
      isEditMode.value = true;
      
      // Clone the product to avoid modifying the original
      productForm.id = product.id;
      productForm.name = product.name;
      productForm.shortDescription = product.shortDescription;
      productForm.description = product.description || '';
      productForm.basePrice = product.basePrice;
      productForm.isNew = product.isNew || false;
      productForm.thumbnail = product.thumbnail;
      
      // Clone views
      productForm.views = product.views.map(view => ({ ...view }));
      
      // Clone categories
      productForm.categories = product.categories.map(category => ({ ...category }));
      
      // Clone layers with special handling for views object
      productForm.layers = product.layers.map(layer => {
        const newLayer = { ...layer };
        
        // Handle color type layers
        if (layer.type === 'color') {
          newLayer.isColorType = true;
        }
        
        // Clone views object
        newLayer.views = { ...layer.views };
        
        return newLayer;
      });
      
      showProductForm.value = true;
    };
    
    const addView = () => {
      productForm.views.push({
        id: '',
        name: '',
        baseImage: '',
        thumbnail: ''
      });
    };
    
    const removeView = (index) => {
      productForm.views.splice(index, 1);
    };
    
    const addCategory = () => {
      productForm.categories.push({
        id: '',
        name: ''
      });
    };
    
    const removeCategory = (index) => {
      productForm.categories.splice(index, 1);
    };
    
    const addLayer = () => {
      const newLayer = {
        id: '',
        name: '',
        categoryId: '',
        price: 0,
        isColorType: false,
        views: {}
      };
      
      // Initialize views object with empty strings for each view
      productForm.views.forEach(view => {
        newLayer.views[view.id] = '';
      });
      
      productForm.layers.push(newLayer);
    };
    
    const removeLayer = (index) => {
      productForm.layers.splice(index, 1);
    };
    
    const saveProduct = async () => {
      try {
        isSubmitting.value = true;
        
        // Process layers to match the expected format
        const processedLayers = productForm.layers.map(layer => {
          const processedLayer = { ...layer };
          
          // Handle color type
          if (layer.isColorType) {
            processedLayer.type = 'color';
            processedLayer.color = layer.color;
          }
          
          // Remove the isColorType property
          delete processedLayer.isColorType;
          
          return processedLayer;
        });
        
        const productData = {
          ...productForm,
          layers: processedLayers
        };
        
        if (isEditMode.value) {
          const updatedProduct = await adminUpdateConfigurator(productForm.id, productData);
          
          // Update the product in the list
          const index = products.value.findIndex(p => p.id === updatedProduct.id);
          if (index !== -1) {
            products.value[index] = updatedProduct;
          }
        } else {
          const newProduct = await adminCreateConfigurator(productData);
          products.value.push(newProduct);
        }
        
        closeProductForm();
      } catch (error) {
        console.error('Error saving product:', error);
      } finally {
        isSubmitting.value = false;
      }
    };
    
    const closeProductForm = () => {
      showProductForm.value = false;
      isEditMode.value = false;
      resetProductForm();
    };
    
    const confirmDeleteProduct = (product) => {
      productToDelete.value = product;
      showDeleteConfirmation.value = true;
    };
    
    const deleteProduct = async () => {
      if (!productToDelete.value) return;
      
      try {
        await adminDeleteConfigurator(productToDelete.value.id);
        
        // Remove the product from the list
        products.value = products.value.filter(p => p.id !== productToDelete.value.id);
        
        showDeleteConfirmation.value = false;
        productToDelete.value = null;
      } catch (error) {
        console.error('Error deleting product:', error);
      }
    };
    
    const viewQuoteDetails = (quote) => {
      selectedQuote.value = { ...quote };
    };
    
    const updateQuoteStatus = async (quote) => {
      try {
        await adminUpdateQuoteStatus(quote.id, quote.status);
        
        // Update the quote in the list
        const index = quotes.value.findIndex(q => q.id === quote.id);
        if (index !== -1) {
          quotes.value[index].status = quote.status;
        }
      } catch (error) {
        console.error('Error updating quote status:', error);
      }
    };
    
    const sendResponse = () => {
      // This would typically send an email to the customer
      alert('Response sent to customer!');
    };
    
    return {
      activeTab,
      products,
      quotes,
      showProductForm,
      showNewProductForm,
      isEditMode,
      productForm,
      selectedQuote,
      showDeleteConfirmation,
      productToDelete,
      isSubmitting,
      formatPrice,
      editProduct,
      addView,
      removeView,
      addCategory,
      removeCategory,
      addLayer,
      removeLayer,
      saveProduct,
      closeProductForm,
      confirmDeleteProduct,
      deleteProduct,
      viewQuoteDetails,
      updateQuoteStatus,
      sendResponse
    };
  },
  
  filters: {
    formatDate(timestamp) {
      const date = new Date(timestamp);
      return new Intl.DateTimeFormat('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date);
    }
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

/* Modal */
.modal-overlay {
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

.modal-container {
  background-color: white;
  border-radius: 8px;
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-container.modal-sm {
  max-width: 500px;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.modal-header h2 {
  margin: 0;
  font-size: 1.25rem;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #64748b;
}

.modal-body {
  padding: 1.5rem;
}

/* Form */
.product-form {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.form-section-title {
  margin: 1rem 0 0.5rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.form-nested-group {
  background-color: #f8fafc;
  border-radius: 6px;
  padding: 1rem;
  margin-bottom: 1rem;
}

.nested-group-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.nested-group-header h4 {
  margin: 0;
  font-size: 1rem;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

.btn-add {
  margin-bottom: 1rem;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 1rem;
}

/* Quote Details */
.quote-detail-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.quote-detail-header h3 {
  margin: 0 0 0.25rem 0;
}

.quote-detail-header p {
  margin: 0;
  color: #64748b;
  font-size: 0.875rem;
}

.quote-detail-section {
  margin-bottom: 1.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.quote-detail-section:last-child {
  border-bottom: none;
  padding-bottom: 0;
  margin-bottom: 0;
}

.quote-detail-section h4 {
  margin: 0 0 1rem 0;
  font-size: 1.125rem;
  color: #334155;
}

.quote-summary {
  background-color: #f8fafc;
  border-radius: 6px;
  padding: 1rem;
}

.quote-summary .summary-item,
.quote-summary .summary-total {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
}

.quote-summary .summary-total {
  border-top: 1px solid #e2e8f0;
  margin-top: 0.5rem;
  padding-top: 1rem;
  font-weight: 600;
}

.quote-summary .category-header {
  display: flex;
  justify-content: space-between;
  font-weight: 600;
  margin: 0.5rem 0;
}

.quote-summary .category-items {
  list-style: none;
  padding-left: 1rem;
  margin: 0 0 1rem 0;
}

.quote-summary .category-item {
  display: flex;
  justify-content: space-between;
  font-size: 0.875rem;
  margin-bottom: 0.25rem;
}

.quote-detail-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Utility Classes */
.text-danger {
  color: #ef4444;
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