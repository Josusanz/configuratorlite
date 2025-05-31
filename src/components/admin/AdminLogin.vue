<template>
  <div class="admin-login">
    <div class="login-container">
      <div class="login-header">
        <img src="../../assets/images/logo.svg" alt="Configurator" class="logo-image" />
        <h1>Admin Login</h1>
      </div>
      
      <form @submit.prevent="login" class="login-form">
        <div class="form-group">
          <label for="username">Username</label>
          <input 
            id="username"
            v-model="username"
            type="text"
            placeholder="Enter your username"
            required
          />
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input 
            id="password"
            v-model="password"
            type="password"
            placeholder="Enter your password"
            required
          />
        </div>
        
        <div v-if="error" class="error-message">
          {{ error }}
        </div>
        
        <button type="submit" class="btn btn-primary btn-login" :disabled="isLoading">
          <span v-if="isLoading" class="spinner"></span>
          <span>{{ isLoading ? 'Logging in...' : 'Login' }}</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  emits: ['login-success'],
  
  setup(props, { emit }) {
    const username = ref('');
    const password = ref('');
    const error = ref('');
    const isLoading = ref(false);
    
    const login = async () => {
      error.value = '';
      isLoading.value = true;
      
      try {
        // In a real app, this would make an API call to authenticate
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // For demo purposes, accept any non-empty credentials
        if (username.value && password.value) {
          // Simulate successful login
          emit('login-success', { username: username.value });
        } else {
          error.value = 'Please enter both username and password';
        }
      } catch (err) {
        error.value = 'Login failed. Please try again.';
      } finally {
        isLoading.value = false;
      }
    };
    
    return {
      username,
      password,
      error,
      isLoading,
      login
    };
  }
};
</script>

<style scoped>
.admin-login {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f1f5f9;
}

.login-container {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-header {
  text-align: center;
  margin-bottom: 2rem;
}

.login-header img {
  width: 64px;
  height: 64px;
  margin-bottom: 1rem;
}

.login-header h1 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #475569;
  margin-bottom: 0.5rem;
}

input {
  padding: 0.75rem;
  border: 1px solid #cbd5e1;
  border-radius: 6px;
  font-size: 1rem;
  color: #0f172a;
  background-color: #f8fafc;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

input:focus {
  outline: none;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.error-message {
  color: #ef4444;
  font-size: 0.875rem;
  margin-top: -0.5rem;
}

.btn-login {
  width: 100%;
  padding: 0.75rem 1.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.spinner {
  display: inline-block;
  width: 1rem;
  height: 1rem;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>