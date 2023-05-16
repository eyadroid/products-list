<script setup lang="ts">
defineProps<{
  label: string,
  id: string,
  errors: string[],
  description: string,
}>()
</script>

<template>
  <div class="form__field" :class="{'form__field--error': (errors ?? []).length > 0}">
    <label :for="id" class="form__field__label">
      {{ label }}
    </label>

    <slot />

    <ul class="form__field__errors" v-if="(errors ?? []).length > 0">
      <li class="form__field__errors__error" v-for="(error, idx) of errors" :key="idx">{{ error }}</li>
    </ul>

    <div class="form__field__description" v-if="description">
      {{ description }}
    </div>
  </div>
</template>
