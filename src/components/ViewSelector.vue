<template>
  <div class="view-selector">
    <button 
      v-for="view in views" 
      :key="view.id"
      class="view-button"
      :class="{ 'is-active': view.id === activeView }"
      @click="changeView(view.id)"
    >
      <img 
        v-if="view.thumbnail" 
        :src="view.thumbnail" 
        :alt="view.name"
        class="view-thumbnail"
      />
      <span v-else class="view-name">{{ view.name }}</span>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    views: {
      type: Array,
      required: true
    },
    activeView: {
      type: String,
      required: true
    }
  },
  
  emits: ['change-view'],
  
  setup(props, { emit }) {
    const changeView = (viewId) => {
      emit('change-view', viewId)
    }
    
    return {
      changeView
    }
  }
}
</script>

<style scoped>
.view-selector {
  display: flex;
  justify-content: center;
  gap: 0.75rem;
  padding: 1rem;
  position: absolute;
  bottom: 1rem;
  left: 50%;
  transform: translateX(-50%);
  z-index: 5;
  background-color: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(4px);
  border-radius: 999px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.view-button {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 2px solid transparent;
  overflow: hidden;
  padding: 0;
  cursor: pointer;
  transition: all 0.2s ease;
  background-color: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
}

.view-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.view-button.is-active {
  border-color: #2563eb;
  transform: scale(1.1);
  box-shadow: 0 2px 12px rgba(37, 99, 235, 0.2);
}

.view-thumbnail {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.view-name {
  font-size: 0.75rem;
  font-weight: 600;
  color: #334155;
}
</style>