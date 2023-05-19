<script setup lang="ts">
import { computed } from 'vue'
import Furniture from '@/models/Furniture'
import ProductBox from './ProductBox.vue'

const props = defineProps<{
  product: Furniture
}>()

const dimensions = computed(() => {
  return `${props.product.height}x${props.product.width}x${props.product.length}`
})
</script>

<template>
  <ProductBox :product="product">
    <template #more-info>
      <p class="product-box__content__info">Dimensions: {{ dimensions }}</p>
    </template>
  </ProductBox>
</template>
