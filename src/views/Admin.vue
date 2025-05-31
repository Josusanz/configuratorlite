<template>
  <div class="admin-view">
    <AdminLogin v-if="!isLoggedIn" @login-success="handleLoginSuccess" />
    <AdminPanel v-else />
  </div>
</template>

<script>
import { ref } from 'vue';
import AdminLogin from '../components/admin/AdminLogin.vue';
import AdminPanel from '../components/admin/AdminPanel.vue';

export default {
  components: {
    AdminLogin,
    AdminPanel
  },
  
  setup() {
    const isLoggedIn = ref(false);
    
    const handleLoginSuccess = (userData) => {
      isLoggedIn.value = true;
      // In a real app, you would store the user data and token
      console.log('Logged in as:', userData.username);
    };
    
    return {
      isLoggedIn,
      handleLoginSuccess
    };
  }
};
</script>