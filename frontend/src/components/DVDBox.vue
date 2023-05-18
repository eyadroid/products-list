<script setup lang="ts">
import DVD from '@/models/DVD'
import ProductBox from './ProductBox.vue'

defineProps<{
  product: DVD
}>()
</script>

<template>
  <ProductBox :product="product">
    <template #more-info>
      <p class="product-box__content__info">{{ $getSize(product.size) }}</p>
    </template>
  </ProductBox>
</template>
