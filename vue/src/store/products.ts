import Api from '../apis'
import { defineStore } from 'pinia'
import { ref, Ref } from 'vue'
import { Product } from '../types'

const useProductStore = defineStore('products', () => {

  const products: Ref<Product[] | null> = ref(null)
  const singleProduct: Ref<Product | null> = ref(null)

  function fetchAllProducts(payload: any) {
    let errorStatus = ''

    Api.post('products', payload)
      .then((response) => {
        const result = response.data
        if (!result.error) {
          products.value = result.products
        } else {
          console.log('error', 'Download Error', result.message)
        }
      })
      .catch((error) => {
        if (!error.response) {
          // network error
          errorStatus = 'Network Error'
        } else {
          errorStatus = error.response.data.message
        }
        console.log('error', 'Server Error', errorStatus)
      })
  }

  function fetchOneProduct(id: number) {
    let errorStatus = ''

    Api.get('products/' + id)
      .then((response) => {
        const result = response.data

        if (!result.error) {
          singleProduct.value = result.product
        } else {
            console.log('error', 'Download Error', result.message)
        }
      })
      .catch((error) => {
        if (!error.response) {
          // network error
          errorStatus = 'Network Error'
        } else {
          errorStatus = error.response.data.message
        }
        console.log('error', 'Server Error', errorStatus)
      })
  }

  return { products, singleProduct, fetchAllProducts, fetchOneProduct }
})

export default useProductStore;