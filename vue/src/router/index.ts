import { createRouter, createWebHistory } from 'vue-router'
import SignUpPage from '../pages/SignUpPage.vue'
import SignInPage from '../pages/SignInPage.vue'
import ProductsPage from '../pages/ProductsPage.vue'
import ProductDetailPage from '../pages/ProductDetailPage.vue'
import CartView from '../pages/CartView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'products',
      component: ProductsPage
    },
    {
      path: '/products/:id',
      name: 'product_details',
      component: ProductDetailPage,
      props: true
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignUpPage
    },
    {
      path: '/signin',
      name: 'signin',
      component: SignInPage
    },
    {
      path: '/cart',
      name: 'cart',
      component: CartView
    }
  ]
})

export default router
