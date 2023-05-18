<script setup lang="ts">
import Book from '@/models/Book'
import ProductBox from './ProductBox.vue'

defineProps<{
  product: Book
}>()
</script>

<template>
  <ProductBox :product="product">
    <template #more-info>
      <p class="product-box__content__info">{{ $getWeight(product.weight) }}</p>
    </template>
  </ProductBox>
</template>
