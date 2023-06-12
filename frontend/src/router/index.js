import { createRouter, createWebHistory } from 'vue-router'
import AdminView from "@/views/AdminView";
import HomeView from "@/views/HomeView";


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/admin',
    name: 'admin',
    component: AdminView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

//if the logged-in user is not admin redirect to home and trigger an unauthorized notification
router.beforeEach((to, from, next) => {
  const user = JSON.parse(localStorage.getItem('user'));
  const message = user?.is_admin ? `Welcome ${user.name}!` : "Unauthorized!";
  if (to.name === 'admin' && !(user?.is_admin)) {
    next({ name: 'home', query: { message: message } })
  } else{
    next()
  }
})
export default router
