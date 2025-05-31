<template>
  <div class="notifications-container">
    <transition-group name="notification">
      <div 
        v-for="notification in notifications" 
        :key="notification.id"
        class="notification"
        :class="getNotificationClass(notification.type)"
      >
        <div class="notification-content">
          <div class="notification-icon">
            <svg v-if="notification.type === 'success'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            
            <svg v-else-if="notification.type === 'error'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            
            <svg v-else-if="notification.type === 'warning'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
          </div>
          
          <div class="notification-message">
            {{ notification.message }}
          </div>
        </div>
        
        <button 
          class="notification-close"
          @click="dismissNotification(notification.id)"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  setup() {
    const store = useStore()
    
    // Computed properties
    const notifications = computed(() => store.state.notifications)
    
    // Methods
    const getNotificationClass = (type) => {
      switch (type) {
        case 'success':
          return 'is-success'
        case 'error':
          return 'is-error'
        case 'warning':
          return 'is-warning'
        default:
          return 'is-info'
      }
    }
    
    const dismissNotification = (id) => {
      store.commit('removeNotification', id)
    }
    
    return {
      notifications,
      getNotificationClass,
      dismissNotification
    }
  }
}
</script>

<style scoped>
.notifications-container {
  position: fixed;
  top: 1.5rem;
  right: 1.5rem;
  z-index: 9999;
  width: 320px;
  max-width: calc(100vw - 3rem);
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.notification {
  background-color: #fff;
  border-radius: 6px;
  padding: 1rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: flex-start;
  border-left: 4px solid #64748b;
}

.notification.is-success {
  border-left-color: #10b981;
}

.notification.is-error {
  border-left-color: #ef4444;
}

.notification.is-warning {
  border-left-color: #f59e0b;
}

.notification.is-info {
  border-left-color: #3b82f6;
}

.notification-content {
  display: flex;
  flex-grow: 1;
}

.notification-icon {
  margin-right: 0.75rem;
  color: #64748b;
}

.is-success .notification-icon {
  color: #10b981;
}

.is-error .notification-icon {
  color: #ef4444;
}

.is-warning .notification-icon {
  color: #f59e0b;
}

.is-info .notification-icon {
  color: #3b82f6;
}

.notification-message {
  font-size: 0.875rem;
  color: #0f172a;
  line-height: 1.5;
}

.notification-close {
  background: none;
  border: none;
  padding: 0.25rem;
  margin-left: 0.5rem;
  cursor: pointer;
  color: #94a3b8;
  transition: color 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-close:hover {
  color: #475569;
}

/* Animations */
.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from {
  opacity: 0;
  transform: translateX(30px);
}

.notification-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>