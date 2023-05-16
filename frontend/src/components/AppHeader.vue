<script setup lang="ts">
defineProps<{
  title: string,
}>()
</script>

<template>
  <header class="header">
    <div class="header__content">
      <p class="header__content__title">
        {{title}}
      </p>
  
      <slot name="action" />
    </div>
    <hr />
  </header>
</template>
