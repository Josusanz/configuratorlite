<template>
  <div class="confirmation-container">
    <div class="confirmation-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      </svg>
    </div>
    
    <h2 class="confirmation-title">Thank You for Your Request!</h2>
    
    <p class="confirmation-message">
      Your quote request has been successfully submitted. We will review your configuration
      and get back to you shortly with a customized quote.
    </p>
    
    <p class="confirmation-details">
      A confirmation email has been sent to your inbox with the details of your request.
      Please check your email for further information.
    </p>
    
    <div class="confirmation-summary">
      <h3>Your Configuration Summary</h3>
      
      <div class="confirmation-product">
        <img 
          :src="productImage" 
          :alt="productName" 
          class="confirmation-product-image"
        />
        <div class="confirmation-product-details">
          <h4>{{ productName }}</h4>
          <p class="confirmation-product-price">{{ totalPrice }}</p>
        </div>
      </div>
      
      <div class="confirmation-reference">
        <p>Reference Number: <strong>{{ referenceNumber }}</strong></p>
        <p>Submitted on: <strong>{{ submissionDate }}</strong></p>
      </div>
    </div>
    
    <div class="confirmation-actions">
      <button @click="startNewConfiguration" class="btn btn-secondary">
        Configure Another Product
      </button>
      
      <button @click="downloadSummary" class="btn btn-primary">
        Download Summary
      </button>
    </div>
  </div>
</template>

<script>
import { computed } from 'vue';
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';

export default {
  props: {
    product: {
      type: Object,
      required: true
    },
    totalPrice: {
      type: String,
      required: true
    },
    summaryData: {
      type: Object,
      default: () => ({})
    }
  },
  
  emits: ['new-configuration'],
  
  setup(props, { emit }) {
    const productName = computed(() => props.product.name);
    
    const productImage = computed(() => {
      if (props.product.views && props.product.views.length > 0) {
        return props.product.views[0].baseImage;
      }
      return props.product.thumbnail;
    });
    
    const referenceNumber = computed(() => {
      // Generate a random reference number
      return `REF-${Math.floor(Math.random() * 1000000).toString().padStart(6, '0')}`;
    });
    
    const submissionDate = computed(() => {
      return new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    });
    
    const startNewConfiguration = () => {
      emit('new-configuration');
    };
    
    const downloadSummary = async () => {
      try {
        const element = document.querySelector('.confirmation-container');
        
        if (!element) return;
        
        const canvas = await html2canvas(element, {
          scale: 2,
          logging: false,
          useCORS: true
        });
        
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4'
        });
        
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        pdf.save(`${props.product.name.replace(/\s+/g, '-').toLowerCase()}-configuration.pdf`);
      } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Failed to generate PDF. Please try again.');
      }
    };
    
    return {
      productName,
      productImage,
      referenceNumber,
      submissionDate,
      startNewConfiguration,
      downloadSummary
    };
  }
};
</script>

<style scoped>
.confirmation-container {
  padding: 2rem;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}

.confirmation-icon {
  color: #10b981;
  margin-bottom: 1.5rem;
}

.confirmation-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 1rem 0;
}

.confirmation-message {
  font-size: 1rem;
  color: #475569;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}

.confirmation-details {
  font-size: 0.875rem;
  color: #64748b;
  margin-bottom: 2rem;
  padding: 1rem;
  background-color: #f8fafc;
  border-radius: 6px;
}

.confirmation-summary {
  text-align: left;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background-color: #f8fafc;
  border-radius: 6px;
}

.confirmation-summary h3 {
  margin: 0 0 1rem 0;
  font-size: 1.125rem;
  color: #334155;
  text-align: center;
}

.confirmation-product {
  display: flex;
  align-items: center;
  margin-bottom: 1.5rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid #e2e8f0;
}

.confirmation-product-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 1rem;
}

.confirmation-product-details h4 {
  margin: 0 0 0.5rem 0;
  font-size: 1rem;
  color: #1e293b;
}

.confirmation-product-price {
  margin: 0;
  font-weight: 600;
  color: #2563eb;
}

.confirmation-reference {
  font-size: 0.875rem;
  color: #475569;
}

.confirmation-reference p {
  margin: 0 0 0.5rem 0;
}

.confirmation-reference p:last-child {
  margin-bottom: 0;
}

.confirmation-actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1.5rem;
}

@media (max-width: 640px) {
  .confirmation-actions {
    flex-direction: column;
  }
  
  .confirmation-actions button {
    width: 100%;
  }
}
</style>