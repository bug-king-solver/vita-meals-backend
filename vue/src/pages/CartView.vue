<template>
  <div class="container mx-auto mt-10">
    <div class="flex shadow-md my-10">
      <div class="w-3/4 bg-white px-10 py-10">
        <div class="flex justify-between border-b pb-8">
          <h1 class="font-semibold text-2xl">Shopping Cart</h1>
          <h2 class="font-semibold text-2xl">{{ store.itemCount }} Items</h2>
        </div>
        <div class="flex mt-10 mb-5">
          <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
          <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Quantity</h3>
          <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Price</h3>
          <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Total</h3>
        </div>
        <div v-if="store.cart.length > 0" class="cart_product_container">
          <CartItem v-for="cartItem in store.cart[0].cart_items" :cartItem="cartItem" :cartId="store.cart[0].id" :key="cartItem.id" />
        </div>

        <div class="flex flex-wrap justify-between text-sm mt-10">
          <RouterLink to="/" class="flex font-semibold text-indigo-600">
            <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512"><path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/></svg>
            Continue Shopping
          </RouterLink>
          <button @click.prevent="clearCart" :disabled="store.cart.length === 0" class="btn border rounded px-3 font-semibold text-red-600 cursor-pointer">Clear All</button>
        </div>
        
      </div>

      <div id="summary" class="w-1/4 px-8 py-10">
        <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>
        
        <div class="mt-4">
          <div class="flex font-semibold justify-between py-6 text-sm uppercase">
            <span>Total cost</span>
            <span>${{ (store.subtotalAmount) }}</span>
          </div>
          <button @click.prevent="checkoutCart" :disabled="store.cart.length === 0" class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-sm text-white uppercase w-full">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useCartStore } from '../store/cart';
import CartItem from '../components/CartItem.vue';
import { onMounted } from 'vue';

const store = useCartStore();

onMounted(() => {
  store.fetchCartItems();
})

function clearCart() {
  if (store.cart.length > 0) {
    let payload: { cart_id: number } = {
    cart_id: store.cart[0].id
  };

    if (confirm("Once you confirm, all the items of the cart will be removed! Want to proceed?")) {
      store.clearACart(payload);
    }
  }
}

function checkoutCart() {
  if (store.cart.length > 0) {
    let payload: {cart_id: number} = {
      cart_id: store.cart[0].id
    };

    if (confirm("Proceed to checkout?")) {
      store.checkoutACart(payload);
    }
  }
}

</script>