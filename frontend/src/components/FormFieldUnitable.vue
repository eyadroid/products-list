<script setup lang="ts">
import { ref } from 'vue'
import { watch } from 'vue'

// Allow selectable units and calculate model value with
// the unit multiplayer.

const props = defineProps<{
  units: Array<any>
  modelValue: number
}>()

const emit = defineEmits<{
  'update:modelValue': number
}>()

const inputValue = ref(null)
const selectedUnit = ref(props.units[0].multiplayer)

function inputChanged(val) {
  inputValue.value = val
  emit('update:modelValue', inputValue.value ? inputValue.value * selectedUnit.value : null)
}

watch(selectedUnit, () => {
  inputChanged(inputValue.value)
})
</script>

<template>
  <div class="form__field__input form__field__input--unitable">
    <slot :inputValue="inputValue" :inputChanged="inputChanged" />

    <select v-model="selectedUnit" name="" id="">
      <option v-for="(unit, index) of units" :key="index" :value="unit.multiplayer">
        {{ unit.label }}
      </option>
    </select>
  </div>
</template>
