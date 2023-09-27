import { defineStore } from "pinia";
import { useRouter } from "vue-router";
import { useFlash } from "../common/useFlash";
import { Ref, computed, ref } from "vue";
import useAuthStore from "./auth";
import Api from "../apis";
import { Product } from "../types";

interface CartItem {
    id: number;
    cart_id: number;
    product_id: number;
    quantity: number;
    product: Product;
}

interface CartItemsInterface {
    id: number;
    cart_id: number;
    product_id: number;
    user_id: number;
    quantity: number;
    cart_items: CartItem[];
}

  export const useCartStore = defineStore('cart', () => {
    const router = useRouter();
    const { flash } = useFlash();
  
    const cart: Ref<CartItemsInterface[]> = ref([]);
  
    const authStore = useAuthStore();
  
    const itemCount = computed(() => {
        if (cart.value.length === 0) {
            return 0;
        } else {
            return cart.value[0].cart_items.reduce((total, item) => {
                return total + item.quantity
            }, 0);
        }
    });
  
    const subtotalAmount = computed(() => {
        if (cart.value.length === 0) {
            return 0;
        } else {
            return cart.value[0].cart_items.reduce((sum, a) => {
                return sum + (a.quantity * a.product.price)
            }, 0);
        }
    });
  
    function redirectUnauthenticatedUser() {
      if (!authStore.token || !authStore.user) {
        router.push('/');
      }
    }
  
    function fetchCartItems() {
      let errorStatus = '';
  
      redirectUnauthenticatedUser();
  
      const config = authStore.getHeadersConfig();
  
      Api
        .get('cart/' + authStore.user?.id, config)
        .then((response) => {
          if (!response.data.error) {
            cart.value = response.data.cart;
          }
        })
        .catch((error) => {
            if (!error.response) {
                // network error
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }
            flash({
                iconType: "error",
                title: "Auth Error",
                message: errorStatus
            })
        });
    }
  
    function addItemToCart(productId: number, qty: number) {
      let errorStatus = '';
  
      if (!authStore.token || !authStore.user) {
        flash({
            iconType: "error",
            title: "Auth Error",
            message: "User seems to be unauthenticated!"
        })
        return;
      }
  
      const config = authStore.getHeadersConfig();
  
      const payload: {user_id: number, product_id: number, quantity: number} = {
        user_id: authStore.user.id,
        product_id: productId,
        quantity: qty,
      };
  
      Api
        .post('cart/store', payload, config)
        .then((response) => {
          if (!response.data.error) {
            flash({
                iconType: "success",
                title: "Add Item",
                message: response.data.message
            })
            router.push('/cart');
          } else {
            flash({
                iconType: "error",
                title: "Item Add Error",
                message: response.data.message
            })
          }
        })
        .catch((error) => {
            if (!error.response) {
                // network error
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }          
            flash({
                iconType: "error",
                title: "Auth Error",
                message: errorStatus
            })
        });
    }
  
    function removeAnItem(payload: {cart_id: number, product_id: number}) {
        let errorStatus = '';
        redirectUnauthenticatedUser();
        const config = authStore.getHeadersConfig();
        Api
        .post('cart/removeitem', payload, config)
        .then(response => {
            if (!response.data.error) {
                flash({
                    iconType: "success",
                    title: "Remove Cart Item",
                    message: response.data.message
                })
                fetchCartItems();
            } else {
                flash({
                    iconType: "error",
                    title: "Remote Item Error",
                    message: response.data.message
                })
            }
        }).catch(error => {
            if (!error.response) {
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }
            flash({
                iconType: "error",
                title: "Auth",
                message: errorStatus
            })
        });
    }

    function updateQty(payload: {cart_id: number, product_id: number, quantity: number}) {
        let errorStatus = '';

        redirectUnauthenticatedUser();

        const config = authStore.getHeadersConfig();

        Api
        .post('cart/update', payload, config)
        .then(response => {
            if (!response.data.error) {
                //flash('success', 'Update Quantity', response.data.message);
                fetchCartItems();
            } else {
                flash({
                    iconType: "error",
                    title: "Update Error",
                    message: response.data.message,
                });
            }
        }).catch(error => {
            if (!error.response) {
                // network error
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }
            flash({
                iconType: "error",
                title: "Auth Error",
                message: errorStatus
            })
        });
    }

    function checkoutACart(payload: {cart_id: number}) {
        let errorStatus = '';

        redirectUnauthenticatedUser();

        const config = authStore.getHeadersConfig();

        Api
        .post('cart/checkout', payload, config)
        .then(response => {
            if (! response.data.error) {
                flash({
                    iconType: "success",
                    title: "Checkout",
                    message: response.data.message,
                })
                fetchCartItems();
                router.push("/");
            } else {
                flash({
                    iconType: "error",
                    title: "Checkout Error",
                    message: response.data.message,
                })
            }
        }).catch(error => {
            if (!error.response) {
                // network error
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }
            flash({
                iconType: "error",
                title: "Auth Error",
                message: errorStatus,
            })
        });
    }

    function clearACart(payload : {cart_id: number}) {
        let errorStatus = '';

        redirectUnauthenticatedUser();

        const config = authStore.getHeadersConfig();

        Api
        .post('cart/remove', payload, config)
        .then(response => {
            if (! response.data.error) {
                flash({
                    iconType: "success",
                    title: "Clear Cart",
                    message: response.data.message
                })
                fetchCartItems();
            } else {
                flash({
                    iconType: "error",
                    title: "Clear Cart",
                    message: response.data.message
                })
            }
        }).catch(error => {
            if (!error.response) {
                // network error
                errorStatus = 'Network Error';
            } else {
                errorStatus = error.response.data.message;
            }
            flash({
                iconType: error,
                title: "Auth Error",
                message: errorStatus
            })
        });
    }

    return {
        cart, 
        itemCount, 
        subtotalAmount, 
        fetchCartItems, 
        addItemToCart, 
        updateQty, 
        removeAnItem, 
        clearACart, 
        checkoutACart
    };
  });