
import login from '@/views/LoginView.vue'
import HomeView from '@/views/HomeView.vue'
import register from '@/views/RegisterView.vue'
import { createRouter, createWebHistory } from 'vue-router'
import Listing from '@/views/ListingsView.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'login',
      component: login,
    },
    {
      path: '/Register',
      name: 'register',
      component: register,
    },
    {
      path: '/list',
      name: 'listings',
      component: Listing,
    }
  ],
})




export default router;
