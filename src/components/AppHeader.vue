<template>
  <header class="app-header">
    <div class="container">
      <div class="header-content">
        <div class="logo">
          <a href="/" class="logo-link">
            <img src="../assets/images/logo.svg" alt="Configurator" class="logo-image" />
            <span class="logo-text">Configurator</span>
          </a>
        </div>
        
        <nav class="main-nav">
          <ul class="nav-list">
            <li class="nav-item">
              <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Products</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Inspiration</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Contact</a>
            </li>
          </ul>
        </nav>
        
        <div class="header-actions">
          <button class="header-action-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </button>
          
          <button class="header-action-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </button>
        </div>
        
        <button class="mobile-menu-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
      </div>
    </div>
  </header>
</template>

<style scoped>
.app-header {
  background-color: #fff;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  width: 100%;
  z-index: 100;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 64px;
}

.logo {
  display: flex;
  align-items: center;
}

.logo-link {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  text-decoration: none;
  color: #1e293b;
}

.logo-image {
  height: 32px;
  width: auto;
}

.logo-text {
  font-weight: 700;
  font-size: 1.25rem;
}

.main-nav {
  display: none;
}

.nav-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: #475569;
  text-decoration: none;
  font-weight: 500;
  font-size: 0.9375rem;
  transition: color 0.2s ease;
  padding: 0.5rem 0;
}

.nav-link:hover {
  color: #2563eb;
}

.header-actions {
  display: none;
  gap: 0.75rem;
}

.header-action-btn {
  background: none;
  border: none;
  padding: 0.5rem;
  cursor: pointer;
  color: #475569;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.header-action-btn:hover {
  background-color: #f1f5f9;
  color: #2563eb;
}

.mobile-menu-btn {
  background: none;
  border: none;
  padding: 0.5rem;
  cursor: pointer;
  color: #475569;
  border-radius: 6px;
}

@media (min-width: 768px) {
  .main-nav {
    display: block;
  }
  
  .header-actions {
    display: flex;
  }
  
  .mobile-menu-btn {
    display: none;
  }
}
</style>