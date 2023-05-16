<script setup lang="ts">
import { computed } from "@vue/runtime-core";
import Product from '@/models/Product';

const props = defineProps<{
    product: Product,
    selected: boolean,
}>()

const emit = defineEmits<{
  select: boolean,
}>();

const checkboxId = computed(() => {
  return `product-checkbox-${props.product.sku}`;
});
</script>

<template>
  <div class="product-box" :class="{'product-box--selected': selected}">
    <input @change="emit('select')" :checked="selected" :id="checkboxId" class="product-box__checkbox delete-checkbox" type="checkbox" />
    <label class="product-box__content" :for="checkboxId">
      <p class="product-box__content__info">{{ product.sku }}</p>
      <p class="product-box__content__info">{{ product.name }}</p>
      <p class="product-box__content__info">{{ product.price }} $</p>
      <slot name="more-info" />
    </label>
  </div>
</template>
