<script setup lang="ts">
defineProps<{}>()
</script>

<template>
  <header class="header">
    <div class="header__content">
      <p class="header__content__title">
        Product List
      </p>
  
      <slot name="action" />
    </div>
    <hr />
  </header>
</template>
