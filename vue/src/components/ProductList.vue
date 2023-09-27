<template>
    <div id="product_list">
        <div class="m-3 grid place-items-center">
            <ProductSearchBox @handle-search="handleSubmit" />
        </div>
        <div class="flex flex-wrap justify-center mt-3">
            <ProductItem v-for="product in store.products" :product="product" :key="product.id"></ProductItem>
        </div>
    </div>
    
</template>

<script setup lang="ts">
import ProductSearchBox from './ProductSearchBox.vue';
import {useProductStore} from '../store'
import ProductItem from './ProductItem.vue';

const store = useProductStore();
store.fetchAllProducts({'keyword': ''});
const handleSubmit = (key: any) => {
    let payload = {
        'keyword': key
    };

    store.fetchAllProducts(payload);
}
</script>