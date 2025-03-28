
import Login from '@/views/LoginView.vue'
import HomeView from '@/views/HomeView.vue'
import Register from '@/views/RegisterView.vue'
import { createRouter, createWebHistory } from 'vue-router'

import Profile from '@/pages/Profile.vue'

import GuestLayout from '@/components/GuestLayout.vue';
import Home from '@/pages/Home.vue';
import  DefaultLayout from '@/components/DefaultLayout.vue';
import Navbar from '@/components/Navbar.vue'
import Listings from '@/pages/Listings.vue'
import PropertySub from '@/pages/PropertySub.vue'
import AdminPage from '@/components/AdminPage.vue'
import PropertyList from '@/pages/PropertyList.vue'
import UserPropertySub from '@/pages/UserPropSubmission.vue'
import AdminDash from '@/pages/AdminDashBoard.vue'
import UserTable from '@/views/UsersViewAdmin.vue'
const routes = [
  {
    path: "/",
    component: GuestLayout,
    children: [
      {path: '', redirect: '/home'},
      { path: 'home', name: 'Home', component: HomeView  },  
        
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {hideNavbar: true}
  },
   {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  {
    path: '/home',
    name: 'HomeView',
    component: HomeView,
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
  },
  {
    path: '/propertylist',
    name: 'PropertyList',
    component: PropertyList,
  },
  {
  path: '/list',
  name: 'Listings',
  component: Listings,
  },
  {
  },
  // {
  //   path: '/:pathMatch(.*)*',
  //   name: 'NotFound',
  //   component: NotFound,
  // },
  
  {
    path: '/sub',
    name: 'PropertySub',
    component: PropertySub
  },
  {
    path: '/admin',
    name: 'Admin',
    component: AdminPage,
  },
  {
    path: '/userprop',
    name: 'UserProp',
    component: UserPropertySub,
  },
  {
    path: '/admindash',
    name: 'AdminDash',
    component: AdminDash,
  },
  {
    path: '/usertable',
    name: 'UserTable',
    component: UserTable,
  }
];


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,

})




export default router;
