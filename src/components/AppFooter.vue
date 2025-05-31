<template>
  <footer class="app-footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-company">
          <div class="footer-logo">
            <img src="../assets/images/logo.svg" alt="Configurator" class="logo-image" />
            <span class="logo-text">Configurator</span>
          </div>
          <p class="company-description">
            Create custom products with our advanced configurator tool.
            Design, visualize, and order your perfect product.
          </p>
        </div>
        
        <div class="footer-links">
          <div class="footer-links-column">
            <h3 class="footer-heading">Products</h3>
            <ul class="footer-menu">
              <li><a href="#">Furniture</a></li>
              <li><a href="#">Clothing</a></li>
              <li><a href="#">Electronics</a></li>
              <li><a href="#">Custom Items</a></li>
            </ul>
          </div>
          
          <div class="footer-links-column">
            <h3 class="footer-heading">Company</h3>
            <ul class="footer-menu">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
          
          <div class="footer-links-column">
            <h3 class="footer-heading">Support</h3>
            <ul class="footer-menu">
              <li><a href="#">Help Center</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#">Shipping</a></li>
              <li><a href="#">Returns</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p class="copyright">
          &copy; {{ currentYear }} Configurator. All rights reserved.
        </p>
        
        <div class="footer-social">
          <a href="#" class="social-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <a href="#" class="social-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
          </a>
          <a href="#" class="social-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { computed } from 'vue'

export default {
  setup() {
    const currentYear = computed(() => new Date().getFullYear())
    
    return {
      currentYear
    }
  }
}
</script>

<style scoped>
.app-footer {
  background-color: #f8fafc;
  padding: 3rem 0 1.5rem;
  margin-top: 3rem;
  border-top: 1px solid #e2e8f0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.footer-content {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
  margin-bottom: 2rem;
}

.footer-logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.logo-image {
  height: 32px;
  width: auto;
}

.logo-text {
  font-weight: 700;
  font-size: 1.25rem;
  color: #1e293b;
}

.company-description {
  font-size: 0.875rem;
  color: #64748b;
  max-width: 300px;
}

.footer-links {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.footer-heading {
  font-size: 1rem;
  font-weight: 600;
  color: #334155;
  margin: 0 0 1.25rem 0;
}

.footer-menu {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-menu li {
  margin-bottom: 0.75rem;
}

.footer-menu a {
  color: #64748b;
  text-decoration: none;
  font-size: 0.875rem;
  transition: color 0.2s ease;
}

.footer-menu a:hover {
  color: #2563eb;
}

.footer-bottom {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e2e8f0;
}

.copyright {
  font-size: 0.875rem;
  color: #94a3b8;
  margin: 0;
}

.footer-social {
  display: flex;
  gap: 1.25rem;
}

.social-link {
  color: #64748b;
  transition: color 0.2s ease;
}

.social-link:hover {
  color: #2563eb;
}

@media (min-width: 768px) {
  .footer-content {
    grid-template-columns: 1fr 2fr;
  }
  
  .footer-links {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .footer-bottom {
    flex-direction: row;
    justify-content: space-between;
  }
}
</style>