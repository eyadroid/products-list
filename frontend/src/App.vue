<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import {apiService} from './services/apiService';
import { productService } from './services/productService';

// console.log(await productService.getProduct("test574062"));
// console.log(await apiService.get('/products/test574062'));
// console.log(await apiService.post('/products', {
//   sku: "@411",
//   name: "Test",
//   price: 500,
//   type: "dvd",
//   size: "225"
// }));
</script>

<template>
  <RouterView />
</template>
