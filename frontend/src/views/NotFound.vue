<script setup lang="ts">
import { useHead } from '@unhead/vue'

useHead({
  title: 'Page not found'
})
</script>

<template>
  <div class="not-found">
    <p class="not-found__title">404</p>
    <p class="not-found__message">Page not found.</p>
  </div>
</template>
